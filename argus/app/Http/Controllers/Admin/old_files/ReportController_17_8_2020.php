<?php
 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

use App\Exports\ReportExport;
use App\Exports\SensorExport;
use App\Exports\ReportadminExport;
use App\Exports\Reportadminhub;
use Maatwebsite\Excel\Facades\Excel;
use App\dbopayloader;

use Illuminate\Http\Request;
use Session;
use Hash;
use Carbon\Carbon;
//use App\Group;
use DB;

class ReportController extends Controller
{

public function __construct() 
{
    // Fetch the Site Settings object
    //ini_set("memory_limit","16M");
    //$dbitems=DB::table('dbo_payloader')->get();
    //$dbitems = dbopayloader::get();
    
}

public function getallrecords(){
	$dbitems=DB::table('dbo_payloader')->get();
	return $dbitems;
}
    public function index()
    {

		$sensors = DB::table('sensors')
        ->paginate(10);
		//print_r($groups);
        return view('admin.sensor.index')->with(['sensors'=>$sensors,'hubid'=>$id]);
    }
	


public function userlogdemochart()
	{


		//$dbarr=DB::table('dbo_payloader')->get();
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
		
		$groups = DB::table('sensor_groups')
			->get();
		$hubs = DB::table('hubs')
			->get();
		$items = DB::table('algorithm')
			/*->join('algorithm_sensor', 'algorithm_sensor.algorithm_id', '=', 'algorithm.id')
			->join('gateway_groups', 'gateway_groups.id', '=', 'algorithm_sensor.groupid')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('sensor_hubs', 'sensor_hubs.id', '=', 'algorithm_sensor.hub')
			->join('sensors', 'sensors.id', '=', 'algorithm_sensor.sensor')*/
			->join('userdatamessages', 'userdatamessages.algorithmid', '=', 'algorithm.id')->join('users', 'users.id', '=', 'userdatamessages.userid')->orderBy('userdatamsgid','desc')
			//->join('users', 'users.id', '=', 'userdatamessages.userid')
			//->join('users', 'users.id', '=', 'algorithm.userid')
			//->where('users.id', session()->get('userid'))
			//->select('users.fname', 'users.lname', 'sensor_groups.name', 'sensor_hubs.hub_id', 'sensors.sensor_id', 'userdatamessages.created_at', 'algorithm.push_message', 'algorithm.id as pid','userdatamessages.readflag','userdatamessages.userdatamsgid as udi')->paginate(100);
->select('users.fname', 'users.lname','userdatamessages.created_at', 'algorithm.push_message', 'algorithm.id as pid','userdatamessages.readflag','userdatamessages.userdatamsgid as udi','userdatamessages.*')->paginate(1000);


			//dd($items);

				//$countmsgdt=DB::table('algorithm')->where('readflag',0)->get();
			$countmsgdt=DB::table('userdatamessages')->where('readflag',0)->get();
				$countmsg=count($countmsgdt);
$currentoffset=0;
$pageno=0;
$currentoffsethub=0;
$pagenohub=0;
		return view('admin.report.indexchartdemo')->with(['sensors'=>$sensors,'agents'=>$agents,'agents_count'=>$agents_count,'sensors_count'=>$sensors_count,'perlogin'=>$perlogin,'perlogout'=>$perlogout,'perlogin2'=>$perlogin2,'perlogout2'=>$perlogout2,'groups'=>$groups,'hubs'=>$hubs,'messages'=>$items,'countmsg'=>$countmsg,'currentoffset'=>$currentoffset,'pageno'=>$pageno,'currentoffsethub'=>$currentoffsethub,'pagenohub'=>$pagenohub]);
	}








