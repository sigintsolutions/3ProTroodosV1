<?php
 
namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

use App\Exports\ReportExport;
use App\Exports\SensorExport;
use App\Exports\Reporthub;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;
use Session;
use Hash;
use Carbon\Carbon;
//use App\Group;
use DB;

class ReportController extends Controller
{
    public function index()
    {
		$sensors = DB::table('sensors')
        ->paginate(10);
		//print_r($groups);
        return view('admin.sensor.index')->with(['sensors'=>$sensors,'hubid'=>$id]);
    }
	
	public function userlog()
	{
	
	ini_set('max_execution_time', 600);

		$agents = DB::table('users')
			->join('role_user', 'role_user.user_id', '=', 'users.id')
			->where('role_user.role_id', 2)
			->get();
		$agents_count=count($agents);
		$sensors = DB::table('sensors')
			//->join('role_user', 'role_user.user_id', '=', 'users.id')
			//->where('role_user.role_id', 2)
			->get();
		$sensors_count=count($sensors);
		$loginagents = DB::table('users')
			->join('role_user', 'role_user.user_id', '=', 'users.id')
			->where('role_user.role_id', 2)
			->where('users.log_status', 1)
			->get();
		$logoutagents = DB::table('users')
			->join('role_user', 'role_user.user_id', '=', 'users.id')
			->where('role_user.role_id', 2)
			->where('users.log_status', 0)
			->get();
		$total=count($loginagents)+count($logoutagents);
		$perlogin=(count($loginagents)/$total)*100;
		$perlogout=(count($logoutagents)/$total)*100;
		
		$sensorsact = DB::table('sensors')
			//->join('role_user', 'role_user.user_id', '=', 'users.id')
			//->where('role_user.role_id', 2)
			->where('sensors.status', 1)
			->get();
		$sensorsdeact = DB::table('sensors')
			//->join('role_user', 'role_user.user_id', '=', 'users.id')
			//->where('role_user.role_id', 2)
			->where('sensors.status', 0)
			->get();
			
		$sensortotal=count($sensorsact)+count($sensorsdeact);
		$perlogin2=(count($sensorsact)/$sensortotal)*100;
		$perlogout2=(count($sensorsdeact)/$sensortotal)*100;
		
		//$groups = DB::table('sensor_groups')
			//->get();
		$groups = DB::table('sensor_groups')
        ->join('gateway_groups', 'gateway_groups.sensor_group_id', '=', 'sensor_groups.id')
		->where('gateway_groups.agent', session()->get('userid'))
		->select('sensor_groups.*', 'gateway_groups.id as id')
		->get();
		$hubs = DB::table('hubs')
			->get();
		/*$items = DB::table('algorithm')
		->join('algorithm_sensor', 'algorithm_sensor.algorithm_id', '=', 'algorithm.id')
		->join('sensors', 'sensors.id', '=', 'algorithm_sensor.sensor')
		->join('users', 'users.id', '=', 'algorithm.userid')
		->where('users.id', session()->get('userid'))
		->select('sensors.*','algorithm.created_at', 'algorithm.push_message', 'algorithm.id as pid')
		->get();*/
		/*$items = DB::table('algorithm')
			->join('algorithm_sensor', 'algorithm_sensor.algorithm_id', '=', 'algorithm.id')
			->join('gateway_groups', 'gateway_groups.id', '=', 'algorithm_sensor.groupid')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('sensor_hubs', 'sensor_hubs.id', '=', 'algorithm_sensor.hub')
			->join('sensors', 'sensors.id', '=', 'algorithm_sensor.sensor')
			->join('users', 'users.id', '=', 'algorithm.userid')
			//->whereRaw('algorithm.created_at between "'.$start.'" and "'.$end.'"')->where('users.id', session()->get('userid'))
			->select('users.fname', 'users.lname', 'sensor_groups.name', 'sensor_hubs.hub_id', 'sensors.sensor_id', 'algorithm.created_at', 'algorithm.push_message', 'algorithm.id as pid')
			->get();*/
/*$items = DB::table('algorithm')
			->join('algorithm_sensor', 'algorithm_sensor.algorithm_id', '=', 'algorithm.id')
			->join('gateway_groups', 'gateway_groups.id', '=', 'algorithm_sensor.groupid')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('sensor_hubs', 'sensor_hubs.id', '=', 'algorithm_sensor.hub')
			->join('sensors', 'sensors.id', '=', 'algorithm_sensor.sensor')->join('userdatamessages', 'userdatamessages.algorithmid', '=', 'algorithm.id')->join('users', 'users.id', '=', 'userdatamessages.userid')->orderBy('userdatamsgid','desc')
			//->join('users', 'users.id', '=', 'algorithm.userid')
			->where('users.id', session()->get('userid'))
			->select('users.fname', 'users.lname', 'sensor_groups.name', 'sensor_hubs.hub_id', 'sensors.sensor_id', 'userdatamessages.created_at', 'algorithm.push_message', 'algorithm.id as pid','userdatamessages.readflaguserid','userdatamessages.userdatamsgid as udi')
			->paginate(100);	*/

/*$items = DB::table('algorithm')->join('userdatamessages', 'userdatamessages.algorithmid', '=', 'algorithm.id')->join('users', 'users.id', '=', 'userdatamessages.userid')->orderBy('userdatamsgid','desc')->where('users.id', session()->get('userid'))->select('users.fname', 'users.lname','userdatamessages.created_at', 'algorithm.push_message', 'algorithm.id as pid','userdatamessages.readflag','userdatamessages.userdatamsgid as udi','userdatamessages.*')->paginate(1000);*/
$items=array();		
$countmsgdt=array();	
			//$countmsgdt=DB::table('userdatamessages')->where('readflag',0)->get();
				//$countmsg=count($countmsgdt);


//$countmsgdt=DB::table('algorithm')->where('userid',session()->get('userid'))->where('readflaguserid',0)->get();

			/*$countmsgdt=DB::table('userdatamessages')->where('userid',session()->get('userid'))->where('readflaguserid',0)->get();*/
				$countmsg=count($countmsgdt);
				$countmsgagent=count($countmsgdt);

$currentoffset=0;
$pageno=0;
$currentoffsethub=0;
$pagenohub=0;
//dd("hello");	
		return view('agent.report.index')->with(['sensors'=>$sensors,'agents'=>$agents,'agents_count'=>$agents_count,'sensors_count'=>$sensors_count,'perlogin'=>$perlogin,'perlogout'=>$perlogout,'perlogin2'=>$perlogin2,'perlogout2'=>$perlogout2,'groups'=>$groups,'hubs'=>$hubs, 'messages'=>$items,'countmsgagent'=>$countmsgagent,'currentoffset'=>$currentoffset,'pageno'=>$pageno,'currentoffsethub'=>$currentoffsethub,'pagenohub'=>$pagenohub]);
	}
	
	public function uppushmsgreadflagcount(){
		//$countmsgdt=DB::table('algorithm')->where('userid',session()->get('userid'))->where('readflaguserid',0)->get();


		$countmsgdt=DB::table('userdatamessages')->where('userid',session()->get('userid'))->where('readflaguserid',0)->get();
				$countmsg=count($countmsgdt);
				echo $countmsg;
	}
	public function uppushmsgreadflag()
	{
		$msgid=$_GET['msgid'];
		if($msgid == 'all')
		{
			$upread = DB::table('userdatamessages')->where('userid',session()->get('userid'))->where('readflaguserid', '0')->update(['readflaguserid'=>1]);
		}
		else
		{
			$upread = DB::table('userdatamessages')->where('userdatamsgid',$msgid)->update(['readflaguserid'=>1]);
		}
		echo "1";
	}
	public function getlog(Request $request)
	{
		$id = $request->input('log');
		switch($id){
		case 'inactagent':
        $items = DB::table('users')
			->join('role_user', 'role_user.user_id', '=', 'users.id')
			->where('role_user.role_id', 2)
			->where('users.log_status', 0)
			->paginate(10);
        break;
		
		case 'actsensor':
        $items = DB::table('sensors')
			//->join('role_user', 'role_user.user_id', '=', 'users.id')
			//->where('role_user.role_id', 2)
			->where('sensors.status', 1)
			->paginate(10);
        break;
		
		case 'inactsensor':
        $items = DB::table('sensors')
			//->join('role_user', 'role_user.user_id', '=', 'users.id')
			//->where('role_user.role_id', 2)
			->where('sensors.status', 0)
			->paginate(10);
        break;
		 default:
		 $items = DB::table('users')
			->join('role_user', 'role_user.user_id', '=', 'users.id')
			->where('role_user.role_id', 2)
			->where('users.log_status', 1)
			->paginate(10);
		}
		//print_r($items);exit;
		return view('admin.report.pagination_data')->with(['items'=>$items]);
		//print_r($items);exit;
	}
	