	public function userlog()
	{


		//$dbarr=DB::table('dbo_payloader')->get();
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
		
		$groups = DB::table('sensor_groups')
			->get();
		$hubs = DB::table('hubs')
			->get();
		$items = DB::table('algorithm')
			/*->join('algorithm_sensor', 'algorithm_sensor.algorithm_id', '=', 'algorithm.id')
			->join('gateway_groups', 'gateway_groups.id', '=', 'algorithm_sensor.groupid')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('sensor_hubs', 'sensor_hubs.id', '=', 'algorithm_sensor.hub')
			->join('sensors', 'sensors.id', '=', 'algorithm_sensor.sensor')*/
			->join('userdatamessages', 'userdatamessages.algorithmid', '=', 'algorithm.id')->join('users', 'users.id', '=', 'userdatamessages.userid')->orderBy('userdatamsgid','desc')
			//->join('users', 'users.id', '=', 'userdatamessages.userid')
			//->join('users', 'users.id', '=', 'algorithm.userid')
			//->where('users.id', session()->get('userid'))
			//->select('users.fname', 'users.lname', 'sensor_groups.name', 'sensor_hubs.hub_id', 'sensors.sensor_id', 'userdatamessages.created_at', 'algorithm.push_message', 'algorithm.id as pid','userdatamessages.readflag','userdatamessages.userdatamsgid as udi')->paginate(100);
->select('users.fname', 'users.lname','userdatamessages.created_at', 'algorithm.push_message', 'algorithm.id as pid','userdatamessages.readflag','userdatamessages.userdatamsgid as udi','userdatamessages.*')->paginate(1000);


			//dd($items);

				//$countmsgdt=DB::table('algorithm')->where('readflag',0)->get();
			$countmsgdt=DB::table('userdatamessages')->where('readflag',0)->get();
				$countmsg=count($countmsgdt);
$currentoffset=0;
$pageno=0;
$currentoffsethub=0;
$pagenohub=0;
//dd("hai");
		return view('admin.report.index')->with(['sensors'=>$sensors,'agents'=>$agents,'agents_count'=>$agents_count,'sensors_count'=>$sensors_count,'perlogin'=>$perlogin,'perlogout'=>$perlogout,'perlogin2'=>$perlogin2,'perlogout2'=>$perlogout2,'groups'=>$groups,'hubs'=>$hubs,'messages'=>$items,'countmsg'=>$countmsg,'currentoffset'=>$currentoffset,'pageno'=>$pageno,'currentoffsethub'=>$currentoffsethub,'pagenohub'=>$pagenohub]);
	}
	public function uppushmsgreadflagcount()
	{
		$countmsgdt=DB::table('userdatamessages')->where('readflag',0)->get();
		$countmsg=count($countmsgdt);
		echo $countmsg;
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

    public function getchartpage(Request $request){
$agent = $request->input('agent');
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

if($tme=='month')
		{
			//foreach($sensor as $sensorname) 
			//{
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
				
				//dd($i,$n,$skip);
//while($i<$n){

/*$groupsitem=DB::table('dbo_payloader')->skip($skip)->take(100)
				->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereIn('dbo_payloader.sensor_id', $sensor)->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')->get();*/
 ini_set("memory_limit","16M");
			/*	dbopayLoader::chunk(1000, function ($users) {
  foreach ($users as $user) {
  	$groupsitem[]=$user->id;
    
  }
});*/
				//$skip=$skip+100;
				//}
$i=0;
				$n=10;
				$skip=0;
				while($i<$n){
$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')->whereIn('dbo_payloader.sensor_id', $sensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();

$itemscount=count($items);
if ($itemscount<100)
{
	break;
}
$skip=$skip+100;
$i++;
}

dd($items,$i);

//$deldt=DB::table('dbo_payloadercharttemp')->delete();
/*$groups=DB::table('dbo_payloadercharttemp')->where('dbo_payloadercharttemp.unit', $unit)->whereIn('dbo_payloadercharttemp.hub', $hubsname)->whereRaw('dbo_payloadercharttemp.time between "'.$start_month.'" and "'.$end_month.'"')->whereIn('dbo_payloadercharttemp.sensor_id', $sensor)->get();*/

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
		//}


//return json_encode($arr);









    }
	public function getChart(Request $request)
	{  
		$agent = $request->input('agent');
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
		$arr['count']=0;
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
$groups=DB::table('dbo_payloadercharttemp')->where('dbo_payloadercharttemp.unit', $unit)->whereIn('dbo_payloadercharttemp.hub', $hubsname)->whereRaw('dbo_payloadercharttemp.time between "'.$start_week.'" and "'.$end_week.'"')->where('loginid',$loginid)->whereIn('dbo_payloadercharttemp.sensor_id', $sensor)->select(array('dbo_payloadercharttemp.*'))->get();





				
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
$groups=DB::table('dbo_payloadercharttemp')->where('dbo_payloadercharttemp.unit', $unit)->whereIn('dbo_payloadercharttemp.hub', $hubsname)->whereDate('dbo_payloadercharttemp.time', Carbon::today())->where('loginid',$loginid)->whereIn('dbo_payloadercharttemp.sensor_id', $sensor)->get();



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

//dd($arr);

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
				$loginid=session()->get('userid');
$groups=DB::table('dbo_payloadercharttemp')->where('dbo_payloadercharttemp.unit', $unit)->whereIn('dbo_payloadercharttemp.hub', $hubsname)->whereRaw('dbo_payloadercharttemp.time between "'.$start_month.'" and "'.$end_month.'"')->where('loginid',$loginid)->whereIn('dbo_payloadercharttemp.sensor_id', $sensor)->select(array('dbo_payloadercharttemp.*'))->get();

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
$groups=DB::table('dbo_payloadercharttemp')->where('dbo_payloadercharttemp.unit', $unit)->whereIn('dbo_payloadercharttemp.hub', $hubsname)->whereRaw('dbo_payloadercharttemp.time between "'.$start.'" and "'.$end.'"')->where('loginid',$loginid)->whereIn('dbo_payloadercharttemp.sensor_id', $sensor)->select(array('dbo_payloadercharttemp.*'))->get();



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
	
	public function getChart3(Request $request)
	{
		$agent = $request->input('agent');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$sensor = $request->input('sensor');
		$tme = $request->input('tme');
		$agent = implode(",",$agent);
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
		//->join('chart', 'chart.unit', '=', 'sensors.unit')
		->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')
		->whereRaw('users.id in ('.$agent.')')
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
			// $timestemp = $item->time;
			// $day = Carbon::createFromFormat('Y-m-d H:i:s', $timestemp)->format('l');
			$arr['hour'][]  = date('d-m-Y', strtotime($item->time));
			$arr['value'][] = (float)$item->value;
			$arr['chart'][0] = $chartnam;	
		}	
		return json_encode($arr);
	}		

public function deletetempdata(){
	$loginid=session()->get('userid');
$deldt=DB::table('dbo_payloadercharttemp')->where('loginid',$loginid)->delete();
echo "1";

}
public function savecharttempdata(Request $request){

$agent = $request->input('agent');
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
error_reporting(0);
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

$sensdt=DB::table('sensors')->where('sensor_id',$item->sensor_id)->where('unit',$item->unit)->first();
$hubid=$sensdt->hub_id;

/*$hubdt=DB::table('sensor_hubs')->where('id',$hubid)->first();
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
$sensdt=DB::table('sensors')->where('sensor_id',$item->sensor_id)->where('unit',$item->unit)->first();
$hubid=$sensdt->hub_id;
/*$hubdt=DB::table('sensor_hubs')->where('id',$hubid)->first();
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
	$sensdt=DB::table('sensors')->where('sensor_id',$item->sensor_id)->where('unit',$item->unit)->first();
$hubid=$sensdt->hub_id;
/*$hubdt=DB::table('sensor_hubs')->where('id',$hubid)->first();
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
	$sensdt=DB::table('sensors')->where('sensor_id',$item->sensor_id)->where('unit',$item->unit)->first();
$hubid=$sensdt->hub_id;
/*$hubdt=DB::table('sensor_hubs')->where('id',$hubid)->first();
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
public function getsensortimefetchpage(Request $request)
	{

$agent = $request->input('agent');
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

return view('admin.report.pagination_data2')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);



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
return view('admin.report.pagination_data2')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);






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
return view('admin.report.pagination_data2')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);
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
return view('admin.report.pagination_data2')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);


}




	}	


public function getsensortimefetchpageprev(Request $request)
	{

$agent = $request->input('agent');
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
$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')->where('agent','like',"%$agent%")->whereIn('dbo_payloader.sensor_id', $sensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();
//->where('agent','like',"%$agent%")->
$start_month=$start_week;
$end_month=$end_week;

return view('admin.report.pagination_data2')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);



	}







if ($tme=='day'){

$currentoffset=$request->input('currentoffset');
		
		$pageno=$request->input('pageno');
		$pageno=$pageno-1;
$currentoffset=($pageno-1)*100;
$skip=$currentoffset;

$items=DB::table('dbo_payloader')->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereDate('dbo_payloader.time', Carbon::today())->whereIn('dbo_payloader.sensor_id', $sensor)->where('agent','like',"%$agent%")->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();
//->where('agent','like',"%$agent%")->
return view('admin.report.pagination_data2')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);







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


return view('admin.report.pagination_data2')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);

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
return view('admin.report.pagination_data2')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);







}



	}	







	public function getsensortime(Request $request)
	{

		//$unit="";
		$agent = $request->input('agent');
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
			//dd("entered");
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

/*$itemscount=DB::table('dbo_payloader')->whereDate('dbo_payloader.time', Carbon::today())->where('dbo_payloader.unit', $unit)->whereIn('dbo_payloader.hub', $hubsname)->whereIn('dbo_payloader.sensor_id', $sensor)->orderby('dbo_payloader.id','desc')->skip(0)->take(100)->count();*/

//dd("count-".$itemscount);

//dd("reached");

$items=DB::table('dbo_payloader')->whereDate('dbo_payloader.time', Carbon::today())->where('dbo_payloader.unit',"$unit")->whereIn('dbo_payloader.hub',$hubsname)->whereIn('dbo_payloader.sensor_id',$sensor)->orderby('dbo_payloader.id','desc')->skip(0)->take(100)->get();
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
		return view('admin.report.pagination_data2')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);
	}
	function getchartcount()
    {
		//print_r(request()->val);die();
		//$unit = urldecode($request->input('unit'));
		$count = explode(',', request()->val);
		$cnt = count($count);
		return view('admin.report.count')->with(['count'=> $cnt]);
	}
	function getchartcounthub()
    {
		//$count = explode(',', request()->val);
		//$cnt = count($count);
		return view('admin.report.counthub')->with(['count'=> request()->val]);
	}



	function getchartcounthubdy()
    {
		//$count = explode(',', request()->val);
		//$cnt = count($count);
		return view('admin.report.counthubdy')->with(['count'=> request()->val]);
	}
	function fetch_data2(Request $request)
    {
		$agent = $request->input('agent');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$sensor = $request->input('sensor');
		$sensor = explode(',', $sensor);
		$tme = $request->input('tme');
		$unit = $request->input('unit');
		foreach($sensor as $sensorsingle)
		{
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
				->whereRaw('users.id = "'.$agent.'"')
				->where('dbo_payloader.unit', $unit)
				->whereRaw('gateway_groups.id in ('.$group.')')
				->whereRaw('sensor_hubs.id in ('.$hub.')')
				->whereRaw('dbo_payloader.sensor_id = "'.$sensorsingle.'"')
				->paginate(100);
			}
			if($tme=='day')
			{
				$items = DB::table('sensors')
				->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
				->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
				->join('users', 'sensor_hubs.agent', '=', 'users.id')
				->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
				->whereRaw('users.id = "'.$agent.'"')
				->where('dbo_payloader.unit', $unit)
				->whereRaw('gateway_groups.id in ('.$group.')')
				->whereRaw('sensor_hubs.id in ('.$hub.')')
				->whereRaw('dbo_payloader.sensor_id in ("'.$sensor.'")')
				->whereDate('dbo_payloader.time', Carbon::today())
				->paginate(100);
			}
			if($tme=='month')
			{
				$items = DB::table('sensors')
				->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
				->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
				->join('users', 'sensor_hubs.agent', '=', 'users.id')
				->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
				->whereRaw('users.id = "'.$agent.'"')
				->where('dbo_payloader.unit', $unit)
				->whereRaw('gateway_groups.id in ('.$group.')')
				->whereRaw('sensor_hubs.id in ('.$hub.')')
				->whereRaw('dbo_payloader.sensor_id in ("'.$sensor.'")')
				->whereMonth('dbo_payloader.time', '=', Carbon::now()->subMonth()->month)
				->paginate(100);
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
				->whereRaw('users.id = "'.$agent.'"')
				->where('dbo_payloader.unit', $unit)
				->whereRaw('gateway_groups.id in ('.$group.')')
				->whereRaw('sensor_hubs.id in ('.$hub.')')
				->whereRaw('dbo_payloader.sensor_id in ("'.$sensor.'")')
				->paginate(100);
			}	
			return view('admin.report.pagination_data2')->with(['items'=>$items]);
		}
    }
	