	function fetch_data(Request $request)
    {
//     if($request->ajax())
//     {
//      //$sort_by = $request->get('sortby');
//      //$sort_type = $request->get('sorttype');
//            $query = $request->get('query');
//            $query = str_replace(" ", "%", $query);
//      $data = DB::table('post')
//                    ->where('id', 'like', '%'.$query.'%')
//                    ->orWhere('post_title', 'like', '%'.$query.'%')
//                    ->orWhere('post_description', 'like', '%'.$query.'%')
//                    ->orderBy($sort_by, $sort_type)
//                    ->paginate(5);
//      return view('pagination_data', compact('data'))->render();
//     }

		$id = $request->input('log');
		switch($id){
		case 'inactagent':
        $items = DB::table('users')
			->join('role_user', 'role_user.user_id', '=', 'users.id')
			->where('role_user.role_id', 2)
			->where('users.log_status', 0)
			->paginate(10);
        break;
		
		case 'actsensor':
        $items = DB::table('sensors')
			//->join('role_user', 'role_user.user_id', '=', 'users.id')
			//->where('role_user.role_id', 2)
			->where('sensors.status', 1)
			->paginate(10);
        break;
		
		case 'inactsensor':
        $items = DB::table('sensors')
			//->join('role_user', 'role_user.user_id', '=', 'users.id')
			//->where('role_user.role_id', 2)
			->where('sensors.status', 0)
			->paginate(10);
        break;
		 default:
		 $items = DB::table('users')
			->join('role_user', 'role_user.user_id', '=', 'users.id')
			->where('role_user.role_id', 2)
			->where('users.log_status', 1)
			->paginate(10);
		}
		return view('admin.report.pagination_data')->with(['items'=>$items]);

    }









public function getChart(Request $request){

//$agent = $request->input('agent');
	$agent = session()->get('userid');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$sensor = $request->input('sensor');
		$tme = $request->input('tme');
		
		$hub = implode(",",$hub);
		$hubs = DB::table('sensor_hubs')->whereRaw('id in ('.$hub.')')->get();		
		foreach($hubs as $hubname)
		{
			$hubsname[] = $hubname->hub_id;
		}

$hubsidlist=array();
		foreach($hubs as $hubids)
		{
			$hubsidlist[] = $hubids->id;
		}
		//dd();
		//$sensor = implode( ",", $sensor);
		$unit = urldecode($request->input('unit')); 
		$chartnam = $request->input('chartnam');
		$noofselectedsensors = count($sensor);
		$sensorselectedhub=DB::table('sensors')->where('agent',$agent)->whereIn('hub_id',$hubsidlist)->get();
		$noofselectedsensorshub=count($sensorselectedhub);
		//dd($sensorselectedhub,$noofselectedsensorshub);
		$sensorshub=array();
		$sensorshub1=array();
		$shub=array();
		/*foreach($sensorselectedhub as $sn){
			$sensorshub[]=$sn->sensor_id;
			$hubdt=DB::table('sensor_hubs')->where('id',$sn->hub_id)->first();
			$shub[]=$hubdt->hub_id;
			$combined="$hubdt->hub_id"."_".$sn->sensor_id;
$sensorshub1[]=$combined;

		}	*/

		//dd($sensorshub1,$shub);
		$arr=array();
		$arr['count']=0;
$sensors=array();
$sensorshubs=array();
		$hubscount = DB::table('sensors')
			->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
			->whereIn('sensors.hub_id',$hubsidlist)->where('sensors.agent',$agent)
				->whereIn('sensors.group_id',$group)
			->groupBy('hub_id','sensor_id')
			->select('sensors.hub_id','sensors.sensor_id')
			->get();
			//dd($hubsidlist,$hubscount);
    foreach($hubscount as $hubscounts)
			{
				$getudt=DB::table('sensors')->where('sensor_id',$hubscounts->sensor_id)->where('hub_id',$hubscounts->hub_id)->first();
				$gethdt=DB::table('sensor_hubs')->where('id',$hubscounts->hub_id)->first();
				$unit1[] = $getudt->unit;
				//$unit1[] = '*C';
				$sensors[]=$hubscounts->sensor_id;
				$sensorshubs[]=$gethdt->hub_id;


				$combined="$gethdt->hub_id"."__".$hubscounts->sensor_id;
$sensorshub1[]=$combined;
$getchtdt=DB::table('chart')->where('unit',$getudt->unit)->first();

//$chart1[]=$getchtdt->name;

//$chart1[]="AreaChart";

			}
			//dd($sensorshub1);
			//dd($sensors,$sensorshubs);
		if($tme=='week')
		{
$start_week = strtotime("-6 day");
				$end_week = strtotime("+1 day");
				$start_week = date("Y-m-d",$start_week);
				$end_week = date("Y-m-d",$end_week);
$loginid=session()->get('userid');
//DB::enableQueryLog();
/*$groups=DB::table('dbo_payloadercharttemp as db')->where('db.unit', $unit)->whereIn('db.hub', $hubsname)->whereRaw('db.time between "'.$start_week.'" and "'.$end_week.'"')->whereIn('db.sensor_id', $sensor)->where('loginid',$loginid)->select('db.value','db.utc','db.sensor_id','db.hub','db.hub_sensorid')->get();*/
$groups=DB::table('dbo_payloadercharttemp as db')->where('loginid',$loginid)->select('db.value','db.utc','db.sensor_id','db.hub','db.hub_sensorid','db.agentname','db.gatewaygrp')->orderby('id','desc')->get();

//dd(DB::getQueryLog());
//dd($loginid,$groups);
$arrv=array();
$arrt=array();
$arrg=array();
foreach($groups as $gp){
	$agentname=$gp->agentname;
	for($m=0;$m<count($sensorshub1);$m++){

if ($gp->hub_sensorid==$sensorshub1[$m]){
	
	$senname=$sensorshub1[$m];

$val=str_replace(","," ","$gp->utc");
$arrv["$senname"][]=$gp->value;
$arrt["$senname"][]=$val;
$arrg["$senname"][]=$gp->gatewaygrp;
}


	}
	

}
$keyarr=array();

foreach($arrv as $key => $value){

    $keyarr[]=$key;

}


$countdatasensors=count($keyarr);
$arrstringval=array();
		$arrstringhour=array();	

			for($h=0;$h<count($keyarr);$h++)		
					{

						$sennamek=$keyarr[$h];

$sensorvalues=implode(",",$arrv["$sennamek"]);
$sensorhour=implode(",",$arrt["$sennamek"]);
$arr['value'][$h][] =$sensorvalues;						
							
$arr['hour'][$h][] =$sensorhour;

$exp=explode("__",$sennamek);
$sennameknew=$exp[1];
$hubnew=$exp[0];
$getsensdt=DB::table('sensors as sen')->join('sensor_hubs', 'sensor_hubs.id', '=', 'sen.hub_id')->where('sen.agent',$agent)->where('sensor_id',$sennameknew)->where('sensor_hubs.hub_id',$hubnew)->first();



$unitlt=$unit;
//$unitlt=$getsensdt->unit;
$getchtdt=DB::table('chart')->where('unit',$unitlt)->first();
							
$arr['chart'][$h]=$getchtdt->name;
	
$arr['unit'][$h] =$unitlt;	
							
	$arr['hub'][$h] =$hubnew."/".$agentname;	

$arr['sensor_id'][$h] =$sennameknew;
	$arr['grouphub'][$h]=$arrg["$sennamek"][0];								




					}
					
					$arr['count'] =$countdatasensors;
					$arr['countval'] = count($groups);


}
if($tme=='day')
		{

$loginid=session()->get('userid');

/*$groups=DB::table('dbo_payloadercharttemp as db')->where('db.unit', $unit)->whereIn('db.hub', $hubsname)->whereDate('db.time', Carbon::today())->whereIn('db.sensor_id', $sensor)->where('loginid',$loginid)->select('db.value','db.utc','db.sensor_id','db.hub','db.hub_sensorid')->get();*/
$groups=DB::table('dbo_payloadercharttemp as db')->where('loginid',$loginid)->select('db.value','db.utc','db.sensor_id','db.hub','db.hub_sensorid','db.agentname','db.gatewaygrp')->orderby('id','desc')->get();

$arrv=array();
$arrt=array();
$arrg=array();

foreach($groups as $gp){
	$agentname=$gp->agentname;
	for($m=0;$m<count($sensorshub1);$m++){

if ($gp->hub_sensorid==$sensorshub1[$m]){
	
	$senname=$sensorshub1[$m];

$val=str_replace(","," ","$gp->utc");
$arrv["$senname"][]=$gp->value;
//$arrt["$senname"][]=$gp->utc;

$arrt["$senname"][]=$val;
$arrg["$senname"][]=$gp->gatewaygrp;
}


	}
	

}
$keyarr=array();

foreach($arrv as $key => $value){

    $keyarr[]=$key;

}


$countdatasensors=count($keyarr);
$arrstringval=array();
		$arrstringhour=array();	

			for($h=0;$h<count($keyarr);$h++)		
					{

						$sennamek=$keyarr[$h];

$sensorvalues=implode(",",$arrv["$sennamek"]);
$sensorhour=implode(",",$arrt["$sennamek"]);
$arr['value'][$h][] =$sensorvalues;						
							
$arr['hour'][$h][] =$sensorhour;

$exp=explode("__",$sennamek);
$sennameknew=$exp[1];
$hubnew=$exp[0];
$getsensdt=DB::table('sensors as sen')->join('sensor_hubs', 'sensor_hubs.id', '=', 'sen.hub_id')->where('sen.agent',$agent)->where('sensor_id',$sennameknew)->where('sensor_hubs.hub_id',$hubnew)->first();


$unitlt=$unit;

//$unitlt=$getsensdt->unit;
$getchtdt=DB::table('chart')->where('unit',$unitlt)->first();
							
$arr['chart'][$h]=$getchtdt->name;
	
$arr['unit'][$h] =$unitlt;	
							
	//$arr['hub'][$h] =$hubnew;	
$arr['hub'][$h] =$hubnew."/".$agentname;
$arr['sensor_id'][$h] =$sennameknew;
$arr['grouphub'][$h]=$arrg["$sennamek"][0];									




					}
					
					$arr['count'] =$countdatasensors;
					$arr['countval'] = count($groups);
}
if($tme=='month')
		{
$start_month = strtotime("-29 day");
				$end_month = strtotime("+1 day");
				$start_month = date("Y-m-d",$start_month);
				$end_month = date("Y-m-d",$end_month);

$loginid=session()->get('userid');

/*$groups=DB::table('dbo_payloadercharttemp as db')->where('db.unit', $unit)->whereIn('db.hub', $hubsname)->whereRaw('db.time between "'.$start_month.'" and "'.$end_month.'"')->whereIn('db.sensor_id', $sensor)->where('loginid',$loginid)->select('db.value','db.utc','db.sensor_id','db.hub','db.hub_sensorid')->get();*/
$groups=DB::table('dbo_payloadercharttemp as db')->where('loginid',$loginid)->select('db.value','db.utc','db.sensor_id','db.hub','db.hub_sensorid','db.agentname','db.gatewaygrp')->orderby('id','desc')->get();

$arrv=array();
$arrt=array();
$arrg=array();

foreach($groups as $gp){
	$agentname=$gp->agentname;
	for($m=0;$m<count($sensorshub1);$m++){

if ($gp->hub_sensorid==$sensorshub1[$m]){
	
	$senname=$sensorshub1[$m];

$val=str_replace(","," ","$gp->utc");
$arrv["$senname"][]=$gp->value;
//$arrt["$senname"][]=$gp->utc;

$arrt["$senname"][]=$val;
$arrg["$senname"][]=$gp->gatewaygrp;
/*$arrv["$senname"][]=$gp->value;
$arrt["$senname"][]=$gp->utc;*/



}


	}
	

}
$keyarr=array();

foreach($arrv as $key => $value){

    $keyarr[]=$key;

}


$countdatasensors=count($keyarr);
$arrstringval=array();
		$arrstringhour=array();	

			for($h=0;$h<count($keyarr);$h++)		
					{

						$sennamek=$keyarr[$h];

$sensorvalues=implode(",",$arrv["$sennamek"]);
$sensorhour=implode(",",$arrt["$sennamek"]);
$arr['value'][$h][] =$sensorvalues;						
							
$arr['hour'][$h][] =$sensorhour;

$exp=explode("__",$sennamek);
$sennameknew=$exp[1];
$hubnew=$exp[0];
//$getsensdt=DB::table('sensors as sen')->join('sensor_hubs', 'sensor_hubs.id', '=', 'sen.hub_id')->where('sen.agent',$agent)->where('sensor_id',$sennameknew)->where('sensor_hubs.hub_id',$hubnew)->first();



$unitlt=$unit;
//$unitlt=$getsensdt->unit;
$getchtdt=DB::table('chart')->where('unit',$unitlt)->first();
							
$arr['chart'][$h]=$getchtdt->name;
	
$arr['unit'][$h] =$unitlt;	
							
	//$arr['hub'][$h] =$hubnew;	
$arr['hub'][$h] =$hubnew."/".$agentname;

$arr['sensor_id'][$h] =$sennameknew;
									
$arr['grouphub'][$h]=$arrg["$sennamek"][0];



					}
					
					$arr['count'] =$countdatasensors;
					$arr['countval'] = count($groups);






	}				
if($tme=='one')
		{
$start = date("Y-m-d",strtotime($request->input('from')));
				$end = date("Y-m-d",strtotime($request->input('to')."+1 day"));

				

$loginid=session()->get('userid');

/*$groups=DB::table('dbo_payloadercharttemp as db')->where('db.unit', $unit)->whereIn('db.hub', $hubsname)->whereRaw('db.time between "'.$start.'" and "'.$end.'"')->whereIn('db.sensor_id', $sensor)->where('loginid',$loginid)->select('db.value','db.utc','db.sensor_id','db.hub','db.hub_sensorid')->get();*/
$groups=DB::table('dbo_payloadercharttemp as db')->where('loginid',$loginid)->select('db.value','db.utc','db.sensor_id','db.hub','db.hub_sensorid','db.agentname','db.gatewaygrp')->orderby('id','desc')->get();

$arrv=array();
$arrt=array();
$arrg=array();

foreach($groups as $gp){
	$agentname=$gp->agentname;
	for($m=0;$m<count($sensorshub1);$m++){

if ($gp->hub_sensorid==$sensorshub1[$m]){
	
	$senname=$sensorshub1[$m];


/*$arrv["$senname"][]=$gp->value;
$arrt["$senname"][]=$gp->utc;*/
$val=str_replace(","," ","$gp->utc");
$arrv["$senname"][]=$gp->value;
//$arrt["$senname"][]=$gp->utc;

$arrt["$senname"][]=$val;
$arrg["$senname"][]=$gp->gatewaygrp;


}


	}
	

}
$keyarr=array();

foreach($arrv as $key => $value){

    $keyarr[]=$key;

}


$countdatasensors=count($keyarr);
$arrstringval=array();
		$arrstringhour=array();	

			for($h=0;$h<count($keyarr);$h++)		
					{

						$sennamek=$keyarr[$h];

$sensorvalues=implode(",",$arrv["$sennamek"]);
$sensorhour=implode(",",$arrt["$sennamek"]);
$arr['value'][$h][] =$sensorvalues;						
							
$arr['hour'][$h][] =$sensorhour;

$exp=explode("__",$sennamek);
$sennameknew=$exp[1];
$hubnew=$exp[0];
$getsensdt=DB::table('sensors as sen')->join('sensor_hubs', 'sensor_hubs.id', '=', 'sen.hub_id')->where('sen.agent',$agent)->where('sensor_id',$sennameknew)->where('sensor_hubs.hub_id',$hubnew)->first();


$unitlt=$unit;

//$unitlt=$getsensdt->unit;
$getchtdt=DB::table('chart')->where('unit',$unitlt)->first();
							
$arr['chart'][$h]=$getchtdt->name;
	
$arr['unit'][$h] =$unitlt;	
							
	//$arr['hub'][$h] =$hubnew;
	$arr['hub'][$h] =$hubnew."/".$agentname;	
$arr['grouphub'][$h]=$arrg["$sennamek"][0];
$arr['sensor_id'][$h] =$sennameknew;
									




					}
					
					$arr['count'] =$countdatasensors;
					$arr['countval'] = count($groups);



}

//}


return json_encode($arr);

}


public function deletetempdata(){
	$loginid=session()->get('userid');
$deldt=DB::table('dbo_payloadercharttemp')->where('loginid',$loginid)->delete();
echo "1";

}










public function getChart_22_8_2020(Request $request)
	{  
		//$agent = $request->input('agent');
		$agent=session()->get('userid');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$sensor = $request->input('sensor');
		$tme = $request->input('tme');
		//$agent = implode(",",$agent);
		//$group = implode(",",$group);
		$hub = implode(",",$hub);
		$hubs = DB::table('sensor_hubs')->whereRaw('id in ('.$hub.')')->get();		
		foreach($hubs as $hubname)
		{
			$hubsname[] = $hubname->hub_id;
		}
		//$sensor = implode( ",", $sensor);
		$unit = urldecode($request->input('unit')); 
		$chartnam = $request->input('chartnam');
		$noofselectedsensors = count($sensor);
		$arr=array();
		$arr['count'] =0;
		if($tme=='week')
		{
			foreach($sensor as $sensorname) 
			{
				$start_week = strtotime("-6 day");
				$end_week = strtotime("+1 day");
				$start_week = date("Y-m-d",$start_week);
				$end_week = date("Y-m-d",$end_week);	
				/*$groups = DB::table('sensors')
				->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
				->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
				->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
				->join('users', 'sensor_hubs.agent', '=', 'users.id')
				->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
				->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')
				->whereRaw('users.id = "'.$agent.'"')
				->where('dbo_payloader.unit', $unit)
				->whereIn('gateway_groups.id', $group)
				->whereIn('dbo_payloader.hub', $hubsname)
				->whereIn('dbo_payloader.sensor_id', $sensor)
				
				->select(array('dbo_payloader.*'))
				
				->get();*/

$loginid=session()->get('userid');
$groups=DB::table('dbo_payloadercharttemp')->where('dbo_payloadercharttemp.unit', $unit)->whereIn('dbo_payloadercharttemp.hub', $hubsname)->whereRaw('dbo_payloadercharttemp.time between "'.$start_week.'" and "'.$end_week.'"')->where('loginid',$loginid)->whereIn('dbo_payloadercharttemp.sensor_id', $sensor)->select(array('dbo_payloadercharttemp.*'))->orderby('id','asc')->get();





				
				if(count($groups)>0)
				{
					foreach($groups as $item)
					{
						for($h=0;$h<$noofselectedsensors;$h++)
						{
							if ($item->sensor_id == $sensor[$h])
							{
								$arr['value'][$h][] = $item->value;
								$arr['hour'][$h][] = $item->utc;
								$arr['chart'][0] = $chartnam;
								$arr['hub'][$h] = $item->hub;
								$arr['sensor_id'][$h] = $item->sensor_id;
								$arr['unit'][$h] = $item->unit;
							}
						}
					}
					$arr['count'] = $noofselectedsensors;			
				}
			}
		}
		if($tme=='day')
		{
			foreach($sensor as $sensorname) 
			{
				/*$groups = DB::table('sensors')
				->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
				->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
				->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
				->join('users', 'sensor_hubs.agent', '=', 'users.id')
				->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
				->whereRaw('users.id = "'.$agent.'"')
				->where('dbo_payloader.unit', $unit)
				->whereIn('gateway_groups.id', $group)
				->whereIn('dbo_payloader.hub', $hubsname)
				->whereIn('dbo_payloader.sensor_id', $sensor)
				->whereDate('dbo_payloader.time', Carbon::today())
				->orderBy('dbo_payloader.sensor_id')
				->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
				->get();*/

$loginid=session()->get('userid');
$groups=DB::table('dbo_payloadercharttemp')->where('dbo_payloadercharttemp.unit', $unit)->whereIn('dbo_payloadercharttemp.hub', $hubsname)->whereDate('dbo_payloadercharttemp.time', Carbon::today())->where('loginid',$loginid)->whereIn('dbo_payloadercharttemp.sensor_id', $sensor)->orderby('id','asc')->get();



				//$arr=array();
				if(count($groups)>0)
				{
					foreach($groups as $item)
					{
						for($h=0;$h<$noofselectedsensors;$h++)
						{
							if ($item->sensor_id == $sensor[$h])
							{
								$arr['value'][$h][] = $item->value;
								$arr['hour'][$h][] = $item->utc;
								$arr['chart'][0] = $chartnam;
								$arr['hub'][$h] = $item->hub;
								$arr['sensor_id'][$h] = $item->sensor_id;
								$arr['unit'][$h] = $item->unit;
							}
						}
					}
					$arr['count'] = $noofselectedsensors;			
				}
			}
		}
		if($tme=='month')
		{
			foreach($sensor as $sensorname) 
			{
				$start_month = strtotime("-29 day");
				$end_month = strtotime("+1 day");
				$start_month = date("Y-m-d",$start_month);
				$end_month = date("Y-m-d",$end_month);
				/*$groups = DB::table('sensors')
				->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
				->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
				->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
				->join('users', 'sensor_hubs.agent', '=', 'users.id')
				->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
				->whereRaw('users.id = "'.$agent.'"')
				->where('dbo_payloader.unit', $unit)
				->whereIn('gateway_groups.id', $group)
				->whereIn('dbo_payloader.hub', $hubsname)
				->whereIn('dbo_payloader.sensor_id', $sensor)
				->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')		
				->select(array('dbo_payloader.*'))
				->get();*/
				
//$deldt=DB::table('dbo_payloadercharttemp')->delete();
				//dd("en...");
				$loginid=session()->get('userid');
$groups=DB::table('dbo_payloadercharttemp')->where('dbo_payloadercharttemp.unit', $unit)->whereIn('dbo_payloadercharttemp.hub', $hubsname)->whereRaw('dbo_payloadercharttemp.time between "'.$start_month.'" and "'.$end_month.'"')->where('loginid',$loginid)->whereIn('dbo_payloadercharttemp.sensor_id', $sensor)->select(array('dbo_payloadercharttemp.*'))->orderby('id','asc')->get();

				//$arr=array();
				if(count($groups)>0)
				{
					foreach($groups as $item)
					{
						for($h=0;$h<$noofselectedsensors;$h++)
						{
							if ($item->sensor_id == $sensor[$h])
							{
								$arr['value'][$h][] = $item->value;
								$arr['hour'][$h][] = $item->utc;
								$arr['chart'][0] = $chartnam;
								$arr['hub'][$h] = $item->hub;
								$arr['sensor_id'][$h] = $item->sensor_id;
								$arr['unit'][$h] = $item->unit;
							}
						}
					}
					$arr['count'] = $noofselectedsensors;			
				}
			}
		}
		if($tme=='one')
		{
			foreach($sensor as $sensorname) 
			{
				$start = date("Y-m-d",strtotime($request->input('from')));
				$end = date("Y-m-d",strtotime($request->input('to')."+1 day"));
				/*$groups = DB::table('sensors')
				->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
				->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
				->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
				->join('users', 'sensor_hubs.agent', '=', 'users.id')
				->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
				->join('chart', 'chart.unit', '=', 'sensors.unit')
				->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')
				->whereRaw('users.id = "'.$agent.'"')
				->where('dbo_payloader.unit', $unit)
				->whereIn('gateway_groups.id', $group)
				->whereIn('dbo_payloader.hub', $hubsname)
				->whereIn('dbo_payloader.sensor_id', $sensor)
				->select(array('dbo_payloader.*','chart.name as chartname'))
				->get();*/

$loginid=session()->get('userid');
$groups=DB::table('dbo_payloadercharttemp')->where('dbo_payloadercharttemp.unit', $unit)->whereIn('dbo_payloadercharttemp.hub', $hubsname)->whereRaw('dbo_payloadercharttemp.time between "'.$start.'" and "'.$end.'"')->where('loginid',$loginid)->whereIn('dbo_payloadercharttemp.sensor_id', $sensor)->select(array('dbo_payloadercharttemp.*'))->orderby('id','asc')->get();



				//$arr=array();
				if(count($groups)>0)
				{
					foreach($groups as $item)
					{
						for($h=0;$h<$noofselectedsensors;$h++)
						{
							if ($item->sensor_id == $sensor[$h])
							{
								$arr['value'][$h][] = $item->value;
								$arr['hour'][$h][] = $item->utc;
								$arr['chart'][0] = $chartnam;
								$arr['hub'][$h] = $item->hub;
								$arr['sensor_id'][$h] = $item->sensor_id;
								$arr['unit'][$h] = $item->unit;
							}
						}
					}
					$arr['count'] = $noofselectedsensors;			
				}
			}
		}
		return json_encode($arr);
	}	






	public function getChart_22_7_2020(Request $request)
	{  
		$agent = session()->get('userid');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$sensor = $request->input('sensor');
		$tme = $request->input('tme');
		//$agent = implode(",",$agent);
		$group = implode(",",$group);
		$hub = implode(",",$hub);
		$hubs = DB::table('sensor_hubs')->whereRaw('id in ('.$hub.')')->get();		
		foreach($hubs as $hubname)
		{
			$hubsname[] = $hubname->hub_id;
		}
		//$sensor = implode( ",", $sensor);
		$unit = urldecode($request->input('unit')); 
		$chartnam = $request->input('chartnam');
		$noofselectedsensors = count($sensor);
		if($tme=='week')
		{
			foreach($sensor as $sensorname) 
			{
				$start_week = strtotime("-6 day");
				$end_week = strtotime("+1 day");
				$start_week = date("Y-m-d",$start_week);
				$end_week = date("Y-m-d",$end_week);	
				$groups = DB::table('sensors')
				->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
				->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
				->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
				->join('users', 'sensor_hubs.agent', '=', 'users.id')
				->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
				->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')
				->whereRaw('users.id = "'.$agent.'"')
				->where('dbo_payloader.unit', $unit)
				->whereRaw('gateway_groups.id in ('.$group.')')
				->whereIn('dbo_payloader.hub', $hubsname)
				->whereIn('dbo_payloader.sensor_id', $sensor)
				->select(array('dbo_payloader.*'))
				//->groupBy('date')
				->get();
				$arr=array();
				if(count($groups)>0)
				{
					foreach($groups as $item)
					{
						for($h=0;$h<$noofselectedsensors;$h++)
						{
							if ($item->sensor_id == $sensor[$h])
							{
								$arr['value'][$h][] = $item->value;
								$arr['hour'][$h][] = $item->time;
								$arr['chart'][0] = $chartnam;
								$arr['hub'][$h] = $item->hub;
								$arr['sensor_id'][$h] = $item->sensor_id;
								$arr['unit'][$h] = $item->unit;
							}
						}
					}
					$arr['count'] = $noofselectedsensors;			
				}
			}
		}
		if($tme=='day')
		{
			foreach($sensor as $sensorname) 
			{
				$groups = DB::table('sensors')
				->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
				->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
				->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
				->join('users', 'sensor_hubs.agent', '=', 'users.id')
				->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
				->whereRaw('users.id = "'.$agent.'"')
				->where('dbo_payloader.unit', $unit)
				->whereRaw('gateway_groups.id in ('.$group.')')
				->whereIn('dbo_payloader.hub', $hubsname)
				->whereIn('dbo_payloader.sensor_id', $sensor)
				->whereDate('dbo_payloader.time', Carbon::today())
				->orderBy('dbo_payloader.sensor_id')
				->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
				->get();
				$arr=array();
				if(count($groups)>0)
				{
					foreach($groups as $item)
					{
						for($h=0;$h<$noofselectedsensors;$h++)
						{
							if ($item->sensor_id == $sensor[$h])
							{
								$arr['value'][$h][] = $item->value;
								$arr['hour'][$h][] = $item->time;
								$arr['chart'][0] = $chartnam;
								$arr['hub'][$h] = $item->hub;
								$arr['sensor_id'][$h] = $item->sensor_id;
								$arr['unit'][$h] = $item->unit;
							}
						}
					}
					$arr['count'] = $noofselectedsensors;			
				}
			}
		}
		if($tme=='month')
		{
			foreach($sensor as $sensorname) 
			{
				$start_month = strtotime("-29 day");
				$end_month = strtotime("+1 day");
				$start_month = date("Y-m-d",$start_month);
				$end_month = date("Y-m-d",$end_month);
				$groups = DB::table('sensors')
				->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
				->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
				->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
				->join('users', 'sensor_hubs.agent', '=', 'users.id')
				->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
				->whereRaw('users.id = "'.$agent.'"')
				->where('dbo_payloader.unit', $unit)
				->whereRaw('gateway_groups.id in ('.$group.')')
				->whereIn('dbo_payloader.hub', $hubsname)
				->whereIn('dbo_payloader.sensor_id', $sensor)
				//->whereMonth('dbo_payloader.time', '=', Carbon::now()->subMonth()->month)
				->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')
				//->groupBy(DB::raw('DATE(dbo_payloader.time)'))
				->select(array('dbo_payloader.*'))
				->get();
				$arr=array();
				if(count($groups)>0)
				{
					foreach($groups as $item)
					{
						for($h=0;$h<$noofselectedsensors;$h++)
						{
							if ($item->sensor_id == $sensor[$h])
							{
								$arr['value'][$h][] = $item->value;
								$arr['hour'][$h][] = $item->time;
								$arr['chart'][0] = $chartnam;
								$arr['hub'][$h] = $item->hub;
								$arr['sensor_id'][$h] = $item->sensor_id;
								$arr['unit'][$h] = $item->unit;
							}
						}
					}
					$arr['count'] = $noofselectedsensors;			
				}
			}
		}
		if($tme=='one')
		{
			foreach($sensor as $sensorname) 
			{
				$start = date("Y-m-d",strtotime($request->input('from')));
				$end = date("Y-m-d",strtotime($request->input('to')."+1 day"));
				$groups = DB::table('sensors')
				->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
				->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
				->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
				->join('users', 'sensor_hubs.agent', '=', 'users.id')
				->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
				->join('chart', 'chart.unit', '=', 'sensors.unit')
				->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')
				->whereRaw('users.id = "'.$agent.'"')
				->where('dbo_payloader.unit', $unit)
				->whereRaw('gateway_groups.id in ('.$group.')')
				->whereIn('dbo_payloader.hub', $hubsname)
				->whereIn('dbo_payloader.sensor_id', $sensor)
				->select(array('dbo_payloader.*','chart.name as chartname'))
				->get();
				$arr=array();
				if(count($groups)>0)
				{
					foreach($groups as $item)
					{
						for($h=0;$h<$noofselectedsensors;$h++)
						{
							if ($item->sensor_id == $sensor[$h])
							{
								$arr['value'][$h][] = $item->value;
								$arr['hour'][$h][] = $item->time;
								$arr['chart'][0] = $chartnam;
								$arr['hub'][$h] = $item->hub;
								$arr['sensor_id'][$h] = $item->sensor_id;
								$arr['unit'][$h] = $item->unit;
							}
						}
					}
					$arr['count'] = $noofselectedsensors;			
				}
			}
		}
		return json_encode($arr);
	}	








public function getsensortimefetchpage(Request $request)
	{

//$agent = $request->input('agent');
		$agent = session()->get('userid');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$sensor = $request->input('sensor');
		$tme = $request->input('tme');
		
		$hub = implode(",",$hub);
		$hubs = DB::table('sensor_hubs')->whereRaw('id in ('.$hub.')')->get();	
			
		foreach($hubs as $hubname)
		{
			$hubsname[] = $hubname->hub_id;
		}
		$hub = implode(',', $hubsname);
		$unit = urldecode($request->input('unit'));

$hubsidlist=array();
		foreach($hubs as $hubids)
		{
			$hubsidlist[] = $hubids->id;
		}
		//dd($hubsidlist);
$hubscount = DB::table('sensors')
			->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
			->whereIn('sensors.hub_id',$hubsidlist)->where('sensors.agent',$agent)->whereIn('sensors.sensor_id',$sensor)
				->whereIn('sensors.group_id',$group)
			->groupBy('hub_id','sensor_id')
			->select('sensors.hub_id','sensors.sensor_id')
			->get();
			
    foreach($hubscount as $hubscounts)
			{
				$getudt=DB::table('sensors')->where('sensor_id',$hubscounts->sensor_id)->where('hub_id',$hubscounts->hub_id)->first();
				$gethdt=DB::table('sensor_hubs')->where('id',$hubscounts->hub_id)->first();
				$unit1[] = $getudt->unit;
				//$unit1[] = '*C';
				$sensors[]=$hubscounts->sensor_id;
				$sensorshubs[]=$gethdt->hub_id;


				$combined="$gethdt->hub_id"."_".$hubscounts->sensor_id;
$sensorshub1[]=$combined;
$getchtdt=DB::table('chart')->where('unit',$getudt->unit)->first();



$chart1[]="AreaChart";

			}






if($tme=='week')
		{	
			$start_week = strtotime("-6 day");
			$end_week = strtotime("+1 day");
			
			$start_week = date("Y-m-d",$start_week);
			$end_week = date("Y-m-d",$end_week);
			
$currentoffset=$request->input('currentoffset');
		
		$pageno=$request->input('pageno');

//$currentoffset=$currentoffset+500;
		
$currentoffset=$pageno*100;
$skip=$currentoffset;
/*$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')->whereIn('dbo_payloader.sensor_id', $sensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();*/
/*$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereRaw('db.time between "'.$start_week.'" and "'.$end_week.'"')->orderby('db.id','desc')->skip($skip)->select('db.*');
for($i=0;$i<count($sensorshubs);$i++){
	if($i==0){
$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
else{
$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
}
$items=$query->take(100)->get();*/
$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereRaw('db.time between "'.$start_week.'" and "'.$end_week.'"')->orderby('db.id','desc')->skip($skip)->select('db.*');

$query->where(function($query) use ($sensorshubs, $sensors)
{
	for($i=0;$i<count($sensorshubs);$i++)
	{	
		if($i==0)
		{
			//$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			$query->where(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
		}
		else
		{
			$query->orwhere(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
			//$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
		}
		
	}
});
$items=$query->take(100)->get();



//->where('agent','like',"%$agent%")
//->where('agent','like',"%$agent%")
$pageno=$pageno+1;
$start_month=$start_week;
$end_month=$end_week;

return view('agent.report.pagination_data2')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);



	}







if ($tme=='day'){

$currentoffset=$request->input('currentoffset');
		
		$pageno=$request->input('pageno');

//$currentoffset=$currentoffset+500;
		
$currentoffset=$pageno*100;
$skip=$currentoffset;

/*$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereDate('dbo_payloader.time', Carbon::today())->whereIn('dbo_payloader.sensor_id', $sensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();*/
/*$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereDate('db.time', Carbon::today())->orderby('db.id','desc')->skip($skip)->select('db.*');
for($i=0;$i<count($sensorshubs);$i++){
	if($i==0){
$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
else{
$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
}
$items=$query->take(100)->get();*/
$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereDate('db.time', Carbon::today())->orderby('db.id','desc')->skip($skip)->select('db.*');

$query->where(function($query) use ($sensorshubs, $sensors)
{
	for($i=0;$i<count($sensorshubs);$i++)
	{	
		if($i==0)
		{
			//$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			$query->where(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
		}
		else
		{
			$query->orwhere(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
			//$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
		}
		
	}
});
$items=$query->take(100)->get();

//->where('agent','like',"%$agent%")
$pageno=$pageno+1;
$start_month=$request->input('from');
$end_month=$request->input('to');
return view('agent.report.pagination_data2')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);






}







if($tme =='month')
		{
			$start_month = strtotime("-29 day");
			$end_month = strtotime("+1 day");
			$start_month = date("Y-m-d",$start_month);
			$end_month = date("Y-m-d",$end_month);

		
//$skip=$_GET['skip'];
		$currentoffset=$request->input('currentoffset');
		
		$pageno=$request->input('pageno');

//$currentoffset=$currentoffset+500;
		
$currentoffset=$pageno*100;
$skip=$currentoffset;
/*$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')->whereIn('dbo_payloader.sensor_id', $sensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();*/
/*$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereRaw('db.time between "'.$start_month.'" and "'.$end_month.'"')->orderby('db.id','desc')->skip($skip)->select('db.*');
for($i=0;$i<count($sensorshubs);$i++){
	if($i==0){
$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
else{
$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
}
$items=$query->take(100)->get();*/
$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereRaw('db.time between "'.$start_month.'" and "'.$end_month.'"')->orderby('db.id','desc')->skip($skip)->select('db.*');

$query->where(function($query) use ($sensorshubs, $sensors)
{
	for($i=0;$i<count($sensorshubs);$i++)
	{	
		if($i==0)
		{
			//$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			$query->where(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
		}
		else
		{
			$query->orwhere(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
			//$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
		}
		
	}
});
$items=$query->take(100)->get();

//->where('agent','like',"%$agent%")
$pageno=$pageno+1;
return view('agent.report.pagination_data2')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);
}
if ($tme=="one"){
	$start = date("Y-m-d",strtotime($request->input('from')));
			$end = date("Y-m-d",strtotime($request->input('to')."+1 day"));
$currentoffset=$request->input('currentoffset');
		
		$pageno=$request->input('pageno');

//$currentoffset=$currentoffset+500;
		
$currentoffset=$pageno*100;
$skip=$currentoffset;
/*$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')->whereIn('dbo_payloader.sensor_id', $sensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();*/

/*$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereRaw('db.time between "'.$start.'" and "'.$end.'"')->orderby('db.id','desc')->skip($skip)->select('db.*');
for($i=0;$i<count($sensorshubs);$i++){
	if($i==0){
$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
else{
$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
}
$items=$query->take(100)->get();*/
$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereRaw('db.time between "'.$start.'" and "'.$end.'"')->orderby('db.id','desc')->skip($skip)->select('db.*');

$query->where(function($query) use ($sensorshubs, $sensors)
{
	for($i=0;$i<count($sensorshubs);$i++)
	{	
		if($i==0)
		{
			//$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			$query->where(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
		}
		else
		{
			$query->orwhere(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
			//$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
		}
		
	}
});
$items=$query->take(100)->get();




//->where('agent','like',"%$agent%")->

$pageno=$pageno+1;
$start_month=$request->input('from');
$end_month=$request->input('to');
return view('agent.report.pagination_data2')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);


}




	}	



















public function getsensortimefetchpage_22_8_2020(Request $request)
	{

//$agent = $request->input('agent');
		$agent = session()->get('userid');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$sensor = $request->input('sensor');
		$tme = $request->input('tme');
		
		$hub = implode(",",$hub);
		$hubs = DB::table('sensor_hubs')->whereRaw('id in ('.$hub.')')->get();	
			
		foreach($hubs as $hubname)
		{
			$hubsname[] = $hubname->hub_id;
		}
		$hub = implode(',', $hubsname);
		$unit = urldecode($request->input('unit'));

/*$tme="month";
$hubsname=$_GET['hubsname'];
$sensor=$_GET['sensor '];
$unit=urldecode($_GET['unit']); 
$start_month=$_GET['start_month'];
$end_month=$_GET['end_month'];*/
if($tme=='week')
		{	
			$start_week = strtotime("-6 day");
			$end_week = strtotime("+1 day");
			// $previous_week = strtotime("-1 week +1 day");
			// $start_week = strtotime("last sunday midnight",$previous_week);
			// $end_week = strtotime("next saturday",$start_week);
			$start_week = date("Y-m-d",$start_week);
			$end_week = date("Y-m-d",$end_week);
			/*$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')
			->whereRaw('users.id = "'.$agent.'"')
			->where('dbo_payloader.unit', $unit)
			->whereIn('gateway_groups.id', $group)
			->whereIn('dbo_payloader.hub', $hubsname)
			->whereIn('dbo_payloader.sensor_id', $sensor)
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();*/
$currentoffset=$request->input('currentoffset');
		
		$pageno=$request->input('pageno');

//$currentoffset=$currentoffset+500;
		
$currentoffset=$pageno*100;
$skip=$currentoffset;
$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')->whereIn('dbo_payloader.sensor_id', $sensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();
//->where('agent','like',"%$agent%")
//->where('agent','like',"%$agent%")
$pageno=$pageno+1;
$start_month=$start_week;
$end_month=$end_week;

return view('agent.report.pagination_data2')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);



	}







if ($tme=='day'){

$currentoffset=$request->input('currentoffset');
		
		$pageno=$request->input('pageno');

//$currentoffset=$currentoffset+500;
		
$currentoffset=$pageno*100;
$skip=$currentoffset;

$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereDate('dbo_payloader.time', Carbon::today())->whereIn('dbo_payloader.sensor_id', $sensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();
//->where('agent','like',"%$agent%")
$pageno=$pageno+1;
$start_month=$request->input('from');
$end_month=$request->input('to');
return view('agent.report.pagination_data2')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);






}







if($tme =='month')
		{
			$start_month = strtotime("-29 day");
			$end_month = strtotime("+1 day");
			$start_month = date("Y-m-d",$start_month);
			$end_month = date("Y-m-d",$end_month);

		
//$skip=$_GET['skip'];
		$currentoffset=$request->input('currentoffset');
		
		$pageno=$request->input('pageno');

//$currentoffset=$currentoffset+500;
		
$currentoffset=$pageno*100;
$skip=$currentoffset;
$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')->whereIn('dbo_payloader.sensor_id', $sensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();
//->where('agent','like',"%$agent%")
$pageno=$pageno+1;
return view('agent.report.pagination_data2')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);
}
if ($tme=="one"){
	$start = date("Y-m-d",strtotime($request->input('from')));
			$end = date("Y-m-d",strtotime($request->input('to')."+1 day"));
$currentoffset=$request->input('currentoffset');
		
		$pageno=$request->input('pageno');

//$currentoffset=$currentoffset+500;
		
$currentoffset=$pageno*100;
$skip=$currentoffset;
$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')->whereIn('dbo_payloader.sensor_id', $sensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();
//->where('agent','like',"%$agent%")->

$pageno=$pageno+1;
$start_month=$request->input('from');
$end_month=$request->input('to');
return view('agent.report.pagination_data2')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);


}




	}	