	function export(Request $request)
    {
		$agent = $request->input('agent');
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
		$unit = $request->input('unit');
		$from = $request->input('from');
		$to = $request->input('to');
		//dd($loginid);
		$loginid=session()->get('userid');


		return Excel::download(new ReportadminExport(array('agent'=>$agent,'group'=>$group,'hub'=>$hubsname,'sensor'=>$sensor,'tme'=>$tme,'from'=>$from,'to'=>$to,'unit'=>$unit,'loginid'=>$loginid)), 'sensortimereport.xlsx');
		
	}
	function exporthub(Request $request)
    {
		$agent = $request->input('agent');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$tme = $request->input('tme');
		$hubs = DB::table('sensor_hubs')->where('id', $hub)->first();		
		$hubsname = $hubs->hub_id;
		$from = $request->input('from');
		$to = $request->input('to');
		//dd($loginid);
		$loginid=session()->get('userid');
		return Excel::download(new Reportadminhub(array('agent'=>$agent,'group'=>$group,'hub'=>$hubsname, 'tme'=>$tme,'from'=>$from,'to'=>$to,'loginid'=>$loginid)), 'sensors.xlsx');		
    }
	function export3(Request $request)
    {

		$agent = $request->input('agent');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$sensor = $request->input('sensor');
		
		$group=implode(",",$group);
		$hub=implode(",",$hub);
		//echo $sensor=implode(",",$sensor);exit;
		$sensor="'" . implode ( "', '", $sensor ) . "'";
		
		$start = date("Y-m-d",strtotime($request->input('from')));
        $end = date("Y-m-d",strtotime($request->input('to')."+1 day"));
       // dd($loginid);
$loginid=session()->get('userid');
		return Excel::download(new SensorExport(array('agent'=>$agent,'group'=>$group,'hub'=>$hub,'sensor'=>$sensor,'start'=>$start,'end'=>$end,'loginid'=>$loginid)), 'sensors.xlsx');

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
	public function getsensorreport(Request $request)
	{
		$hub = $request->input('hub');
		$unit = $request->input('unit');
		if(!is_array($hub))
		{
    		$sensors = DB::table('sensors')
            ->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
			->where('sensors.hub_id', $hub)
			->where('sensors.unit', $unit)
			->groupBy('sensors.sensor_id')
    		->select('sensors.*')
    		->get();
		}
		else
		{
    		$sensors = DB::table('sensors')
            ->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
			->whereIn('sensors.hub_id', $hub)
			->where('sensors.unit', $unit)
			->groupBy('sensors.sensor_id')
    		->select('sensors.*')
    		->get();
		}
		echo '<select class="form-control sensor2" id="sensor2" name="sensor[]"  multiple="multiple" >';
		echo "<option value=''>Select</option>";
		foreach($sensors as $item)
		{
		    echo "<option value='".$item->sensor_id."'>".$item->sensor_id."</option>";
		}
		echo "</select>";
	}
	public function getsensorreport3(Request $request)
	{
		$hub = $request->input('hub');
		$unit = $request->input('unit');
		if(!is_array($hub))
		{
    		$sensors = DB::table('sensors')
            ->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
			->where('sensors.hub_id', $hub)
			->where('sensors.unit', $unit)
			->groupBy('sensors.sensor_id')
    		->select('sensors.*')
    		->get();
		}
		else
		{
    		$sensors = DB::table('sensors')
            ->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
			->whereIn('sensors.hub_id', $hub)
			->where('sensors.unit', $unit)
			->groupBy('sensors.sensor_id')
    		->select('sensors.*')
    		->get();
		}
		echo '<select class="form-control sensor3" id="sensor3" name="sensor[]"  multiple="multiple" >';
		echo "<option value=''>Select</option>";
		foreach($sensors as $item)
		{
		    echo "<option value='".$item->sensor_id."'>".$item->sensor_id."</option>";
		}
		echo "</select>";
	}
	public function getunit(Request $request)
	{
		$hub = $request->input('hub');
		//print_r($hub);die();
		if(!is_array($hub))
		{
    		$sensors = DB::table('sensors')->where('hub_id', $hub)->groupBy('unit')->get();
		}
		else
		{
    		$sensors = DB::table('sensors')->whereIn('hub_id', $hub)->groupBy('unit')->get();
		}
		echo '<select class="form-control unit" id="unit" name="unit">';
		echo "<option value=''>Select</option>";
		foreach($sensors as $item)
		{
		    echo "<option value='".$item->unit."'>".$item->unit."</option>";
		}
		echo "</select>";
	}
	public function getunit2(Request $request)
	{
		$hub = $request->input('hub');
		if(!is_array($hub))
		{
    		$sensors = DB::table('sensors')->where('hub_id', $hub)->groupBy('unit')->get();
		}
		else
		{
    		$sensors = DB::table('sensors')->whereIn('hub_id', $hub)->groupBy('unit')->get();
		}
		echo '<select class="form-control unit2" id="unit2" name="unit">';
		echo "<option value=''>Select</option>";
		foreach($sensors as $item)
		{
		    echo "<option value='".$item->unit."'>".$item->unit."</option>";
		}
		echo "</select>";
	}
	public function getunit3(Request $request)
	{
		$hub = $request->input('hub');
		if(!is_array($hub))
		{
    		$sensors = DB::table('sensors')->where('hub_id', $hub)->groupBy('unit')->get();
		}
		else
		{
    		$sensors = DB::table('sensors')->whereIn('hub_id', $hub)->groupBy('unit')->get();
		}
		echo '<select class="form-control unit3" id="unit3" name="unit">';
		echo "<option value=''>Select</option>";
		foreach($sensors as $item)
		{
		    echo "<option value='".$item->unit."'>".$item->unit."</option>";
		}
		echo "</select>";
	}

public function pushmsgreset(Request $request)
	{

$items = DB::table('algorithm')
						->join('userdatamessages', 'userdatamessages.algorithmid', '=', 'algorithm.id')->join('users', 'users.id', '=', 'userdatamessages.userid')->orderBy('userdatamsgid','desc')	
			->select('users.fname', 'users.lname','userdatamessages.created_at', 'algorithm.push_message', 'algorithm.id as pid','userdatamessages.readflag','userdatamessages.userdatamsgid as udi','userdatamessages.*')->paginate(1000);

			//->get();
		return view('admin.report.pushmsgreset')->with(['messages'=>$items]);






	}	





	public function pushmsg(Request $request)
	{
		$start = date("Y-m-d",strtotime($request->input('from')));
		$end = date("Y-m-d",strtotime($request->input('to')."+1 day"));




		$items = DB::table('algorithm')
			//->join('algorithm_sensor', 'algorithm_sensor.algorithm_id', '=', 'algorithm.id')
			//->join('gateway_groups', 'gateway_groups.id', '=', 'algorithm_sensor.groupid')
			//->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			//->join('sensor_hubs', 'sensor_hubs.id', '=', 'algorithm_sensor.hub')
			//->join('sensors', 'sensors.id', '=', 'algorithm_sensor.sensor')
			->join('userdatamessages', 'userdatamessages.algorithmid', '=', 'algorithm.id')->join('users', 'users.id', '=', 'userdatamessages.userid')->orderBy('userdatamsgid','desc')
			//->join('users', 'users.id', '=', 'algorithm.userid')
			//->whereRaw('algorithm.created_at between "'.$start.'" and "'.$end.'"')

			->whereRaw('userdatamessages.created_at between "'.$start.'" and "'.$end.'"')
			//->select('users.fname', 'users.lname', 'sensor_groups.name', 'sensor_hubs.hub_id', 'sensors.sensor_id', 'userdatamessages.created_at', 'algorithm.push_message', 'algorithm.id as pid','userdatamessages.readflag','userdatamessages.userdatamsgid as udi')->paginate(100);
			->select('users.fname', 'users.lname','userdatamessages.created_at', 'algorithm.push_message', 'algorithm.id as pid','userdatamessages.readflag','userdatamessages.userdatamsgid as udi','userdatamessages.*')->paginate(1000);

			//->get();
		return view('admin.report.pushmsg')->with(['messages'=>$items]);
	}


public function getpushmsg(){
		//echo "hello";
/*$items = DB::table('algorithm')
		->join('algorithm_sensor', 'algorithm_sensor.algorithm_id', '=', 'algorithm.id')
		->join('sensors', 'sensors.id', '=', 'algorithm_sensor.sensor')
		->join('users', 'users.id', '=', 'algorithm.userid')
		//->whereRaw('algorithm.created_at between "'.$start.'" and "'.$end.'"')
		->where('users.id', session()->get('userid'))
		->select('sensors.*','algorithm.created_at', 'algorithm.push_message', 'algorithm.id as pid')
		->get();*/
		$items = DB::table('algorithm')
			//->join('algorithm_sensor', 'algorithm_sensor.algorithm_id', '=', 'algorithm.id')
			//->join('gateway_groups', 'gateway_groups.id', '=', 'algorithm_sensor.groupid')
			//->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			//->join('sensor_hubs', 'sensor_hubs.id', '=', 'algorithm_sensor.hub')
			//->join('sensors', 'sensors.id', '=', 'algorithm_sensor.sensor')
			//->join('users', 'users.id', '=', 'algorithm.userid')->
->join('userdatamessages', 'userdatamessages.algorithmid', '=', 'algorithm.id')->join('users', 'users.id', '=', 'userdatamessages.userid')->orderBy('userdatamsgid','desc')
			//select('users.fname', 'users.lname', 'sensor_groups.name', 'sensor_hubs.hub_id', 'sensors.sensor_id', 'userdatamessages.created_at', 'algorithm.push_message', 'algorithm.id as pid','userdatamessages.readflag','userdatamessages.userdatamsgid as udi')->paginate(100);
->select('users.fname', 'users.lname','userdatamessages.created_at', 'algorithm.push_message', 'algorithm.id as pid','userdatamessages.readflag','userdatamessages.userdatamsgid as udi','userdatamessages.*')->paginate(1000);

			//->get();
			//where('users.id', session()->get('userid'))->
//dd($items);
//dd("hello");
		//return view('agent.report.pushmsg')->with(['messages'=>$items]);

return view('admin.report.pushmsg')->with(['messages'=>$items]);
	}

public function uppushmsgreadflag()
{
	$msgid=$_GET['msgid'];
	if($msgid == 'all')
	{
		$upread = DB::table('userdatamessages')->where('readflag', '0')->update(['readflag'=>1]);
	}
	else
	{
		$upread = DB::table('userdatamessages')->where('userdatamsgid',$msgid)->update(['readflag'=>1]);
	}
	echo "1";
}


public function getdataall()
{
$getdata=DB::table('dbo_payloader')->take(10000)->get();
foreach ($getdata as $gd) {
	
$data=array('id'=>$gd->id,'utc'=>$gd->utc,'hub'=>$gd->hub,'sensor_id'=>$gd->sensor_id,'sensor_type'=>$gd->sensor_type,'value'=>$gd->value,'unit'=>$gd->unit,'time'=>$gd->time,'processedflag'=>$gd->processedflag,'processedflagall'=>$gd->processedflagall);
	$ins=DB::table('dbo_payloaderdemo1')->insert($data);
}

}

public function getdata_sumi()
{
$getdata=DB::table('dbo_payloader')->where('processedflag',0)->take(100)->get();

foreach ($getdata as $gd) {
	
$data=array('id'=>$gd->id,'utc'=>$gd->utc,'hub'=>$gd->hub,'sensor_id'=>$gd->sensor_id,'sensor_type'=>$gd->sensor_type,'value'=>$gd->value,'unit'=>$gd->unit,'time'=>$gd->time,'processedflag'=>$gd->processedflag,'processedflagall'=>$gd->processedflagall);
	$ins=DB::table('dbo_payloaderalgorithmtemp')->insert($data);
}


}



public function getdataandor()
{
$getdata=DB::table('dbo_payloader')->where('processedflagall',0)->take(100)->get();
//dd($getdata);
foreach ($getdata as $gd) {
	
$data=array('id'=>$gd->id,'utc'=>$gd->utc,'hub'=>$gd->hub,'sensor_id'=>$gd->sensor_id,'sensor_type'=>$gd->sensor_type,'value'=>$gd->value,'unit'=>$gd->unit,'time'=>$gd->time,'processedflag'=>$gd->processedflag,'processedflagall'=>$gd->processedflagall);
	$ins=DB::table('dbo_payloaderalgorithmtempandor')->insert($data);

$dbovalue=$gd->id;
$dtup=array('processedflagall'=>1);
$updata=DB::table('dbo_payloader')->where('id',$dbovalue)->update($dtup);

}
echo "success";

}






public function getpushnotmsg()
{
	//$getdata=DB::table('dbo_payloader')->where('sensor_id','ESP')->where('processedflag',0)->take(1)->get();
//$getdata=DB::table('dbo_payloader')->where('sensor_id','ESP')->whereNull('processedflag')->take(1)->get();

//dd($getdata);

//$getdata=DB::table('dbo_payloader')->whereNull('processedflag')->take(1)->get();


	$sensorslist=DB::table('algorithm_sensor')->join('sensors', 'algorithm_sensor.sensor', '=', 'sensors.id')->get();
$slarr=array();
foreach($sensorslist as $sl){
$slarr[]=$sl->sensor_id;
}
//dd($slarr);
//$getdata=DB::table('dbo_payloader')->whereIn('sensor_id',$slarr)->whereNull('processedflag')->take(1)->get();
/*$getdata=DB::table('dbo_payloader')->where('sensor_id','Battery')->whereNull('processedflag')->orwhere('processedflag',0)->take(1)->get();*/

/*$getdata=DB::table('dbo_payloader')->whereIn('sensor_id',$slarr)->where('processedflag',0)->take(1)->get();*/

$getdata=DB::table('dbo_payloaderalgorithmtemp')->whereIn('sensor_id',$slarr)->where('processedflag',0)->take(1)->get();


//$getdata=DB::table('dbo_payloader')->where('sensor_id','Battery')->where('processedflag',0)->take(1)->get();
//dd($getdata);
	foreach ($getdata as $gd) 
	{
		$value=$gd->value;
		$firstval=$value;
		$sensorname=$gd->sensor_id;
		$nondata=DB::table('algorithm')
			->join('algorithm_sensor', 'algorithm_sensor.algorithm_id', '=', 'algorithm.id')
			->where('algorithm.moreconditionflag',0)
			->get();
		foreach ($nondata as $nd) 
		{
			if ($nd->choose==1)
			{
				$minvalue=$nd->min_value;
				$maxvalue=$nd->max_value;
				$algid=$nd->algorithm_id;
				$sensid=$nd->sensor;
				$firstcondor=0;
				$fcondgrp=$nd->groupid;
				$fcondhub=$nd->hub;
				$fcondsens=$nd->sensor;
				$sensdt=DB::table('sensors')->where('id',$sensid)->first();
				$sensornamecond=$sensdt->sensor_id;
				$formula="None-Min,Max";
				//dd($formula,$value,$nd->min_value,$nd->max_value,$sensorname,$sensornamecond);
				if ( ($value >= $nd->min_value) && ($value <= $nd->max_value) && ( $sensorname==$sensornamecond))
				{
					//dd("Min");
					$algdata=DB::table('algorithm')->where('id',$algid)->first();
					$userid=$algdata->userid;
					$data=array('userid'=>$userid,'algorithmid'=>$algid,'payloaderid'=>$gd->id,'sensreading'=>$firstval,'formula'=>$formula,'noofcond'=>1,'firstcondor'=>$firstcondor,'fcondgrp'=>$fcondgrp,'fcondhub'=>$fcondhub,'fcondsens'=>$fcondsens);
					$insertmsg=DB::table('userdatamessages')->insert($data);
				}
			}
			else 
			{
				$sensid=$nd->sensor;
				$sensdt=DB::table('sensors')->where('id',$sensid)->first();
				$sensornamecond=$sensdt->sensor_id;
				$firstcondor=0;
				$fcondgrp=$nd->groupid;
				$fcondhub=$nd->hub;
				$fcondsens=$nd->sensor;

		//if (($nd->condition1values==5) && ($sensorname==$sensornamecond)){
	if (($nd->condition1==1) && ($sensorname==$sensornamecond)) {
	//$getdata=DB::table('dbo_payloader')->where('processedflag',0)->where('value',$nd->value)->get();
//dd("con1");
			if ($value < $nd->value){
			$algid=$nd->algorithm_id;
			$algdata=DB::table('algorithm')->where('id',$algid)->first();
			$userid=$algdata->userid;
			$formula="None-<";
			$data=array('userid'=>$userid,'algorithmid'=>$algid,'payloaderid'=>$gd->id,'sensreading'=>$firstval,'formula'=>$formula,'noofcond'=>1,'firstcondor'=>$firstcondor,'fcondgrp'=>$fcondgrp,'fcondhub'=>$fcondhub,'fcondsens'=>$fcondsens);
	$insertmsg=DB::table('userdatamessages')->insert($data);
	}


		}

	if (($nd->condition1==2) && ($sensorname==$sensornamecond)) {
	//$getdata=DB::table('dbo_payloader')->where('processedflag',0)->where('value',$nd->value)->get();
	$formula="None->";
			if ($value > $nd->value){
			$algid=$nd->algorithm_id;
			$algdata=DB::table('algorithm')->where('id',$algid)->first();
			$userid=$algdata->userid;
			$data=array('userid'=>$userid,'algorithmid'=>$algid,'payloaderid'=>$gd->id,'sensreading'=>$firstval,'formula'=>$formula,'noofcond'=>1,'firstcondor'=>$firstcondor,'fcondgrp'=>$fcondgrp,'fcondhub'=>$fcondhub,'fcondsens'=>$fcondsens,'user_sensor_id'=>$sensid);
	$insertmsg=DB::table('userdatamessages')->insert($data);
	}


		}

	if (($nd->condition1==3) && ($sensorname==$sensornamecond)){
	//$getdata=DB::table('dbo_payloader')->where('processedflag',0)->where('value',$nd->value)->get();
	$formula="None-<=";
			if ($value <= $nd->value){
			$algid=$nd->algorithm_id;
			$algdata=DB::table('algorithm')->where('id',$algid)->first();
			$userid=$algdata->userid;
			$data=array('userid'=>$userid,'algorithmid'=>$algid,'payloaderid'=>$gd->id,'sensreading'=>$firstval,'formula'=>$formula,'noofcond'=>1,'firstcondor'=>$firstcondor,'fcondgrp'=>$fcondgrp,'fcondhub'=>$fcondhub,'fcondsens'=>$fcondsens,'user_sensor_id'=>$sensid);
	$insertmsg=DB::table('userdatamessages')->insert($data);
	}


		}

	if (($nd->condition1==4) && ($sensorname==$sensornamecond)) {
	//$getdata=DB::table('dbo_payloader')->where('processedflag',0)->where('value',$nd->value)->get();
	$formula="None->=";
			if ($value >= $nd->value){
			$algid=$nd->algorithm_id;
			$algdata=DB::table('algorithm')->where('id',$algid)->first();
			$userid=$algdata->userid;
			$data=array('userid'=>$userid,'algorithmid'=>$algid,'payloaderid'=>$gd->id,'sensreading'=>$firstval,'formula'=>$formula,'noofcond'=>1,'firstcondor'=>$firstcondor,'fcondgrp'=>$fcondgrp,'fcondhub'=>$fcondhub,'fcondsens'=>$fcondsens,'user_sensor_id'=>$sensid);
	$insertmsg=DB::table('userdatamessages')->insert($data);
	}


		}




		if (($nd->condition1==5) && ($sensorname==$sensornamecond)) {
	//$getdata=DB::table('dbo_payloader')->where('processedflag',0)->where('value',$nd->value)->get();
	$formula="None-==";
			if ($nd->value==$value){
			$algid=$nd->algorithm_id;
			$algdata=DB::table('algorithm')->where('id',$algid)->first();
			$userid=$algdata->userid;
			$data=array('userid'=>$userid,'algorithmid'=>$algid,'payloaderid'=>$gd->id,'sensreading'=>$firstval,'formula'=>$formula,'noofcond'=>1,'firstcondor'=>$firstcondor,'fcondgrp'=>$fcondgrp,'fcondhub'=>$fcondhub,'fcondsens'=>$fcondsens,'user_sensor_id'=>$sensid);
	$insertmsg=DB::table('userdatamessages')->insert($data);
	}



		}
	}

	}
	$dbovalue=$gd->id;
	$dtup=array('processedflag'=>1);
	
	//$updata=DB::table('dbo_payloaderalgorithmtemp')->where('id',$dbovalue)->delete();


	}
	//$getdatadel=DB::table('dbo_payloaderalgorithmtemp')->whereNotIn('sensor_id',$slarr)->where('processedflag',0)->delete();
	echo "1";
}


public function getpushnotmsgandor(){
//$getdata=DB::table('dbo_payloader')->where('processedflagall',0)->take(1)->get();
	/*$getdata=DB::table('dbo_payloader')->where('processedflagall',0)->where('sensor_id','DL3_Temperature Sensor 1')->take(1)->get();*/
//$getdata=DB::table('dbo_payloader')->where('processedflagall',0)->take(1)->get();
//$getdata=DB::table('dbo_payloader')->whereNull('processedflagall')->take(1)->get();
$sensorslist=DB::table('algorithm_sensor')->join('sensors', 'algorithm_sensor.sensor', '=', 'sensors.id')->get();
$slarr=array();
foreach($sensorslist as $sl){
$slarr[]=$sl->sensor_id;
}
//dd($slarr);
//->whereIn('sensor_id',$slarr)

$getdata=DB::table('dbo_payloaderalgorithmtempandor')->where('processedflagall',0)->take(1)->get();
//$getdata=DB::table('dbo_payloaderalgorithmtempandor')->where('sensor_id','BME280#4')->where('processedflagall',0)->take(1)->get();
//dd($getdata);
foreach ($getdata as $gd) {
	$value=$gd->value;
	$firstval=$gd->value;
	$secondval=$gd->value;
	$thirdval=$gd->value;
	$sensorname=$gd->sensor_id;
	$firstcondor=0;
$fcondgrp=0;
$fcondhub=0;
$fcondsens=0;
$secondcondor=0;
$scondgrp=0;
$scondhub=0;
$scondsens=0;
$tcondgrp=0;
$tcondhub=0;
$tcondsens=0;
$nondata=DB::table('algorithm')->where('moreconditionflag',1)->get();
//sdd($nondata);
foreach ($nondata as $nd) 
{
$allcond=DB::table('algorithm_sensor')->where('algorithm_id',$nd->id)->get();
//dd($allcond);
$algid=$nd->id;
$userid=$nd->userid;
$noofconditions=count($allcond);
$i=0;
if ($noofconditions==2){
	//dd("entered 2");
	$condfirst="";
$opfirst=0;
$opfirstop=0;
$opsecondop=0;
$payval2=0;
$sensornamecondfirst=0;
$sensornamecondsecond=0;
foreach ($allcond as $ac) {
	//dd("hai",$i);
	if ($i==0){
		//dd("hello");
	$condfirst=$ac->condition2;
	$opfirst=$ac->condition1;
	$choosefirst=$ac->choose;
	$minf=$ac->min_value;
	$maxf=$ac->max_value;
$sensid=$ac->sensor;
$firstgroup=$ac->groupid;
$firsthub=$ac->hub;
$firstsensor=$ac->sensor;
//dd($sensid);
	$sensdt=DB::table('sensors')->where('id',$sensid)->first();
	$sensornamecondfirst=$sensdt->sensor_id;


	}
//$condfirst=$condfirst;
if ($i==0){
	$payval1=$ac->value;
if ($opfirst==1){
$opfirstop='<';
}
if ($opfirst==2){
$opfirstop='>';
}
if ($opfirst==3){
$opfirstop='<=';
}

if ($opfirst==4){
$opfirstop='>=';
}
if ($opfirst==5){
$opfirstop='=';
}
}
if ($i==1){
	$payval2=$ac->value;
	$opsecond=$ac->condition1;
	$choosesecond=$ac->choose;
	$mins=$ac->min_value;
	$maxs=$ac->max_value;
$sensid=$ac->sensor;
	$sensdt=DB::table('sensors')->where('id',$sensid)->first();
	$sensornamecondsecond=$sensdt->sensor_id;
$secondgroup=$ac->groupid;
$secondhub=$ac->hub;
$secondsensor=$ac->sensor;


if ($opsecond==1){
$opsecondop='<';
}
if ($opsecond==2){
$opsecondop='>';
}
if ($opsecond==3){
$opsecondop='<=';
}

if ($opsecond==4){
$opsecondop='>=';
}
if ($opsecond==5){
$opsecondop='=';
}
}
$i++;
}

//dd($condfirst,$opfirstop,$opsecondop,$firstval,$secondval,$payval1,$payval2);
if ($condfirst=='Or'){
	//dd("enter or---");

$fflag=0;
$sflag=0;
	if ($choosefirst==0){
$fcond=eval("return \$firstval $opfirstop \$payval1;");
}
else{
if (($firstval >=$minf) && ($firstval <=$maxf)){
$fflag=1;
$fcond=1;
}
}

if ($choosesecond==0){
$scond=eval("return \$secondval $opsecondop \$payval2;");
}
else{
if (($secondval >=$mins) && ($secondval <=$maxs))
$sflag=1;
$scond=1;
}

$firstcondor=0;
$secondcondor=0;
//dd($firstval,$opfirstop,$payval1,$fcond,$sensorname,$sensornamecondfirst);
if ( (($fcond) && ($sensorname==$sensornamecondfirst)) || (($scond) && ($sensorname==$sensornamecondsecond))){

//dd("Firstcondition");
	

		
	if ((($fcond) && ($sensorname==$sensornamecondfirst)))
	{
$firstcondor=1;
$fcondgrp=$firstgroup;
$fcondhub=$firsthub;
$fcondsens=$firstsensor;

		}

		if ((($scond) && ($sensorname==$sensornamecondsecond))){
			//$secondcondor=1;
$secondcondor=1;
$scondgrp=$secondgroup;
$scondhub=$secondhub;
$scondsens=$secondsensor;


		}
		//dd("msg");
		$formula="Or";

		$data=array('userid'=>$userid,'algorithmid'=>$algid,'payloaderid'=>$gd->id,'orflag'=>1,'noofcond'=>2,'firstcondor'=>$firstcondor,'seccondor'=>$secondcondor,'fcondgrp'=>$fcondgrp,'fcondhub'=>$fcondhub,'fcondsens'=>$fcondsens,'scondgrp'=>$scondgrp,'scondhub'=>$scondhub,'scondsens'=>$scondsens,'sensreading'=>$firstval,'formula'=>$formula);
	
$insertmsg=DB::table('userdatamessages')->insert($data);

$dbovalue=$gd->id;
$dtup=array('processedflagall'=>1);
//$updata=DB::table('dbo_payloaderalgorithmtempandor')->where('id',$dbovalue)->update($dtup);



}
}
if ($condfirst=='And'){
//if (eval("return \$firstval $opfirstop \$payval1") && (eval("return \$secondval $opsecondtop \$payval2")) )
//{
//$fcond=eval("return \$firstval $opfirstop \$payval1;");
//$scond=eval("return \$secondval $opsecondop \$payval2;");
$fflag=0;
	$sflag=0;
	if ($choosefirst==0){
$fcond=eval("return \$firstval $opfirstop \$payval1;");
}
else{
if (($firstval >=$minf) && ($firstval <=$maxf)){
$fflag=1;
$fcond=1;
}
}

if ($choosesecond==0){
$scond=eval("return \$secondval $opsecondop \$payval2;");
}
else{
if (($secondval >=$mins) && ($secondval <=$maxs))
$sflag=1;
$scond=1;
}


if ( (($fcond) && ($sensorname==$sensornamecondfirst)) && (($scond) && ($sensorname==$sensornamecondsecond)) ){


$fcondgrp=$firstgroup;
$fcondhub=$firsthub;
$fcondsens=$firstsensor;
$scondgrp=$secondgroup;
$scondhub=$secondhub;
$scondsens=$secondsensor;

$formula="And";
$data=array('userid'=>$userid,'algorithmid'=>$algid,'payloaderid'=>$gd->id,'orflag'=>0,'noofcond'=>2,'firstcondor'=>$firstcondor,'seccondor'=>$secondcondor,'fcondgrp'=>$fcondgrp,'fcondhub'=>$fcondhub,'fcondsens'=>$fcondsens,'scondgrp'=>$scondgrp,'scondhub'=>$scondhub,'scondsens'=>$scondsens,'sensreading'=>$firstval,'formula'=>$formula);

$insertmsg=DB::table('userdatamessages')->insert($data);

$dbovalue=$gd->id;
$dtup=array('processedflagall'=>1);
//$updata=DB::table('dbo_payloaderalgorithmtempandor')->where('id',$dbovalue)->update($dtup);

}
}
//Loop of condition 2

}
//condition 2 end
//condition 3 st

$j=0;
if ($noofconditions==3){
	//dd("entered 3");
	$condfirst="";
$opfirst=0;
$opfirstop=0;
$opsecondop=0;
$payval2=0;
$sensornamecondfirst=0;
$sensornamecondsecond=0;
$sensornamecondthird=0;
foreach ($allcond as $ac) {
	//dd("hai",$i);
	if ($j==0){
		//dd("hello");
	$condfirst=$ac->condition2;
	$opfirst=$ac->condition1;
	$choosefirst=$ac->choose;
	$minf=$ac->min_value;
	$maxf=$ac->max_value;

$sensid=$ac->sensor;
//$sensid=$ac->sensor;
$firstgroup=$ac->groupid;
$firsthub=$ac->hub;
$firstsensor=$ac->sensor;
	$sensdt=DB::table('sensors')->where('id',$sensid)->first();
	$sensornamecondfirst=$sensdt->sensor_id;


	}

if ($j==0){
	$payval1=$ac->value;
if ($opfirst==1){
$opfirstop='<';
}
if ($opfirst==2){
$opfirstop='>';
}
if ($opfirst==3){
$opfirstop='<=';
}

if ($opfirst==4){
$opfirstop='>=';
}
if ($opfirst==5){
$opfirstop='=';
}
}
if ($j==1){
	$payval2=$ac->value;
	$opsecond=$ac->condition1;
	$condsecond=$ac->condition2;
	$choosesecond=$ac->choose;
	$mins=$ac->min_value;
	$maxs=$ac->max_value;
	$secondgroup=$ac->groupid;
$secondhub=$ac->hub;
$secondsensor=$ac->sensor;

$sensid=$ac->sensor;
	$sensdt=DB::table('sensors')->where('id',$sensid)->first();
	$sensornamecondsecond=$sensdt->sensor_id;

if ($opsecond==1){
$opsecondop='<';
}
if ($opsecond==2){
$opsecondop='>';
}
if ($opsecond==3){
$opsecondop='<=';
}

if ($opsecond==4){
$opsecondop='>=';
}
if ($opsecond==5){
$opsecondop='=';
}
}

if ($j==2){
	$payval3=$ac->value;
	$opthird=$ac->condition1;
	$condthird=$ac->condition2;
	$choosethird=$ac->choose;
	$mins=$ac->min_value;
	$maxs=$ac->max_value;
	$sensid=$ac->sensor;
	$thirdgroup=$ac->groupid;
$thirdhub=$ac->hub;
$thirdsensor=$ac->sensor;
	$sensdt=DB::table('sensors')->where('id',$sensid)->first();
	$sensornamecondthird=$sensdt->sensor_id;
if ($opthird==1){
$opthirdop='<';
}
if ($opthird==2){
$opthirdop='>';
}
if ($opthird==3){
$opthirdop='<=';
}

if ($opthird==4){
$opthirdop='>=';
}
if ($opthird==5){
$opthirdop='=';
}
}

$j++;
}
if (($condfirst=='Or') && ($condsecond=='Or') ){
	
$fflag=0;
$sflag=0;
	if ($choosefirst==0){
$fcond=eval("return \$firstval $opfirstop \$payval1;");
}
else{
if (($firstval >=$minf) && ($firstval <=$maxf)){
$fflag=1;
$fcond=1;
}
}
//dd($fcond);
if ($choosesecond==0){
$scond=eval("return \$secondval $opsecondop \$payval2;");
}
else{
if (($secondval >=$mins) && ($secondval <=$maxs))
$sflag=1;
$scond=1;
}


if ($choosethird==0){
$tcond=eval("return \$thirdval $opthirdop \$payval3;");
}
else{
if (($thirdval >=$mins) && ($thirdval <=$maxs))
$tflag=1;
$tcond=1;
}
//dd("$fcond,$sensorname,$sensornamecondfirst,$scond,$sensornamecondsecond,$tcond,$sensornamecondthird");
if ( (($fcond) && ($sensorname==$sensornamecondfirst)) || (($scond) && ($sensorname==$sensornamecondsecond)) || (($tcond) && ($sensorname==$sensornamecondthird)) ){
//dd("me----");
	
$formula="OR-OR";

if ((($fcond) && ($sensorname==$sensornamecondfirst)))
	{
$firstcondor=0;
$fcondgrp=$firstgroup;
$fcondhub=$firsthub;
$fcondsens=$firstsensor;

		}

		if ((($scond) && ($sensorname==$sensornamecondsecond))){
			//$secondcondor=1;
$secondcondor=0;
$scondgrp=$secondgroup;
$scondhub=$secondhub;
$scondsens=$secondsensor;


		}


if ((($tcond) && ($sensorname==$sensornamecondthird))){
			//$secondcondor=1;
$thirdcondor=0;
$tcondgrp=$thirdgroup;
$tcondhub=$thirdhub;
$tcondsens=$thirdsensor;




		}




		$data=array('userid'=>$userid,'algorithmid'=>$algid,'payloaderid'=>$gd->id,'sensreading'=>$firstval,'formula'=>$formula,'fcondgrp'=>$fcondgrp,'fcondhub'=>$fcondhub,'fcondsens'=>$fcondsens,'scondgrp'=>$scondgrp,'scondhub'=>$scondhub,'scondsens'=>$scondsens,'tcondgrp'=>$tcondgrp,'tcondhub'=>$tcondhub,'tcondsens'=>$tcondsens,'noofcond'=>3);
$insertmsg=DB::table('userdatamessages')->insert($data);

$dbovalue=$gd->id;
$dtup=array('processedflagall'=>1);
//$updata=DB::table('dbo_payloaderalgorithmtempandor')->where('id',$dbovalue)->update($dtup);



}
}
if (($condfirst=='And') && ($condsecond=='And'))
{

$fflag=0;
	$sflag=0;
	if ($choosefirst==0){
$fcond=eval("return \$firstval $opfirstop \$payval1;");
}
else{
if (($firstval >=$minf) && ($firstval <=$maxf)){
$fflag=1;
$fcond=1;
}
}

if ($choosesecond==0){
$scond=eval("return \$secondval $opsecondop \$payval2;");
}
else{
if (($secondval >=$mins) && ($secondval <=$maxs))
$sflag=1;
$scond=1;
}


if ($choosethird==0){
$tcond=eval("return \$thirdval $opthirdop \$payval3;");
}
else{
if (($thirdval >=$mins) && ($thirdval <=$maxs))
$tflag=1;
$tcond=1;
}
//dd("and-and");
if ( (($fcond) && ($sensorname==$sensornamecondfirst)) && (($scond) && ($sensorname==$sensornamecondsecond)) && (($tcond) && ($sensorname==$sensornamecondthird)) ){



if ((($fcond) && ($sensorname==$sensornamecondfirst)))
	{
$firstcondor=0;
$fcondgrp=$firstgroup;
$fcondhub=$firsthub;
$fcondsens=$firstsensor;

		}

		if ((($scond) && ($sensorname==$sensornamecondsecond))){
			//$secondcondor=1;
$secondcondor=0;
$scondgrp=$secondgroup;
$scondhub=$secondhub;
$scondsens=$secondsensor;


		}


if ((($tcond) && ($sensorname==$sensornamecondthird))){
			//$secondcondor=1;
$thirdcondor=0;
$tcondgrp=$thirdgroup;
$tcondhub=$thirdhub;
$tcondsens=$thirdsensor;




		}





		$formula="AND-AND";
		$data=array('userid'=>$userid,'algorithmid'=>$algid,'payloaderid'=>$gd->id,'sensreading'=>$firstval,'formula'=>$formula,'fcondgrp'=>$fcondgrp,'fcondhub'=>$fcondhub,'fcondsens'=>$fcondsens,'scondgrp'=>$scondgrp,'scondhub'=>$scondhub,'scondsens'=>$scondsens,'tcondgrp'=>$tcondgrp,'tcondhub'=>$tcondhub,'tcondsens'=>$tcondsens,'noofcond'=>3);
$insertmsg=DB::table('userdatamessages')->insert($data);

$dbovalue=$gd->id;
$dtup=array('processedflagall'=>1);
//$updata=DB::table('dbo_payloaderalgorithmtempandor')->where('id',$dbovalue)->update($dtup);

}

}


if (($condfirst=='Or') && ($condsecond=='And'))
{

$fflag=0;
	$sflag=0;
	if ($choosefirst==0){
$fcond=eval("return \$firstval $opfirstop \$payval1;");
}
else{
if (($firstval >=$minf) && ($firstval <=$maxf)){
$fflag=1;
$fcond=1;
}
}

if ($choosesecond==0){
$scond=eval("return \$secondval $opsecondop \$payval2;");
}
else{
if (($secondval >=$mins) && ($secondval <=$maxs))
$sflag=1;
$scond=1;
}


if ($choosethird==0){
$tcond=eval("return \$thirdval $opthirdop \$payval3;");
}
else{
if (($thirdval >=$mins) && ($thirdval <=$maxs))
$tflag=1;
$tcond=1;
}

if ( (($fcond) && ($sensorname==$sensornamecondfirst)) || (($scond) && ($sensorname==$sensornamecondsecond)) && (($tcond) && ($sensorname==$sensornamecondthird)) ){



		$formula="OR-AND";

if ((($fcond) && ($sensorname==$sensornamecondfirst)))
	{
$firstcondor=0;
$fcondgrp=$firstgroup;
$fcondhub=$firsthub;
$fcondsens=$firstsensor;

		}

		if ((($scond) && ($sensorname==$sensornamecondsecond))){
			//$secondcondor=1;
$secondcondor=0;
$scondgrp=$secondgroup;
$scondhub=$secondhub;
$scondsens=$secondsensor;


		}


if ((($tcond) && ($sensorname==$sensornamecondthird))){
			
$thirdcondor=0;
$tcondgrp=$thirdgroup;
$tcondhub=$thirdhub;
$tcondsens=$thirdsensor;




		}



		$data=array('userid'=>$userid,'algorithmid'=>$algid,'payloaderid'=>$gd->id,'sensreading'=>$firstval,'formula'=>$formula,'fcondgrp'=>$fcondgrp,'fcondhub'=>$fcondhub,'fcondsens'=>$fcondsens,'scondgrp'=>$scondgrp,'scondhub'=>$scondhub,'scondsens'=>$scondsens,'tcondgrp'=>$tcondgrp,'tcondhub'=>$tcondhub,'tcondsens'=>$tcondsens,'noofcond'=>3);
$insertmsg=DB::table('userdatamessages')->insert($data);

$dbovalue=$gd->id;
$dtup=array('processedflagall'=>1);
//$updata=DB::table('dbo_payloaderalgorithmtempandor')->where('id',$dbovalue)->update($dtup);

}

}


if (($condfirst=='And') && ($condsecond=='Or'))
{

$fflag=0;
	$sflag=0;
	if ($choosefirst==0){
$fcond=eval("return \$firstval $opfirstop \$payval1;");
}
else{
if (($firstval >=$minf) && ($firstval <=$maxf)){
$fflag=1;
$fcond=1;
}
}

if ($choosesecond==0){
$scond=eval("return \$secondval $opsecondop \$payval2;");
}
else{
if (($secondval >=$mins) && ($secondval <=$maxs))
$sflag=1;
$scond=1;
}


if ($choosethird==0){
$tcond=eval("return \$thirdval $opthirdop \$payval3;");
}
else{
if (($thirdval >=$mins) && ($thirdval <=$maxs))
$tflag=1;
$tcond=1;
}

if ( (($fcond) && ($sensorname==$sensornamecondfirst)) && (($scond) && ($sensorname==$sensornamecondsecond)) || (($tcond) && ($sensorname==$sensornamecondthird)) ){



if ((($fcond) && ($sensorname==$sensornamecondfirst)))
	{
$firstcondor=0;
$fcondgrp=$firstgroup;
$fcondhub=$firsthub;
$fcondsens=$firstsensor;

		}

		if ((($scond) && ($sensorname==$sensornamecondsecond))){
			//$secondcondor=1;
$secondcondor=0;
$scondgrp=$secondgroup;
$scondhub=$secondhub;
$scondsens=$secondsensor;


		}


if ((($tcond) && ($sensorname==$sensornamecondthird))){
			//$secondcondor=1;
$thirdcondor=0;
$tcondgrp=$thirdgroup;
$tcondhub=$thirdhub;
$tcondsens=$thirdsensor;




		}




		$formula="AND-OR";
		$data=array('userid'=>$userid,'algorithmid'=>$algid,'payloaderid'=>$gd->id,'sensreading'=>$firstval,'formula'=>$formula,'fcondgrp'=>$fcondgrp,'fcondhub'=>$fcondhub,'fcondsens'=>$fcondsens,'scondgrp'=>$scondgrp,'scondhub'=>$scondhub,'scondsens'=>$scondsens,'tcondgrp'=>$tcondgrp,'tcondhub'=>$tcondhub,'tcondsens'=>$tcondsens,'noofcond'=>3);
$insertmsg=DB::table('userdatamessages')->insert($data);

$dbovalue=$gd->id;
$dtup=array('processedflagall'=>1);
//$updata=DB::table('dbo_payloaderalgorithmtempandor')->where('id',$dbovalue)->update($dtup);

}

}

//Loop of condition 3
//3nd phase
}

//Condition 3 st
}
$dbovalue=$gd->id;
$updata=DB::table('dbo_payloaderalgorithmtempandor')->where('id',$dbovalue)->delete();

}

//$getdatadel=DB::table('dbo_payloaderalgorithmtempandor')->whereNotIn('sensor_id',$slarr)->where('processedflagall',0)->delete();
echo "1";
}

public function test(){

/*$agent = $request->input('agent');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$tme = $request->input('tme');*/


		$agent=256;
		$group=34;
		$hub=162;
		$tme='month';
		$start_month = strtotime("-29 day");
				$end_month = strtotime("+1 day");
				$start_month = date("Y-m-d",$start_month);
				$end_month = date("Y-m-d",$end_month);
		$hubs = DB::table('sensor_hubs')->where('id', $hub)->first();
		$hubsname = $hubs->hub_id;
		$arrslist=array('VEML7700');
		//\DB::connection()->enableQueryLog();
		$hubscount = DB::table('sensors')
			->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
			->where('sensor_hubs.hub_id', $hubsname)->whereIn('sensors.sensor_id',$arrslist)
			->groupBy('sensor_id','unit')
			->select('sensors.unit','sensors.sensor_id')
			->get();	
			//$queries = \DB::getQueryLog();
//dd($queries);
		$noofselectedsensors = count($hubscount);
		$arr=array();
		$sensorunit=array();
		$unit = array();
		if($noofselectedsensors == '0')
		{
			$arr['msg'] == '0';
		}
		else
		{
			foreach($hubscount as $hubscounts)
			{
				$unit[] = $hubscounts->unit;
				$sensorunit[]=$hubscounts->sensor_id;

$getchtdt=DB::table('chart')->where('unit',$hubscounts->unit)->first();

$chart[]=$getchtdt->name;

			}


$groups = DB::table('dbo_payloadercharttemphub')
					->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloadercharttemphub.hub')
					->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
					->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloadercharttemphub.sensor_id')
					->join('users', 'sensor_hubs.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('dbo_payloadercharttemphub.time between "'.$start_month.'" and "'.$end_month.'"')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('gateway_groups.id = "'.$group.'"')
					->where('dbo_payloadercharttemphub.hub', $hubsname)->whereIn('sensors.sensor_id',$arrslist)
					->orderBy('dbo_payloadercharttemphub.sensor_id')
					->select('dbo_payloadercharttemphub.*', 'users.fname', 'chart.name')
					->get();




					//$arr=array();
					if(count($groups)>0)
					{
						
							for($h=0;$h<$noofselectedsensors;$h++)
							{

								echo "<br>";
								$i=1;
								foreach($groups as $item)
						{

//if ($h>0){
	echo "$i---H value is---".$h."----";
	echo $sensorunit[$h]."----";
	//if ($item->sensor_id == $sensorunit[1])
	if ($item->sensor_id == $sensorunit[$h])
								{
echo "----".$item->value;
echo "---- ".$item->id;
								}	
								/*if ($item->sensor_id == $sensorunit[$h])
								{

								echo "$item->sensor_id";	
									$arr['value'][$h][] = $item->value;
									echo $item->value;*/
									//$arr['hour'][$h][] = $item->time;
									//$arr['chart'][$h][] = $item->name;
									//$arr['hub'][$h] = $item->hub;
									//$arr['sensor_id'][$h] = $item->sensor_id;
									//$arr['unit'][$h] = $item->unit;
								//}
								echo "<br>";

//}
								$i++;

							}
						}
						//$arr['count'] = $noofselectedsensors;


//print_r($arr);


					}
				}

echo json_encode($arr);


			}
//}














//}







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