public function getsensortimefetchpageprev(Request $request)
	{

//$agent = $request->input('agent');
		$agent = session()->get('userid');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$sensor = $request->input('sensor');
		$tme = $request->input('tme');
		
		$hub = implode(",",$hub);
		$hubs = DB::table('sensor_hubs')->whereRaw('id in ('.$hub.')')->get();	
			
		foreach($hubs as $hubname)
		{
			$hubsname[] = $hubname->hub_id;
		}
		$hub = implode(',', $hubsname);
		$unit = urldecode($request->input('unit'));

/*$tme="month";
$hubsname=$_GET['hubsname'];
$sensor=$_GET['sensor '];
$unit=urldecode($_GET['unit']); 
$start_month=$_GET['start_month'];
$end_month=$_GET['end_month'];*/


$hubsidlist=array();
		foreach($hubs as $hubids)
		{
			$hubsidlist[] = $hubids->id;
		}
		//dd($hubsidlist);
$hubscount = DB::table('sensors')
			->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
			->whereIn('sensors.hub_id',$hubsidlist)->where('sensors.agent',$agent)->whereIn('sensors.sensor_id',$sensor)
				->whereIn('sensors.group_id',$group)
			->groupBy('hub_id','sensor_id')
			->select('sensors.hub_id','sensors.sensor_id')
			->get();
			
    foreach($hubscount as $hubscounts)
			{
				$getudt=DB::table('sensors')->where('sensor_id',$hubscounts->sensor_id)->where('hub_id',$hubscounts->hub_id)->first();
				$gethdt=DB::table('sensor_hubs')->where('id',$hubscounts->hub_id)->first();
				$unit1[] = $getudt->unit;
				//$unit1[] = '*C';
				$sensors[]=$hubscounts->sensor_id;
				$sensorshubs[]=$gethdt->hub_id;


				$combined="$gethdt->hub_id"."_".$hubscounts->sensor_id;
$sensorshub1[]=$combined;
$getchtdt=DB::table('chart')->where('unit',$getudt->unit)->first();



$chart1[]="AreaChart";

			}


if($tme=='week')
		{	
			$start_week = strtotime("-6 day");
			$end_week = strtotime("+1 day");
			// $previous_week = strtotime("-1 week +1 day");
			// $start_week = strtotime("last sunday midnight",$previous_week);
			// $end_week = strtotime("next saturday",$start_week);
			$start_week = date("Y-m-d",$start_week);
			$end_week = date("Y-m-d",$end_week);
			/*$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')
			->whereRaw('users.id = "'.$agent.'"')
			->where('dbo_payloader.unit', $unit)
			->whereIn('gateway_groups.id', $group)
			->whereIn('dbo_payloader.hub', $hubsname)
			->whereIn('dbo_payloader.sensor_id', $sensor)
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();*/
$currentoffset=$request->input('currentoffset');
		
		$pageno=$request->input('pageno');
		$pageno=$pageno-1;
$currentoffset=($pageno-1)*100;
$skip=$currentoffset;
/*$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')->where('agent','like',"%$agent%")->whereIn('dbo_payloader.sensor_id', $sensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();*/

/*$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereRaw('db.time between "'.$start_week.'" and "'.$end_week.'"')->orderby('db.id','desc')->skip($skip)->select('db.*');
for($i=0;$i<count($sensorshubs);$i++){
	if($i==0){
$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
else{
$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
}
$items=$query->take(100)->get();*/

$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereRaw('db.time between "'.$start_week.'" and "'.$end_week.'"')->orderby('db.id','desc')->skip($skip)->select('db.*');

$query->where(function($query) use ($sensorshubs, $sensors)
{
	for($i=0;$i<count($sensorshubs);$i++)
	{	
		if($i==0)
		{
			//$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			$query->where(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
		}
		else
		{
			$query->orwhere(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
			//$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
		}
		
	}
});
$items=$query->take(100)->get();





//->where('agent','like',"%$agent%")->
$start_month=$start_week;
$end_month=$end_week;

return view('agent.report.pagination_data2')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);



	}







if ($tme=='day'){

$currentoffset=$request->input('currentoffset');
		
		$pageno=$request->input('pageno');
		$pageno=$pageno-1;
$currentoffset=($pageno-1)*100;
$skip=$currentoffset;

/*$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereDate('dbo_payloader.time', Carbon::today())->whereIn('dbo_payloader.sensor_id', $sensor)->where('agent','like',"%$agent%")->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();*/
/*$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereDate('db.time', Carbon::today())->orderby('db.id','desc')->skip($skip)->select('db.*');
for($i=0;$i<count($sensorshubs);$i++){
	if($i==0){
$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
else{
$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
}
$items=$query->take(100)->get();*/
$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereDate('db.time', Carbon::today())->orderby('db.id','desc')->skip($skip)->select('db.*');

$query->where(function($query) use ($sensorshubs, $sensors)
{
	for($i=0;$i<count($sensorshubs);$i++)
	{	
		if($i==0)
		{
			//$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			$query->where(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
		}
		else
		{
			$query->orwhere(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
			//$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
		}
		
	}
});
$items=$query->take(100)->get();


$itemscount=count($items);


//->where('agent','like',"%$agent%")->
return view('agent.report.pagination_data2')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);







}







if($tme =='month')
		{
			$start_month = strtotime("-29 day");
			$end_month = strtotime("+1 day");
			$start_month = date("Y-m-d",$start_month);
			$end_month = date("Y-m-d",$end_month);

		
//$skip=$_GET['skip'];
		$currentoffset=$request->input('currentoffset');
		
		$pageno=$request->input('pageno');
		$pageno=$pageno-1;
$currentoffset=($pageno-1)*100;
$skip=$currentoffset;
/*$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')->whereIn('dbo_payloader.sensor_id', $sensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();*/

/*$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereRaw('db.time between "'.$start_month.'" and "'.$end_month.'"')->orderby('db.id','desc')->skip($skip)->select('db.*');
for($i=0;$i<count($sensorshubs);$i++){
	if($i==0){
$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
else{
$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
}
$items=$query->take(100)->get();*/


$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereRaw('db.time between "'.$start_month.'" and "'.$end_month.'"')->orderby('db.id','desc')->skip($skip)->select('db.*');

$query->where(function($query) use ($sensorshubs, $sensors)
{
	for($i=0;$i<count($sensorshubs);$i++)
	{	
		if($i==0)
		{
			//$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			$query->where(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
		}
		else
		{
			$query->orwhere(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
			//$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
		}
		
	}
});
$items=$query->take(100)->get();



//->where('agent','like',"%$agent%")->
//$currentoffset=$currentoffset+500;


return view('agent.report.pagination_data2')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);

}

if($tme=='one')
		{	
			$start = date("Y-m-d",strtotime($request->input('from')));
			$end = date("Y-m-d",strtotime($request->input('to')."+1 day"));

$currentoffset=$request->input('currentoffset');
		
		$pageno=$request->input('pageno');
		$pageno=$pageno-1;
$currentoffset=($pageno-1)*100;
$skip=$currentoffset;
/*$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')->whereIn('dbo_payloader.sensor_id', $sensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();*/
/*$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereRaw('db.time between "'.$start.'" and "'.$end.'"')->orderby('db.id','desc')->skip($skip)->select('db.*');
for($i=0;$i<count($sensorshubs);$i++){
	if($i==0){
$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
else{
$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
}*/

$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereRaw('db.time between "'.$start.'" and "'.$end.'"')->orderby('db.id','desc')->skip($skip)->select('db.*');

$query->where(function($query) use ($sensorshubs, $sensors)
{
	for($i=0;$i<count($sensorshubs);$i++)
	{	
		if($i==0)
		{
			//$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			$query->where(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
		}
		else
		{
			$query->orwhere(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
			//$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
		}
		
	}
});
$items=$query->take(100)->get();


$start_month=$request->input('from');
$end_month=$request->input('to');
return view('agent.report.pagination_data2')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);







}



	}	



















public function getsensortimefetchpageprev_22_8_2020(Request $request)
	{

//$agent = $request->input('agent');
		$agent = session()->get('userid');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$sensor = $request->input('sensor');
		$tme = $request->input('tme');
		
		$hub = implode(",",$hub);
		$hubs = DB::table('sensor_hubs')->whereRaw('id in ('.$hub.')')->get();	
			
		foreach($hubs as $hubname)
		{
			$hubsname[] = $hubname->hub_id;
		}
		$hub = implode(',', $hubsname);
		$unit = urldecode($request->input('unit'));

/*$tme="month";
$hubsname=$_GET['hubsname'];
$sensor=$_GET['sensor '];
$unit=urldecode($_GET['unit']); 
$start_month=$_GET['start_month'];
$end_month=$_GET['end_month'];*/

if($tme=='week')
		{	
			$start_week = strtotime("-6 day");
			$end_week = strtotime("+1 day");
			// $previous_week = strtotime("-1 week +1 day");
			// $start_week = strtotime("last sunday midnight",$previous_week);
			// $end_week = strtotime("next saturday",$start_week);
			$start_week = date("Y-m-d",$start_week);
			$end_week = date("Y-m-d",$end_week);
			/*$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')
			->whereRaw('users.id = "'.$agent.'"')
			->where('dbo_payloader.unit', $unit)
			->whereIn('gateway_groups.id', $group)
			->whereIn('dbo_payloader.hub', $hubsname)
			->whereIn('dbo_payloader.sensor_id', $sensor)
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();*/
$currentoffset=$request->input('currentoffset');
		
		$pageno=$request->input('pageno');
		$pageno=$pageno-1;
$currentoffset=($pageno-1)*100;
$skip=$currentoffset;
//dd($skip,$currentoffset);
//\DB::connection()->enableQueryLog();
/*$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')->where('agent','like',"%$agent%")->whereIn('dbo_payloader.sensor_id', $sensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();*/

$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')->whereIn('dbo_payloader.sensor_id', $sensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();




//$queries = \DB::getQueryLog();
//dd($queries);
//->where('agent','like',"%$agent%")->
$start_month=$start_week;
$end_month=$end_week;
//dd($items,$skip);
return view('agent.report.pagination_data2')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);



	}







if ($tme=='day'){

$currentoffset=$request->input('currentoffset');
		
		$pageno=$request->input('pageno');
		$pageno=$pageno-1;
$currentoffset=($pageno-1)*100;
$skip=$currentoffset;

/*$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereDate('dbo_payloader.time', Carbon::today())->whereIn('dbo_payloader.sensor_id', $sensor)->where('agent','like',"%$agent%")->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();*/

$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereDate('dbo_payloader.time', Carbon::today())->whereIn('dbo_payloader.sensor_id', $sensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();

$start_month=$request->input('from');
$end_month=$request->input('to');
//->where('agent','like',"%$agent%")->
return view('agent.report.pagination_data2')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);







}







if($tme =='month')
		{
			$start_month = strtotime("-29 day");
			$end_month = strtotime("+1 day");
			$start_month = date("Y-m-d",$start_month);
			$end_month = date("Y-m-d",$end_month);

		
//$skip=$_GET['skip'];
		$currentoffset=$request->input('currentoffset');
		
		$pageno=$request->input('pageno');
		$pageno=$pageno-1;
$currentoffset=($pageno-1)*100;
$skip=$currentoffset;
$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')->whereIn('dbo_payloader.sensor_id', $sensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();

//->where('agent','like',"%$agent%")->
//$currentoffset=$currentoffset+500;


return view('agent.report.pagination_data2')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);

}

if($tme=='one')
		{	
			$start = date("Y-m-d",strtotime($request->input('from')));
			$end = date("Y-m-d",strtotime($request->input('to')."+1 day"));

$currentoffset=$request->input('currentoffset');
		
		$pageno=$request->input('pageno');
		$pageno=$pageno-1;
$currentoffset=($pageno-1)*100;
$skip=$currentoffset;
$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')->whereIn('dbo_payloader.sensor_id', $sensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();
//->where('agent','like',"%$agent%")
//$currentoffset=$currentoffset+500;

$start_month=$request->input('from');
$end_month=$request->input('to');
return view('agent.report.pagination_data2')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);







}



	}	

public function savecharttempdata(Request $request){

//$agent = $request->input('agent');
	$agent = session()->get('userid');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$sensor = $request->input('sensor');
		$tme = $request->input('tme');
		//$group = implode(",",$group);
		$hub = implode(",",$hub);
		$hubs = DB::table('sensor_hubs')->whereRaw('id in ('.$hub.')')->get();	
		//dd($hubs);	
		foreach($hubs as $hubname)
		{
			$hubsname[] = $hubname->hub_id;
		}
		$hub = implode(',', $hubsname);
		$unit = urldecode($request->input('unit'));
		$loginid=session()->get('userid');
		$currentoffset=0;
		$agentdt=DB::table('users')->where('Id',$agent)->first();
$agentname=$agentdt->fname." ".$agentdt->lname;
//error_reporting(0);

$hubsidlist=array();
		foreach($hubs as $hubids)
		{
			$hubsidlist[] = $hubids->id;
		}
		//dd($hubsidlist);
$hubscount = DB::table('sensors')
			->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
			->whereIn('sensors.hub_id',$hubsidlist)->where('sensors.agent',$agent)->whereIn('sensors.sensor_id',$sensor)
				->whereIn('sensors.group_id',$group)
			->groupBy('hub_id','sensor_id')
			->select('sensors.hub_id','sensors.sensor_id')
			->get();
			
    foreach($hubscount as $hubscounts)
			{
				$getudt=DB::table('sensors')->where('sensor_id',$hubscounts->sensor_id)->where('hub_id',$hubscounts->hub_id)->first();
				$gethdt=DB::table('sensor_hubs')->where('id',$hubscounts->hub_id)->first();
				$unit1[] = $getudt->unit;
				//$unit1[] = '*C';
				$sensors[]=$hubscounts->sensor_id;
				$sensorshubs[]=$gethdt->hub_id;


				$combined="$gethdt->hub_id"."__".$hubscounts->sensor_id;
$sensorshub1[]=$combined;
$getchtdt=DB::table('chart')->where('unit',$getudt->unit)->first();
$chart1[]="AreaChart";

			}






		if($tme=='week')
		{	
			$start_week = strtotime("-6 day");
			$end_week = strtotime("+1 day");			
			$start_week = date("Y-m-d",$start_week);
			$end_week = date("Y-m-d",$end_week);
			

$deldt=DB::table('dbo_payloadercharttemp')->where('loginid',$loginid)->delete();

/*$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereRaw('db.time between "'.$start_week.'" and "'.$end_week.'"')->orderby('db.id','desc')->select('db.*');
for($i=0;$i<count($sensorshubs);$i++){
	if($i==0){
$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
else{
$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
}
$items=$query->get();*/

$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereRaw('db.time between "'.$start_week.'" and "'.$end_week.'"')->orderby('db.id','desc')->select('db.*');

$query->where(function($query) use ($sensorshubs, $sensors)
{
	for($i=0;$i<count($sensorshubs);$i++)
	{	
		if($i==0)
		{
			//$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			$query->where(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
		}
		else
		{
			$query->orwhere(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
			//$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
		}
		
	}
});
$items=$query->get();








//dd(DB::getQueryLog());
//dd($items);
//->where('agent','like',"%$agent%")
foreach ($items as $item) {

$sensdt=DB::table('sensors')->where('sensor_id',$item->sensor_id)->where('unit',$item->unit)->first();
$hubid=$sensdt->hub_id;

/*$hubdt=DB::table('sensor_hubs')->where('id',$hubid)->first();
$groupid=$hubdt->sensor_group_id;
$grpdt=DB::table('sensor_groups')->where('id',$groupid)->first();
$gatewaygrp=$grpdt->name;*/


/*$hubdt=DB::table('sensors')->where('sensor_id',$item->sensor_id)->where('sensors.agent',$agent)->first();*/

$hubdt=DB::table('sensor_hubs')->join('sensors','sensors.hub_id','=','sensor_hubs.id')->where('sensor_id',$item->sensor_id)->where('sensor_hubs.hub_id',$item->hub)->where('sensor_hubs.agent',$agent)->where('sensors.agent',$agent)->where('unit',$item->unit)->first();


$groupid=$hubdt->sensor_group_id;

$grpdt=DB::table('sensor_groups')->where('id',$groupid)->first();
echo $grpdt->name;
$gatewaygrp=$grpdt->name;
	//$gatewayname
$hubsens=$item->hub."__".$item->sensor_id;
	$data=array("loginid"=>$loginid,"hub"=>$item->hub,"time"=>$item->time,"sensor_id"=>$item->sensor_id,"unit"=>$item->unit,"value"=>$item->value,"sensor_type"=>$item->sensor_type,"utc"=>$item->utc,"agentname"=>$agentname,"gatewaygrp"=>$gatewaygrp,"hub_sensorid"=>$hubsens);
		$value=DB::table('dbo_payloadercharttemp')->insertGetId($data);
}




		}
		if($tme =='day')
		{
			/*$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->whereRaw('users.id = "'.$agent.'"')
			->where('dbo_payloader.unit', $unit)
			->whereIn('gateway_groups.id', $group)
			->whereIn('dbo_payloader.hub', $hubsname)
			->whereIn('dbo_payloader.sensor_id', $sensor)
			->whereDate('dbo_payloader.time', Carbon::today())
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();*/

$deldt=DB::table('dbo_payloadercharttemp')->where('loginid',$loginid)->delete();

/*$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereDate('db.time', Carbon::today())->orderby('db.id','desc')->select('db.*');
for($i=0;$i<count($sensorshubs);$i++){
	if($i==0){
$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
else{
$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
}
$items=$query->get();*/
$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereDate('db.time', Carbon::today())->orderby('db.id','desc')->select('db.*');

$query->where(function($query) use ($sensorshubs, $sensors)
{
	for($i=0;$i<count($sensorshubs);$i++)
	{	
		if($i==0)
		{
			//$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			$query->where(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
		}
		else
		{
			$query->orwhere(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
			//$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
		}
		
	}
});
$items=$query->get();


//->where('agent','like',"%$agent%")
foreach ($items as $item) {
$sensdt=DB::table('sensors')->where('sensor_id',$item->sensor_id)->where('unit',$item->unit)->first();
$hubid=$sensdt->hub_id;
/*$hubdt=DB::table('sensor_hubs')->where('id',$hubid)->first();
$groupid=$hubdt->sensor_group_id;
$grpdt=DB::table('sensor_groups')->where('id',$groupid)->first();
$gatewaygrp=$grpdt->name;*/
//$hubdt=DB::table('sensors')->where('sensor_id',$item->sensor_id)->where('sensors.agent',$agent)->first();

$hubdt=DB::table('sensor_hubs')->join('sensors','sensors.hub_id','=','sensor_hubs.id')->where('sensor_id',$item->sensor_id)->where('sensor_hubs.hub_id',$item->hub)->where('sensor_hubs.agent',$agent)->where('sensors.agent',$agent)->where('unit',$item->unit)->first();

$groupid=$hubdt->sensor_group_id;

$grpdt=DB::table('sensor_groups')->where('id',$groupid)->first();
echo $grpdt->name;
$gatewaygrp=$grpdt->name;
$hubsens=$item->hub."__".$item->sensor_id;

	$data=array("loginid"=>$loginid,"hub"=>$item->hub,"time"=>$item->time,"sensor_id"=>$item->sensor_id,"unit"=>$item->unit,"value"=>$item->value,"sensor_type"=>$item->sensor_type,"utc"=>$item->utc,"agentname"=>$agentname,"gatewaygrp"=>$gatewaygrp,"hub_sensorid"=>$hubsens);
		$value=DB::table('dbo_payloadercharttemp')->insertGetId($data);
}




			
		}
		if($tme =='month')
		{
			$start_month = strtotime("-29 day");
			$end_month = strtotime("+1 day");
			$start_month = date("Y-m-d",$start_month);
			$end_month = date("Y-m-d",$end_month);
			//dd($tme);
			
$deldt=DB::table('dbo_payloadercharttemp')->where('loginid',$loginid)->delete();


/*$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereRaw('db.time between "'.$start_month.'" and "'.$end_month.'"')->orderby('db.id','desc')->select('db.*');
for($i=0;$i<count($sensorshubs);$i++){
	if($i==0){
$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
else{
$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
}
$items=$query->get();*/
$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereRaw('db.time between "'.$start_month.'" and "'.$end_month.'"')->orderby('db.id','desc')->select('db.*');

$query->where(function($query) use ($sensorshubs, $sensors)
{
	for($i=0;$i<count($sensorshubs);$i++)
	{	
		if($i==0)
		{
			//$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			$query->where(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
		}
		else
		{
			$query->orwhere(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
			//$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
		}
		
	}
});
$items=$query->get();




//->where('agent','like',"%$agent%")
foreach ($items as $item) {
	$sensdt=DB::table('sensors')->where('sensor_id',$item->sensor_id)->where('unit',$item->unit)->first();
$hubid=$sensdt->hub_id;
/*$hubdt=DB::table('sensor_hubs')->where('id',$hubid)->first();
$groupid=$hubdt->sensor_group_id;
$grpdt=DB::table('sensor_groups')->where('id',$groupid)->first();
$gatewaygrp=$grpdt->name;*/
//$hubdt=DB::table('sensors')->where('sensor_id',$item->sensor_id)->where('sensors.agent',$agent)->first();
$hubdt=DB::table('sensor_hubs')->join('sensors','sensors.hub_id','=','sensor_hubs.id')->where('sensor_id',$item->sensor_id)->where('sensor_hubs.hub_id',$item->hub)->where('sensor_hubs.agent',$agent)->where('sensors.agent',$agent)->where('unit',$item->unit)->first();
$groupid=$hubdt->sensor_group_id;

$grpdt=DB::table('sensor_groups')->where('id',$groupid)->first();
echo $grpdt->name;
$gatewaygrp=$grpdt->name;
$hubsens=$item->hub."__".$item->sensor_id;
	$data=array("loginid"=>$loginid,"hub"=>$item->hub,"time"=>$item->time,"sensor_id"=>$item->sensor_id,"unit"=>$item->unit,"value"=>$item->value,"sensor_type"=>$item->sensor_type,"utc"=>$item->utc,"agentname"=>$agentname,"gatewaygrp"=>$gatewaygrp,"hub_sensorid"=>$hubsens);
		$value=DB::table('dbo_payloadercharttemp')->insertGetId($data);
}


		}
		if($tme=='one')
		{	
			$start = date("Y-m-d",strtotime($request->input('from')));
			$end = date("Y-m-d",strtotime($request->input('to')."+1 day"));
			

/*$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereRaw('db.time between "'.$start.'" and "'.$end.'"')->orderby('db.id','desc')->select('db.*');
for($i=0;$i<count($sensorshubs);$i++){
	if($i==0){
$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
else{
$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
}
$items=$query->get();*/
$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereRaw('db.time between "'.$start.'" and "'.$end.'"')->orderby('db.id','desc')->select('db.*');

$query->where(function($query) use ($sensorshubs, $sensors)
{
	for($i=0;$i<count($sensorshubs);$i++)
	{	
		if($i==0)
		{
			//$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			$query->where(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
		}
		else
		{
			$query->orwhere(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
			//$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
		}
		
	}
});
$items=$query->get();





foreach ($items as $item) {
	$sensdt=DB::table('sensors')->where('sensor_id',$item->sensor_id)->where('unit',$item->unit)->first();
$hubid=$sensdt->hub_id;
/*$hubdt=DB::table('sensor_hubs')->where('id',$hubid)->first();
$groupid=$hubdt->sensor_group_id;
$grpdt=DB::table('sensor_groups')->where('id',$groupid)->first();
$gatewaygrp=$grpdt->name;*/
//$hubdt=DB::table('sensors')->where('sensor_id',$item->sensor_id)->where('sensors.agent',$agent)->first();
$hubdt=DB::table('sensor_hubs')->join('sensors','sensors.hub_id','=','sensor_hubs.id')->where('sensor_id',$item->sensor_id)->where('sensor_hubs.hub_id',$item->hub)->where('sensor_hubs.agent',$agent)->where('sensors.agent',$agent)->where('unit',$item->unit)->first();
$groupid=$hubdt->sensor_group_id;

$grpdt=DB::table('sensor_groups')->where('id',$groupid)->first();
echo $grpdt->name;
$gatewaygrp=$grpdt->name;
$hubsens=$item->hub."__".$item->sensor_id;
	$data=array("loginid"=>$loginid,"hub"=>$item->hub,"time"=>$item->time,"sensor_id"=>$item->sensor_id,"unit"=>$item->unit,"value"=>$item->value,"sensor_type"=>$item->sensor_type,"utc"=>$item->utc,"agentname"=>$agentname,"gatewaygrp"=>$gatewaygrp,"hub_sensorid"=>$hubsens);
		$value=DB::table('dbo_payloadercharttemp')->insertGetId($data);
}





}
echo "1";

}












public function savecharttempdata_22_8_2020(Request $request){

//$agent = $request->input('agent');
	$agent = session()->get('userid');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$sensor = $request->input('sensor');
		$tme = $request->input('tme');
		//$group = implode(",",$group);
		$hub = implode(",",$hub);
		$hubs = DB::table('sensor_hubs')->whereRaw('id in ('.$hub.')')->get();	
		//dd($hubs);	
		foreach($hubs as $hubname)
		{
			$hubsname[] = $hubname->hub_id;
		}
		$hub = implode(',', $hubsname);
		$unit = urldecode($request->input('unit'));
		$loginid=session()->get('userid');
		$currentoffset=0;
		$agentdt=DB::table('users')->where('Id',$agent)->first();
$agentname=$agentdt->fname." ".$agentdt->lname;
		if($tme=='week')
		{	
			$start_week = strtotime("-6 day");
			$end_week = strtotime("+1 day");
			// $previous_week = strtotime("-1 week +1 day");
			// $start_week = strtotime("last sunday midnight",$previous_week);
			// $end_week = strtotime("next saturday",$start_week);
			$start_week = date("Y-m-d",$start_week);
			$end_week = date("Y-m-d",$end_week);
			/*$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')
			->whereRaw('users.id = "'.$agent.'"')
			->where('dbo_payloader.unit', $unit)
			->whereIn('gateway_groups.id', $group)
			->whereIn('dbo_payloader.hub', $hubsname)
			->whereIn('dbo_payloader.sensor_id', $sensor)
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();*/
$deldt=DB::table('dbo_payloadercharttemp')->where('loginid',$loginid)->delete();
$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')->whereIn('dbo_payloader.sensor_id', $sensor)->get();
//->where('agent','like',"%$agent%")
foreach ($items as $item) {

/*$sensdt=DB::table('sensors')->where('sensor_id',$item->sensor_id)->where('unit',$item->unit)->first();
$hubid=$sensdt->hub_id;
$hubdt=DB::table('sensor_hubs')->where('id',$hubid)->first();*/


/*$hubdt=DB::table('sensor_hubs')->join('sensors','sensors.hub_id','=','sensor_hubs.id')->where('sensor_id',$item->sensor_id)->where('unit',$item->unit)->where('sensor_hubs.hub_id',$item->hub)->where('agent',$agent)->first();
$groupid=$hubdt->sensor_group_id;
$grpdt=DB::table('sensor_groups')->where('id',$groupid)->first();
$gatewaygrp=$grpdt->name;*/
$hubdt=DB::table('sensors')->where('sensor_id',$item->sensor_id)->where('sensors.agent',$agent)->first();
$groupid=$hubdt->sensor_group_id;

$grpdt=DB::table('sensor_groups')->where('id',$groupid)->first();
echo $grpdt->name;
$gatewaygrp=$grpdt->name;



	//$gatewayname
	$data=array("loginid"=>$loginid,"hub"=>$item->hub,"time"=>$item->time,"sensor_id"=>$item->sensor_id,"unit"=>$item->unit,"value"=>$item->value,"sensor_type"=>$item->sensor_type,"utc"=>$item->utc,"agentname"=>$agentname,"gatewaygrp"=>$gatewaygrp);
		$value=DB::table('dbo_payloadercharttemp')->insertGetId($data);
}




		}
		if($tme =='day')
		{
			/*$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->whereRaw('users.id = "'.$agent.'"')
			->where('dbo_payloader.unit', $unit)
			->whereIn('gateway_groups.id', $group)
			->whereIn('dbo_payloader.hub', $hubsname)
			->whereIn('dbo_payloader.sensor_id', $sensor)
			->whereDate('dbo_payloader.time', Carbon::today())
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();*/

$deldt=DB::table('dbo_payloadercharttemp')->where('loginid',$loginid)->delete();
$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereDate('dbo_payloader.time', Carbon::today())->whereIn('dbo_payloader.sensor_id', $sensor)->get();
//->where('agent','like',"%$agent%")
foreach ($items as $item) {
/*$sensdt=DB::table('sensors')->where('sensor_id',$item->sensor_id)->where('unit',$item->unit)->first();
$hubid=$sensdt->hub_id;
$hubdt=DB::table('sensor_hubs')->where('id',$hubid)->first();*/

/*$hubdt=DB::table('sensor_hubs')->join('sensors','sensors.hub_id','=','sensor_hubs.id')->where('sensor_id',$item->sensor_id)->where('unit',$item->unit)->where('sensor_hubs.hub_id',$item->hub)->where('agent',$agent)->first();
$groupid=$hubdt->sensor_group_id;
$grpdt=DB::table('sensor_groups')->where('id',$groupid)->first();
$gatewaygrp=$grpdt->name;*/
$hubdt=DB::table('sensors')->where('sensor_id',$item->sensor_id)->where('sensors.agent',$agent)->first();
$groupid=$hubdt->sensor_group_id;

$grpdt=DB::table('sensor_groups')->where('id',$groupid)->first();
echo $grpdt->name;
$gatewaygrp=$grpdt->name;


	$data=array("loginid"=>$loginid,"hub"=>$item->hub,"time"=>$item->time,"sensor_id"=>$item->sensor_id,"unit"=>$item->unit,"value"=>$item->value,"sensor_type"=>$item->sensor_type,"utc"=>$item->utc,"agentname"=>$agentname,"gatewaygrp"=>$gatewaygrp);
		$value=DB::table('dbo_payloadercharttemp')->insertGetId($data);
}




			
		}
		if($tme =='month')
		{
			$start_month = strtotime("-29 day");
			$end_month = strtotime("+1 day");
			$start_month = date("Y-m-d",$start_month);
			$end_month = date("Y-m-d",$end_month);
			//dd($tme);
			
$deldt=DB::table('dbo_payloadercharttemp')->where('loginid',$loginid)->delete();
$items=DB::table('dbo_payloader')->whereIn('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')->whereIn('dbo_payloader.sensor_id', $sensor)->where('dbo_payloader.unit', $unit)->get();
//->where('agent','like',"%$agent%")
foreach ($items as $item) {
	/*$sensdt=DB::table('sensors')->where('sensor_id',$item->sensor_id)->where('unit',$item->unit)->first();
$hubid=$sensdt->hub_id;
$hubdt=DB::table('sensor_hubs')->where('id',$hubid)->first();*/

/*$hubdt=DB::table('sensor_hubs')->join('sensors','sensors.hub_id','=','sensor_hubs.id')->where('sensor_id',$item->sensor_id)->where('unit',$item->unit)->where('sensor_hubs.hub_id',$item->hub)->where('agent',$agent)->first();
$groupid=$hubdt->sensor_group_id;
$grpdt=DB::table('sensor_groups')->where('id',$groupid)->first();
$gatewaygrp=$grpdt->name;*/
$hubdt=DB::table('sensors')->where('sensor_id',$item->sensor_id)->where('sensors.agent',$agent)->first();
$groupid=$hubdt->sensor_group_id;

$grpdt=DB::table('sensor_groups')->where('id',$groupid)->first();
echo $grpdt->name;
$gatewaygrp=$grpdt->name;

	$data=array("loginid"=>$loginid,"hub"=>$item->hub,"time"=>$item->time,"sensor_id"=>$item->sensor_id,"unit"=>$item->unit,"value"=>$item->value,"sensor_type"=>$item->sensor_type,"utc"=>$item->utc,"agentname"=>$agentname,"gatewaygrp"=>$gatewaygrp);
		$value=DB::table('dbo_payloadercharttemp')->insertGetId($data);
}


		}
		if($tme=='one')
		{	
			$start = date("Y-m-d",strtotime($request->input('from')));
			$end = date("Y-m-d",strtotime($request->input('to')."+1 day"));
			/*$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')
			->whereRaw('users.id = "'.$agent.'"')
			->where('dbo_payloader.unit', $unit)
			->whereIn('gateway_groups.id', $group)
			->whereIn('dbo_payloader.hub', $hubsname)
			->whereIn('dbo_payloader.sensor_id', $sensor)
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();*/

$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')->whereIn('dbo_payloader.sensor_id', $sensor)->get();
//->where('agent','like',"%$agent%")

foreach ($items as $item) {
	/*$sensdt=DB::table('sensors')->where('sensor_id',$item->sensor_id)->where('unit',$item->unit)->first();
$hubid=$sensdt->hub_id;
$hubdt=DB::table('sensor_hubs')->where('id',$hubid)->first();*/

/*$hubdt=DB::table('sensor_hubs')->join('sensors','sensors.hub_id','=','sensor_hubs.id')->where('sensor_id',$item->sensor_id)->where('unit',$item->unit)->where('sensor_hubs.hub_id',$item->hub)->where('agent',$agent)->first();
$groupid=$hubdt->sensor_group_id;
$grpdt=DB::table('sensor_groups')->where('id',$groupid)->first();
$gatewaygrp=$grpdt->name;*/
$hubdt=DB::table('sensors')->where('sensor_id',$item->sensor_id)->where('sensors.agent',$agent)->first();
$groupid=$hubdt->sensor_group_id;

$grpdt=DB::table('sensor_groups')->where('id',$groupid)->first();
echo $grpdt->name;
$gatewaygrp=$grpdt->name;

	$data=array("loginid"=>$loginid,"hub"=>$item->hub,"time"=>$item->time,"sensor_id"=>$item->sensor_id,"unit"=>$item->unit,"value"=>$item->value,"sensor_type"=>$item->sensor_type,"utc"=>$item->utc,"agentname"=>$agentname,"gatewaygrp"=>$gatewaygrp);
		$value=DB::table('dbo_payloadercharttemp')->insertGetId($data);
}





}
echo "1";

}









	function getchartcount()
    {
		$count = explode(',', request()->val);
		$cnt = count($count);
		return view('agent.report.count')->with(['count'=> $cnt]);
	}
	function getchartcounthub()
    {
		return view('agent.report.counthub')->with(['count'=> request()->val]);
	}
	public function getChart3(Request $request)
	{
		$agent = session()->get('userid');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$sensor = $request->input('sensor');
		$tme = $request->input('tme');
		$group = implode(",",$group);
		$hub = implode(",",$hub);
		$sensor = implode( ",", $sensor);
		$unit = $request->input('unit');
		$chartnam = $request->input('chartnam');
		
		$start = date("Y-m-d",strtotime($request->input('from')));
		$end = date("Y-m-d",strtotime($request->input('to')."+1 day"));
		$groups = DB::table('sensors')
		->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
		->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
		->join('users', 'sensor_hubs.agent', '=', 'users.id')
		->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
		->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')
		->where('users.id', $agent)
		->where('dbo_payloader.unit', $unit)
		->whereRaw('gateway_groups.id in ('.$group.')')
		->whereRaw('sensor_hubs.id in ('.$hub.')')
		->whereRaw('dbo_payloader.sensor_id in ("'.$sensor.'")')
		->select(array('dbo_payloader.*'))
		->get();
		$group=array();
		$arr=array();
		foreach($groups as $item)
		{
			$arr['hour'][]  = date('d-m-Y', strtotime($item->time));
			$arr['value'][] = (float)$item->value;
			$arr['chart'][0] = $chartnam;	
		}	
		return json_encode($arr);
	}	
	

public function getsensortime(Request $request)
	{

		//$unit="";
		//$agent = $request->input('agent');
		$agent = session()->get('userid');
		$group = $request->input('group');
		//dd($group);
		$hub = $request->input('hub');
		$sensor = $request->input('sensor');
		$tme = $request->input('tme');
		//$group = implode(",",$group);
		$hub = implode(",",$hub);
		$hubs = DB::table('sensor_hubs')->whereRaw('id in ('.$hub.')')->get();	
		//dd($hubs);	
		foreach($hubs as $hubname)
		{
			$hubsname[] = $hubname->hub_id;
		}
		$hub = implode(',', $hubsname);
		$unit = urldecode($request->input('unit'));
		$currentoffset=0;



/*$hub = implode(",",$hub);
		$hubs = DB::table('sensor_hubs')->whereRaw('id in ('.$hub.')')->get();	*/	
		foreach($hubs as $hubname)
		{
			$hubsname[] = $hubname->hub_id;
		}

$hubsidlist=array();
		foreach($hubs as $hubids)
		{
			$hubsidlist[] = $hubids->id;
		}
		//dd($hubsidlist);
$hubscount = DB::table('sensors')
			->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
			->whereIn('sensors.hub_id',$hubsidlist)->where('sensors.agent',$agent)->whereIn('sensors.sensor_id',$sensor)
				->whereIn('sensors.group_id',$group)
			->groupBy('hub_id','sensor_id')
			->select('sensors.hub_id','sensors.sensor_id')
			->get();
			
    foreach($hubscount as $hubscounts)
			{
				$getudt=DB::table('sensors')->where('sensor_id',$hubscounts->sensor_id)->where('hub_id',$hubscounts->hub_id)->first();
				$gethdt=DB::table('sensor_hubs')->where('id',$hubscounts->hub_id)->first();
				$unit1[] = $getudt->unit;
				//$unit1[] = '*C';
				$sensors[]=$hubscounts->sensor_id;
				$sensorshubs[]=$gethdt->hub_id;


				$combined="$gethdt->hub_id"."_".$hubscounts->sensor_id;
$sensorshub1[]=$combined;
$getchtdt=DB::table('chart')->where('unit',$getudt->unit)->first();



$chart1[]="AreaChart";

			}

//dd($sensors,$sensorshubs);

		if($tme=='week')
		{	
			$start_week = strtotime("-6 day");
			$end_week = strtotime("+1 day");
			// $previous_week = strtotime("-1 week +1 day");
			// $start_week = strtotime("last sunday midnight",$previous_week);
			// $end_week = strtotime("next saturday",$start_week);
			$start_week = date("Y-m-d",$start_week);
			$end_week = date("Y-m-d",$end_week);
			
       //DB::enableQueryLog();    
/*$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereRaw('db.time between "'.$start_week.'" and "'.$end_week.'"')->orderby('db.id','desc')->skip(0)->select('db.*');
for($i=0;$i<count($sensorshubs);$i++){
	if($i==0){
$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
else{
$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
}
$items=$query->take(100)->get();*/

//DB::enableQueryLog();
$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereRaw('db.time between "'.$start_week.'" and "'.$end_week.'"')->orderby('db.id','desc')->skip(0)->select('db.*');

$query->where(function($query) use ($sensorshubs, $sensors)
{
	for($i=0;$i<count($sensorshubs);$i++)
	{	
		if($i==0)
		{
			//$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			$query->where(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
		}
		else
		{
			$query->orwhere(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
			//$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
		}
		
	}
});
$items=$query->take(100)->get();


//dd(DB::getQueryLog());


$start_month=$start_week;
$end_month=$end_week;
$skip1=0;
$limit1=100;
$arrids[]=array();
$nooftimes=1;
$i=0;
$currentoffset=0;
$pageno=1;



		}
		if($tme =='day')
		{
			
/*$items=DB::table('dbo_payloader')->whereDate('dbo_payloader.time', Carbon::today())->where('dbo_payloader.unit',"$unit")->whereIn('dbo_payloader.hub',$hubsname)->whereIn('dbo_payloader.sensor_id',$sensor)->orderby('dbo_payloader.id','desc')->skip(0)->take(100)->get();*/

//DB::enableQueryLog();
$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereDate('db.time', Carbon::today())->orderby('db.id','desc')->skip(0)->select('db.*');

$query->where(function($query) use ($sensorshubs, $sensors)
{
	for($i=0;$i<count($sensorshubs);$i++)
	{	
		if($i==0)
		{
			//$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			$query->where(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
		}
		else
		{
			$query->orwhere(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
			//$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
		}
		
	}
});
$items=$query->take(100)->get();
//dd(DB::getQueryLog());
$itemscount=count($items);
//dd($itemscount);

//dd($items);
//->where('agent','like',"%$agent%")->
$start_month=$request->input('from');
$end_month=$request->input('to');
$skip1=0;
$limit1=100;
$arrids[]=array();
$nooftimes=1;
$i=0;
$currentoffset=0;
$pageno=1;			
		}
		if($tme =='month')
		{
			$start_month = strtotime("-29 day");
			$end_month = strtotime("+1 day");
			$start_month = date("Y-m-d",$start_month);
			$end_month = date("Y-m-d",$end_month);
			/*$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->whereRaw('users.id = "'.$agent.'"')
			->where('dbo_payloader.unit', $unit)
			->whereIn('gateway_groups.id', $group)
			->whereIn('dbo_payloader.hub', $hubsname)
			->whereIn('dbo_payloader.sensor_id', $sensor)		
			->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();*/

/*$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')->whereIn('dbo_payloader.sensor_id', $sensor)->orderby('dbo_payloader.id','desc')->skip(0)->take(100)->get();*/
//->where('agent','like',"%$agent%")->
//dd($sensors,$sensorshubs);
//DB::enableQueryLog();
/*$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereRaw('db.time between "'.$start_month.'" and "'.$end_month.'"')->orderby('db.id','desc')->skip(0)->select('db.*');
for($i=0;$i<count($sensorshubs);$i++){
	if($i==0){
$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
else{
$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
}
$items=$query->take(100)->get();*/

$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereRaw('db.time between "'.$start_month.'" and "'.$end_month.'"')->orderby('db.id','desc')->skip(0)->select('db.*');

$query->where(function($query) use ($sensorshubs, $sensors)
{
	for($i=0;$i<count($sensorshubs);$i++)
	{	
		if($i==0)
		{
			//$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			$query->where(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
		}
		else
		{
			$query->orwhere(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
			//$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
		}
		
	}
});
$items=$query->take(100)->get();



//dd(DB::getQueryLog());

$skip1=0;
$limit1=100;
$arrids[]=array();
$nooftimes=1;
$i=0;
$currentoffset=0;
$pageno=1;

		

		}
		if($tme=='one')
		{	
			$start = date("Y-m-d",strtotime($request->input('from')));
			$end = date("Y-m-d",strtotime($request->input('to')."+1 day"));
			/*$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')
			->whereRaw('users.id = "'.$agent.'"')
			->where('dbo_payloader.unit', $unit)
			->whereIn('gateway_groups.id', $group)
			->whereIn('dbo_payloader.hub', $hubsname)
			->whereIn('dbo_payloader.sensor_id', $sensor)
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();*/

/*$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')->whereIn('dbo_payloader.sensor_id', $sensor)->orderby('dbo_payloader.id','desc')->skip(0)->take(100)->get();*/
/*$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereRaw('db.time between "'.$start.'" and "'.$end.'"')->orderby('db.id','desc')->skip(0)->select('db.*');
for($i=0;$i<count($sensorshubs);$i++){
	if($i==0){
$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
else{
$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
}
}
$items=$query->take(100)->get();*/
$query=DB::table('dbo_payloader as db')->where('db.unit', $unit)->whereRaw('db.time between "'.$start.'" and "'.$end.'"')->orderby('db.id','desc')->skip(0)->select('db.*');

$query->where(function($query) use ($sensorshubs, $sensors)
{
	for($i=0;$i<count($sensorshubs);$i++)
	{	
		if($i==0)
		{
			//$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			$query->where(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
		}
		else
		{
			$query->orwhere(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
			//$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
		}
		
	}
});
$items=$query->take(100)->get();


//->where('agent','like',"%$agent%")
$start_month=$request->input('from');
$end_month=$request->input('to');
$skip1=0;
$limit1=100;
$arrids[]=array();
$nooftimes=1;
$i=0;
$currentoffset=0;
$pageno=1;


		}
		return view('agent.report.pagination_data2')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);
	}







public function getsensortime_22_8_2020(Request $request)
	{

		//$unit="";
		//$agent = $request->input('agent');
		$agent = session()->get('userid');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$sensor = $request->input('sensor');
		$tme = $request->input('tme');
		//$group = implode(",",$group);
		$hub = implode(",",$hub);
		$hubs = DB::table('sensor_hubs')->whereRaw('id in ('.$hub.')')->get();	
		//dd($hubs);	
		foreach($hubs as $hubname)
		{
			$hubsname[] = $hubname->hub_id;
		}
		$hub = implode(',', $hubsname);
		$unit = urldecode($request->input('unit'));
		$currentoffset=0;
		if($tme=='week')
		{	
			$start_week = strtotime("-6 day");
			$end_week = strtotime("+1 day");
			// $previous_week = strtotime("-1 week +1 day");
			// $start_week = strtotime("last sunday midnight",$previous_week);
			// $end_week = strtotime("next saturday",$start_week);
			$start_week = date("Y-m-d",$start_week);
			$end_week = date("Y-m-d",$end_week);
			/*$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')
			->whereRaw('users.id = "'.$agent.'"')
			->where('dbo_payloader.unit', $unit)
			->whereIn('gateway_groups.id', $group)
			->whereIn('dbo_payloader.hub', $hubsname)
			->whereIn('dbo_payloader.sensor_id', $sensor)
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();*/

$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')->whereIn('dbo_payloader.sensor_id', $sensor)->orderby('dbo_payloader.id','desc')->skip(0)->take(100)->get();
//->where('agent','like',"%$agent%")
$start_month=$start_week;
$end_month=$end_week;
$skip1=0;
$limit1=100;
$arrids[]=array();
$nooftimes=1;
$i=0;
$currentoffset=0;
$pageno=1;



		}
		if($tme =='day')
		{
			//dd($tme);
			/*$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->whereRaw('users.id = "'.$agent.'"')
			->where('dbo_payloader.unit', $unit)
			->whereIn('gateway_groups.id', $group)
			->whereIn('dbo_payloader.hub', $hubsname)
			->whereIn('dbo_payloader.sensor_id', $sensor)
			->whereDate('dbo_payloader.time', Carbon::today())
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();*/

$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereDate('dbo_payloader.time', Carbon::today())->whereIn('dbo_payloader.sensor_id', $sensor)->orderby('dbo_payloader.id','desc')->skip(0)->take(100)->get();
//dd($items);
//->where('agent','like',"%$agent%")->
$start_month=$request->input('from');
$end_month=$request->input('to');
$skip1=0;
$limit1=100;
$arrids[]=array();
$nooftimes=1;
$i=0;
$currentoffset=0;
$pageno=1;			
		}
		if($tme =='month')
		{
			$start_month = strtotime("-29 day");
			$end_month = strtotime("+1 day");
			$start_month = date("Y-m-d",$start_month);
			$end_month = date("Y-m-d",$end_month);
			/*$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->whereRaw('users.id = "'.$agent.'"')
			->where('dbo_payloader.unit', $unit)
			->whereIn('gateway_groups.id', $group)
			->whereIn('dbo_payloader.hub', $hubsname)
			->whereIn('dbo_payloader.sensor_id', $sensor)		
			->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();*/

$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')->whereIn('dbo_payloader.sensor_id', $sensor)->orderby('dbo_payloader.id','desc')->skip(0)->take(100)->get();
//->where('agent','like',"%$agent%")->

$skip1=0;
$limit1=100;
$arrids[]=array();
$nooftimes=1;
$i=0;
$currentoffset=0;
$pageno=1;

		

		}
		if($tme=='one')
		{	
			$start = date("Y-m-d",strtotime($request->input('from')));
			$end = date("Y-m-d",strtotime($request->input('to')."+1 day"));
			/*$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')
			->whereRaw('users.id = "'.$agent.'"')
			->where('dbo_payloader.unit', $unit)
			->whereIn('gateway_groups.id', $group)
			->whereIn('dbo_payloader.hub', $hubsname)
			->whereIn('dbo_payloader.sensor_id', $sensor)
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();*/

$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')->whereIn('dbo_payloader.sensor_id', $sensor)->orderby('dbo_payloader.id','desc')->skip(0)->take(100)->get();
//->where('agent','like',"%$agent%")
$start_month=$request->input('from');
$end_month=$request->input('to');
$skip1=0;
$limit1=100;
$arrids[]=array();
$nooftimes=1;
$i=0;
$currentoffset=0;
$pageno=1;


		}
		return view('agent.report.pagination_data2')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);
	}














	
	public function getsensortime_22_7_2020(Request $request)
	{
		$agent = session()->get('userid');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$sensor = $request->input('sensor');
		$tme = $request->input('tme');
		$group = implode(",",$group);
		$hub = implode(",",$hub);
		$hubs = DB::table('sensor_hubs')->whereRaw('id in ('.$hub.')')->get();		
		foreach($hubs as $hubname)
		{
			$hubsname[] = $hubname->hub_id;
		}
		$hub = implode(',', $hubsname);
		$unit = urldecode($request->input('unit'));
		if($tme=='week')
		{	
			$start_week = strtotime("-6 day");
			$end_week = strtotime("+1 day");
			$start_week = date("Y-m-d",$start_week);
			$end_week = date("Y-m-d",$end_week);
			$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')
			->whereRaw('users.id = "'.$agent.'"')
			->where('dbo_payloader.unit', $unit)
			->whereRaw('gateway_groups.id in ('.$group.')')
			->whereIn('dbo_payloader.hub', $hubsname)
			->whereIn('dbo_payloader.sensor_id', $sensor)
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();
		}
		if($tme =='day')
		{
			$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->whereRaw('users.id = "'.$agent.'"')
			->where('dbo_payloader.unit', $unit)
			->whereRaw('gateway_groups.id in ('.$group.')')
			->whereIn('dbo_payloader.hub', $hubsname)
			->whereIn('dbo_payloader.sensor_id', $sensor)
			->whereDate('dbo_payloader.time', Carbon::today())
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();
		}
		if($tme =='month')
		{
			$start_month = strtotime("-29 day");
			$end_month = strtotime("+1 day");
			$start_month = date("Y-m-d",$start_month);
			$end_month = date("Y-m-d",$end_month);
			$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->whereRaw('users.id = "'.$agent.'"')
			->where('dbo_payloader.unit', $unit)
			->whereRaw('gateway_groups.id in ('.$group.')')
			->whereIn('dbo_payloader.hub', $hubsname)
			->whereIn('dbo_payloader.sensor_id', $sensor)
			//->whereMonth('dbo_payloader.time', '=', Carbon::now()->subMonth()->month)
			->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();
		}
		if($tme=='one')
		{	
			$start = date("Y-m-d",strtotime($request->input('from')));
			$end = date("Y-m-d",strtotime($request->input('to')."+1 day"));
			$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')
			->whereRaw('users.id = "'.$agent.'"')
			->where('dbo_payloader.unit', $unit)
			->whereRaw('gateway_groups.id in ('.$group.')')
			->whereIn('dbo_payloader.hub', $hubsname)
			->whereIn('dbo_payloader.sensor_id', $sensor)
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();
		}
		return view('agent.report.pagination_data2')->with(['items'=>$items]);
	}

public function pushmsgreset(Request $request)
	{


$items = DB::table('algorithm')->join('userdatamessages', 'userdatamessages.algorithmid', '=', 'algorithm.id')->join('users', 'users.id', '=', 'userdatamessages.userid')->orderBy('userdatamsgid','desc')->where('users.id', session()->get('userid'))->where('users.id', session()->get('userid'))->select('users.fname', 'users.lname','userdatamessages.created_at', 'algorithm.push_message', 'algorithm.id as pid','userdatamessages.readflag','userdatamessages.userdatamsgid as udi','userdatamessages.*')->paginate(1000);	



	}



	public function pushmsg(Request $request)
	{
		$start = date("Y-m-d",strtotime($request->input('from')));
		$end = date("Y-m-d",strtotime($request->input('to')."+1 day"));
		/*$items = DB::table('algorithm')
		->join('algorithm_sensor', 'algorithm_sensor.algorithm_id', '=', 'algorithm.id')
		->join('sensors', 'sensors.id', '=', 'algorithm_sensor.sensor')
		->join('users', 'users.id', '=', 'algorithm.userid')
		->whereRaw('algorithm.created_at between "'.$start.'" and "'.$end.'"')
		->where('users.id', session()->get('userid'))
		->select('sensors.*','algorithm.created_at', 'algorithm.push_message', 'algorithm.id as pid')
		->get();*/

/*$items = DB::table('algorithm')
			->join('algorithm_sensor', 'algorithm_sensor.algorithm_id', '=', 'algorithm.id')
			->join('gateway_groups', 'gateway_groups.id', '=', 'algorithm_sensor.groupid')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('sensor_hubs', 'sensor_hubs.id', '=', 'algorithm_sensor.hub')
			->join('sensors', 'sensors.id', '=', 'algorithm_sensor.sensor')->join('userdatamessages', 'userdatamessages.algorithmid', '=', 'algorithm.id')->join('users', 'users.id', '=', 'userdatamessages.userid')->orderBy('userdatamsgid','desc')
			//->join('users', 'users.id', '=', 'algorithm.userid')->orderBy('userdatamsgid','desc')
			//->whereRaw('algorithm.created_at between "'.$start.'" and "'.$end.'"')->where('users.id', session()->get('userid'))
			->whereRaw('userdatamessages.created_at between "'.$start.'" and "'.$end.'"')->where('users.id', session()->get('userid'))
			->select('users.fname', 'users.lname', 'sensor_groups.name', 'sensor_hubs.hub_id', 'sensors.sensor_id', 'userdatamessages.created_at', 'algorithm.push_message', 'algorithm.id as pid','userdatamessages.readflaguserid','userdatamessages.userdatamsgid as udi')->paginate(100);*/
			//->get();
//dd("hello");

$items = DB::table('algorithm')->join('userdatamessages', 'userdatamessages.algorithmid', '=', 'algorithm.id')->join('users', 'users.id', '=', 'userdatamessages.userid')->orderBy('userdatamsgid','desc')->where('users.id', session()->get('userid'))->whereRaw('userdatamessages.created_at between "'.$start.'" and "'.$end.'"')->where('users.id', session()->get('userid'))->select('users.fname', 'users.lname','userdatamessages.created_at', 'algorithm.push_message', 'algorithm.id as pid','userdatamessages.readflag','userdatamessages.userdatamsgid as udi','userdatamessages.*')->paginate(1000);		



		return view('agent.report.pushmsg')->with(['messages'=>$items]);
	}
	function fetch_data2(Request $request)
    {
		$group = $request->input('group');
		$hub = $request->input('hub');
		$sensor = $request->input('sensor');
		$tme = $request->input('tme');
		$unit = $request->input('unit');
		
		if($tme=='week')
		{
			$previous_week = strtotime("-1 week +1 day");
			$start_week = strtotime("last sunday midnight",$previous_week);
			$end_week = strtotime("next saturday",$start_week);
			$start_week = date("Y-m-d",$start_week);
			$end_week = date("Y-m-d",$end_week);	
			$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')
			->where('users.id', session()->get('userid'))
			->where('dbo_payloader.unit', $unit)
			->whereRaw('gateway_groups.id in ('.$group.')')
			->whereRaw('sensor_hubs.id in ('.$hub.')')
			->whereRaw('dbo_payloader.sensor_id in ("'.$sensor.'")')
			->paginate(10);
		}
		if($tme=='day')
		{
			$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->where('users.id', session()->get('userid'))
			->where('dbo_payloader.unit', $unit)
			->whereRaw('gateway_groups.id in ('.$group.')')
			->whereRaw('sensor_hubs.id in ('.$hub.')')
			->whereRaw('dbo_payloader.sensor_id in ("'.$sensor.'")')
			->whereDate('dbo_payloader.time', Carbon::today())
			->paginate(10);
		}
		if($tme=='month')
		{
			$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->where('users.id', session()->get('userid'))
			->where('dbo_payloader.unit', $unit)
			->whereRaw('gateway_groups.id in ('.$group.')')
			->whereRaw('sensor_hubs.id in ('.$hub.')')
			->whereRaw('dbo_payloader.sensor_id in ("'.$sensor.'")')
			->whereMonth('dbo_payloader.time', '=', Carbon::now()->subMonth()->month)
			->paginate(10);
		}
		if($tme=='one')
		{	
			$start = date("Y-m-d",strtotime($request->input('from')));
			$end = date("Y-m-d",strtotime($request->input('to')."+1 day"));
			$items = DB::table('sensors')
			->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
			->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')
			->where('users.id', session()->get('userid'))
			->where('dbo_payloader.unit', $unit)
			->whereRaw('gateway_groups.id in ('.$group.')')
			->whereRaw('sensor_hubs.id in ('.$hub.')')
			->whereRaw('dbo_payloader.sensor_id in ("'.$sensor.'")')
			->paginate(10);
		}	
		return view('agent.report.pagination_data2')->with(['items'=>$items]);
    }
	function export(Request $request)
    {

		$agent = session()->get('userid');
		$group = $request->input('group');
		$hub = $request->input('hub');
		//$sensor = $request->input('sensor1');
		$sensor = $request->input('sensor');
		$tme = $request->input('tme');
		$from = $request->input('from');
		$to = $request->input('to');


		$hub = implode(",",$hub);
		$hubs = DB::table('sensor_hubs')->whereRaw('id in ('.$hub.')')->get();		
		foreach($hubs as $hubname)
		{
			$hubsname[] = $hubname->hub_id;
		}
$unit = $request->input('unit');
		/*return Excel::download(new ReportExport(array('agent'=>$agent,'group'=>$group,'hub'=>$hub,'sensor'=>$sensor,'tme'=>$tme,'from'=>$from,'to'=>$to)), 'sensors.xlsx');*/
$loginid=session()->get('userid');
//dd($agent,$group,$hubsname,$sensor,$tme,$from,$to);
return Excel::download(new ReportExport(array('agent'=>$agent,'group'=>$group,'hub'=>$hubsname,'sensor'=>$sensor,'tme'=>$tme,'from'=>$from,'to'=>$to,'unit'=>$unit,'loginid'=>$loginid)), 'sensortimereport.xlsx');

		//return Excel::download(new ReportExport(array('agent'=>$agent,'group'=>$group,'hub'=>$hubsname,'sensor'=>$sensor,'tme'=>$tme,'from'=>$from,'to'=>$to,'unit'=>$unit,'loginid'=>$loginid)), 'sensortimereport.xlsx');


		
    }
	function exporthub(Request $request)
    {
		//echo 'test';die();
		$agent = session()->get('userid');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$tme = $request->input('tme');
		$hubs = DB::table('sensor_hubs')->where('id', $hub)->first();		
		$hubsname = $hubs->hub_id;
		$from = $request->input('from');
		$to = $request->input('to');
		return Excel::download(new Reporthub(array('agent'=>$agent,'group'=>$group,'hub'=>$hubsname, 'tme'=>$tme,'from'=>$from,'to'=>$to)), 'sensors.xlsx');		
    }
	function export3(Request $request)
    {

		$agent = session()->get('userid');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$sensor = $request->input('sensor');
		
		$group=implode(",",$group);
		$hub=implode(",",$hub);
		//echo $sensor=implode(",",$sensor);exit;
		$sensor="'" . implode ( "', '", $sensor ) . "'";
		
		$start = date("Y-m-d",strtotime($request->input('from')));
        $end = date("Y-m-d",strtotime($request->input('to')."+1 day"));

		return Excel::download(new SensorExport(array('agent'=>$agent,'group'=>$group,'hub'=>$hub,'sensor'=>$sensor,'start'=>$start,'end'=>$end)), 'sensors.xlsx');

    }

	public function showSensor($id="")
    {
        //abort_unless(\Gate::allows('product_access'), 403);

        //$groups = Group::all();
		
		//$agents = DB::select('select * from users inner join role_user on users.id=role_user.user_id where role_user.role_id=1');
		$sensors = DB::table('sensors')
		->where('hub_id', $id)
		->join('types', 'sensors.type', '=', 'types.id')
		->join('brands', 'sensors.brand', '=', 'brands.id')
		->join('measurement_units', 'sensors.measure_unit', '=', 'measurement_units.id')
		->join('units', 'measurement_units.unit', '=', 'units.id')
		->select('sensors.*','sensors.id as sensorid', 'types.name as typename', 'brands.name as brandname', 'units.name as unitname','measurement_units.*')
        ->paginate(10); 
		//print_r($groups);
        return view('admin.sensor.index')->with(['sensors'=>$sensors,'hubid'=>$id]);
    }
	
	######Gateway Groups##########
	
	public function addSensor($id="")
	{
		$types = DB::table('types')
				->get();
		$brands = DB::table('brands')
                ->get();
		$units = DB::table('measurement_units')
				->join('units', 'measurement_units.unit', '=', 'units.id')
				->select('measurement_units.*', 'units.name')
                ->get();
		$units2= DB::table('units')
                ->get();
		//print_r($units);exit;
		return view('admin.sensor.create')->with(['types'=>$types,'brands'=>$brands,'hub_id'=>$id,'units'=>$units,'units2'=>$units2]);
	}
	
	public function insertSensor(Request $request){
		$hub_id = $request->input('hub_id');
		$sensor_id = $request->input('sensor_id');
		
		$type = $request->input('type');
		$brand = $request->input('brand');
		$measure_unit = $request->input('unit');
		$sensor_inform = $request->input('inform');
		
		$data=array('hub_id'=>$hub_id,'sensor_id'=>$sensor_id,'type'=>$type,'brand'=>$brand,'measure_unit'=>$measure_unit,'sensor_inform'=>$sensor_inform);
		$value=DB::table('sensors')->insertGetId($data);
		if($value)
		{
		//echo "Record inserted successfully.<br/>";
		Session::flash('flash_message', 'Record inserted successfully.');
		}
		else
		{
		Session::flash('flash_message', 'Error !!!.');
		//echo '<a href = "/insert">Click Here</a> to go back.';
		}
		return redirect('admin/showsensor/'.$hub_id);
	}
	
	public function editSensor($id='',$hid='')
	{
		$types = DB::table('types')
				->get();
		$brands = DB::table('brands')
                ->get();
		$units = DB::table('measurement_units')
				->join('units', 'measurement_units.unit', '=', 'units.id')
				->select('measurement_units.*', 'units.name')
                ->get();
		$units2= DB::table('units')
                ->get();
		$group = DB::select('select * from sensors where id='.$id);
		//print_r($group);exit;
		return view('admin.sensor.edit')->with(['types'=>$types,'brands'=>$brands,'hub_id'=>$id,'units'=>$units,'group'=>$group,'units2'=>$units2]);
	}
	
	public function updateSensor(Request $request){
		$id = $request->input('eid');
		
		$hub_id = $request->input('hub_id');
		$sensor_id = $request->input('sensor_id');
		
		$type = $request->input('type');
		$brand = $request->input('brand');
		$measure_unit = $request->input('unit');
		$sensor_inform = $request->input('inform');
		
		$data=array('hub_id'=>$hub_id,'sensor_id'=>$sensor_id,'type'=>$type,'brand'=>$brand,'measure_unit'=>$measure_unit,'sensor_inform'=>$sensor_inform);
		$value=DB::table('sensors')
            ->where('id', $id)
            ->update($data);
			
//		if($value)
//		{
//		Session::flash('flash_message', 'Record updated successfully.');
//		}
//		else
//		{
//		Session::flash('flash_message', 'Error !!!.');
//		}
		return redirect('admin/showsensor/'.$hub_id)->with('flash_message','Record updated successfully.');
	}
	
	public function deleteSensor($id=0){

    if($id != 0){
      // Delete
      DB::table('sensors')->where('id', '=', $id)->delete();

      Session::flash('flash_message','Delete successfully.');
      
    }
    return redirect()->back();
    }
	
	public function generateId()
	{
	$affected = DB::select("select * FROM sensor_hubs");
	if(count($affected)==0)
	{
	$n=1;
	}
	else
	{
	$groups = DB::table('sensor_hubs')->max('id');
	$grp=DB::select("select sensor_hub_id FROM sensor_hubs where id=".$groups);
	$str=substr($grp[0]->sensor_hub_id,2,strlen($grp[0]->sensor_hub_id));
	(int)$str++;
	$n=$str;
	}
	$num_of_ids = 10000; //Number of "ids" to generate.
	$i = 0; //Loop counter.
	
	$l = "SH"; //"id" letter piece.
	
	//while ($i <= $num_of_ids) { 
	$id = $l . sprintf("%04d", $n); //Create "id". Sprintf pads the number to make it 4 digits.
	return $id;
	}
	

	public function getpushmsg(){
		

			$items = DB::table('algorithm')->join('userdatamessages', 'userdatamessages.algorithmid', '=', 'algorithm.id')->join('users', 'users.id', '=', 'userdatamessages.userid')->orderBy('userdatamsgid','desc')->where('users.id', session()->get('userid'))->select('users.fname', 'users.lname','userdatamessages.created_at', 'algorithm.push_message', 'algorithm.id as pid','userdatamessages.readflag','userdatamessages.userdatamsgid as udi','userdatamessages.*')->paginate(1000);		

return view('agent.report.pushmsg')->with(['messages'=>$items]);
	}

public function getpushmsgload(){
		

			$items = DB::table('algorithm')->join('userdatamessages', 'userdatamessages.algorithmid', '=', 'algorithm.id')->join('users', 'users.id', '=', 'userdatamessages.userid')->orderBy('userdatamsgid','desc')->where('users.id', session()->get('userid'))->select('users.fname', 'users.lname','userdatamessages.created_at', 'algorithm.push_message', 'algorithm.id as pid','userdatamessages.readflag','userdatamessages.userdatamsgid as udi','userdatamessages.*')->paginate(1000);		

return view('agent.report.pushmsg')->with(['messages'=>$items]);
	}




	######Gateway Groups##########
	
    //public function create()
//    {
//        abort_unless(\Gate::allows('product_create'), 403);
//
//        return view('admin.products.create');
//    }
//
//    public function store(StoreProductRequest $request)
//    {
//        abort_unless(\Gate::allows('product_create'), 403);
//
//        $product = Product::create($request->all());
//
//        return redirect()->route('admin.products.index');
//    }
//
//    public function edit(Product $product)
//    {
//        abort_unless(\Gate::allows('product_edit'), 403);
//
//        return view('admin.products.edit', compact('product'));
//    }
//
//    public function update(UpdateProductRequest $request, Product $product)
//    {
//        abort_unless(\Gate::allows('product_edit'), 403);
//
//        $product->update($request->all());
//
//        return redirect()->route('admin.products.index');
//    }
//
//    public function show(Product $product)
//    {
//        abort_unless(\Gate::allows('product_show'), 403);
//
//        return view('admin.products.show', compact('product'));
//    }
//
//    public function destroy(Product $product)
//    {
//        abort_unless(\Gate::allows('product_delete'), 403);
//
//        $product->delete();
//
//        return back();
//    }
//
//    public function massDestroy(MassDestroyProductRequest $request)
//    {
//        Product::whereIn('id', request('ids'))->delete();
//
//        return response(null, 204);
//    }
}
