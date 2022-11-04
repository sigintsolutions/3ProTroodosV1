<?php
 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Session;
use Hash;
use Carbon\Carbon;
//use App\Group;
use DB;

class AlgorithmsController extends Controller
{
    public function index()
    {
		//DB::enableQueryLog();
        //abort_unless(\Gate::allows('product_access'), 403);

        //$groups = Group::all();
		
		//$users = DB::select('select * from users inner join role_user on users.id=role_user.user_id where role_user.role_id=1');
		
		$users = DB::table('algorithm')
        //->join('algorithm_sensor', 'algorithm_sensor.algorithm_id', '=', 'algorithm.id')
		->join('users', 'algorithm.userid', '=', 'users.id')
		->select('algorithm.*','users.fname')
        ->paginate(10);
		//dd(DB::getQueryLog());die();
        return view('admin.algorithms.index')->with(['users'=>$users]);
    }
	######Admin##########
	public function addAlgorithm()
	{
		$agents = DB::table('users')
        ->join('role_user', 'role_user.user_id', '=', 'users.id')
		->where('role_user.role_id', 2)
		->get();
		
		$groups = DB::table('sensor_groups')
		->get();
		
		$hubs = DB::table('hubs')
		->get();
		
		$sensors = DB::table('sensors')
		->get();

		return view('admin.algorithms.create')->with(['agents'=>$agents,'groups'=>$groups,'hubs'=>$hubs,'sensors'=>$sensors]);
	}
	public function getGroup(Request $request)
	{
		$agent = $request->input('agent');
		//echo $agent;die();
		$group = $request->input('group');
		$check = $request->input('check');
		DB::enableQueryLog();
		if(!is_array($agent))
		{
			$groups = DB::table('sensor_groups')
			->join('gateway_groups', 'gateway_groups.sensor_group_id', '=', 'sensor_groups.id')
			->where('gateway_groups.agent', $agent)
			->select('sensor_groups.*', 'gateway_groups.id as groupid')
			->get();
		}
		else
		{
			$groups = DB::table('sensor_groups')
			->join('gateway_groups', 'gateway_groups.sensor_group_id', '=', 'sensor_groups.id')
			->whereIn('gateway_groups.agent', $agent)
			->select('sensor_groups.*', 'gateway_groups.id as groupid')
			->get();
		}
		$list='<select class="form-control grpclear " id="group" name="group[]" multiple="multiple" >';
		$list.= "<option value=''>Select</option>";
		foreach($groups as $item)
		{
			if($group==$item->groupid)
			{
				$list.= "<option value='".$item->groupid."' selected>".$item->name."</option>";
			}
			else
			{
				$list.= "<option value='".$item->groupid."'>".$item->name."</option>";
			}
		}
		$list.="</select>";
		return $list;
	}
	public function getGroup2(Request $request)
	{
		$agent = $request->input('agent');
		$group = $request->input('group');
		$check = $request->input('check');
		//DB::enableQueryLog();
		$groups = DB::table('sensor_groups')
        ->join('gateway_groups', 'gateway_groups.sensor_group_id', '=', 'sensor_groups.id')
		->where('gateway_groups.agent', $agent)
		->select('sensor_groups.*', 'gateway_groups.id as groupid')
		->get();
		$list='<select class="form-control " id="group2" name="group">';
		$list.= "<option value=''>Select</option>";
		foreach($groups as $item)
		{
			if($group==$item->groupid)
			{
				$list.= "<option value='".$item->groupid."' selected>".$item->name."</option>";
			}
			else
			{
				$list.= "<option value='".$item->groupid."'>".$item->name."</option>";
			}
		}
		$list.="</select>";
		return $list;
	}
	public function getGroup3(Request $request)
	{
		$agent = $request->input('agent');
		$group = $request->input('group');
		$check = $request->input('check');
		DB::enableQueryLog();
		$groups = DB::table('sensor_groups')
        ->join('gateway_groups', 'gateway_groups.sensor_group_id', '=', 'sensor_groups.id')
		->whereIn('gateway_groups.agent', $agent)
		->select('sensor_groups.*', 'gateway_groups.id as groupid')
		->get();
		$list='<select class="form-control " id="group3" name="group[]" multiple="multiple" >';
		$list.= "<option value=''>Selectrr3</option>";
		foreach($groups as $item)
		{
			if($group==$item->groupid)
			{
				$list.= "<option value='".$item->groupid."' selected>".$item->name."</option>";
			}
			else
			{
				$list.= "<option value='".$item->groupid."'>".$item->name."</option>";
			}
		}
		$list.="</select>";
		return $list;
	}
	public function getChart(Request $request)
	{
		$previous_week = strtotime("-1 week +1 day");
		$start_week = strtotime("last sunday midnight",$previous_week);
		$end_week = strtotime("next saturday",$start_week);
		$start_week = date("Y-m-d",$start_week);
		$end_week = date("Y-m-d",$end_week);	
		$sensor = $request->input('sensor');
		$groups = DB::table('sensors')
        ->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
		->whereRaw('dbo_payloader.sensor_id like "'.$sensor.'"')
		->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')
		->select(array('dbo_payloader.*',\DB::raw("DATE(dbo_payloader.time) as date")))
		->groupBy('date')
		->get();
		$group=array();
		foreach($groups as $item)
		{
			$timestemp = $item->time;;
			$day = Carbon::createFromFormat('Y-m-d H:i:s', $timestemp)->format('l');			
			$days[]=$day;
			if($day=='Sunday')
			{
				$group[$day]=$item->Value;
			}
			else if($day=='Monday')
			{
			$group[$day]=$item->Value;
			}
			else if($day=='Tuesday')
			{
			$group[$day]=$item->Value;
			}
			else if($day=='Wednesday')
			{
			$group[$day]=$item->Value;
			}
			else if($day=='Thursday')
			{
			$group[$day]=$item->Value;
			}
			else if($day=='Friday')
			{
			$group[$day]=$item->Value;
			}
			else if($day=='Saturday')
			{
			$group[$day]=$item->Value;
			}
		}
		$weeks=array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
		foreach($weeks as $d)
		{
		if(array_key_exists(@$d,@$group))
		{
		$arr[]=(int)$group[$d];
		}
		else
		{
		$arr[]=0;
		}
		}
		return json_encode($arr);
	}	
	
	public function getHub(Request $request)
	{
		$group = $request->input('group');
		$agent = $request->input('agent');
		if(!is_array($group))
		{
    		$hubs = DB::table('sensor_hubs')
            ->where('sensor_hubs.group_id', $group)
    		->where('sensor_hubs.agent', $agent)
    		->select('sensor_hubs.*')
    		->get();
		}
		else
		{
    		$hubs = DB::table('sensor_hubs')
            ->whereIn('sensor_hubs.group_id', $group)
    		->where('sensor_hubs.agent', $agent)
    		->select('sensor_hubs.*')
    		->get();
		}
		echo '<select class="form-control hub" id="hub" name="hub[]" multiple="multiple" >';
		echo "<option value=''>Select</option>";
		foreach($hubs as $item)
		{
		    echo "<option value='".$item->id."'>".$item->hub_id."</option>";
		}
		echo "</select>";
	}
	public function getHub2(Request $request)
	{
		$group = $request->input('group');
		$agent = $request->input('agent');
		if(!is_array($group))
		{
    		$hubs = DB::table('sensor_hubs')
            //->join('hubs', 'sensor_hubs.hub_id', '=', 'hubs.id')
    		->where('sensor_hubs.group_id', $group)
    		->where('sensor_hubs.agent', $agent)
    		->select('sensor_hubs.*')
    		->get();
		}
		else
		{
    		$hubs = DB::table('sensor_hubs')
            //->join('hubs', 'sensor_hubs.hub_id', '=', 'hubs.id')
    		->whereIn('sensor_hubs.group_id', $group)
    		->where('sensor_hubs.agent', $agent)
    		->select('sensor_hubs.*')
    		->get();
		}
		//print_r($groups);exit;
		//dd(DB::getQueryLog());
		echo '<select class="form-control " id="hub2" name="hub">';
		echo "<option value=''>Select</option>";
		foreach($hubs as $item)
		{
		    echo "<option value='".$item->id."'>".$item->hub_id."</option>";
		}
		echo "</select>";
	}
	public function getHub3(Request $request)
	{
		$group = $request->input('group');
		$agent = $request->input('agent');
		if(!is_array($group))
		{
    		$hubs = DB::table('sensor_hubs')
            //->join('hubs', 'sensor_hubs.hub_id', '=', 'hubs.id')
    		->where('sensor_hubs.group_id', $group)
    		->where('sensor_hubs.agent', $agent)
    		->select('sensor_hubs.*')
    		->get();
		}
		else
		{
    		$hubs = DB::table('sensor_hubs')
            //->join('hubs', 'sensor_hubs.hub_id', '=', 'hubs.id')
    		->whereIn('sensor_hubs.group_id', $group)
    		->where('sensor_hubs.agent', $agent)
    		->select('sensor_hubs.*')
    		->get();
		}
		//print_r($groups);exit;
		//dd(DB::getQueryLog());
		echo '<select class="form-control " id="hub3" name="hub[]" multiple="multiple" >';
		echo "<option value=''>Select</option>";
		foreach($hubs as $item)
		{
		    echo "<option value='".$item->id."'>".$item->hub_id."</option>";
		}
		echo "</select>";
	}
	public function getSensor(Request $request)
	{
		$hub = $request->input('hub');
		//$agent = $request->input('agent');
		//$group = $request->input('group');
		//$agent = $request->input('agent');
		if(!is_array($hub))
		{
    		$sensors = DB::table('sensors')
            ->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
    		//->where('sensor_hubs.group_id', $group)
    		->where('sensors.hub_id', $hub)
    		//->where('sensor_hubs.agent', $agent)
    		->select('sensors.*')
    		->get();
		}
		else
		{
    		$sensors = DB::table('sensors')
            ->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
    		//->whereIn('sensor_hubs.group_id', $group)
    		->whereIn('sensors.hub_id', $hub)
    		//->where('sensor_hubs.agent', $agent)
    		->select('sensors.*')
    		->get();
		}
		echo '<select class="form-control sensor3" id="sensor3" name="sensor[]"  multiple="multiple" >';
		echo "<option value=''>Select</option>";
		foreach($sensors as $item)
		{
		    echo "<option value='".$item->id."'>".$item->sensor_id."</option>";
		}
		echo "</select>";
	}

	public function getsensortimefetchpageprevhub(Request $request){
		//dd("prev");
$agent = $request->input('agent');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$tme = $request->input('tme');
		//$group = implode(",",$group);
		//$hub = implode(",",$hub);
		//$hubs = DB::table('sensor_hubs')->whereRaw('id in ('.$hub.')')->get();
		$hubs = DB::table('sensor_hubs')->where('id', $hub)->first();		
		// foreach($hubs as $hubname)
		// {
		// 	$hubsname[] = $hubname->hub_id;
		// }
		$hubsname = $hubs->hub_id;

		$currentoffset=$request->input('currentoffsethub');
		
		$pageno=$request->input('pagenohub');
//dd("testlllll");
		if($tme=='week')
		{	
			$start_week = strtotime("-6 day");
			$end_week = strtotime("+1 day");
			$start_week = date("Y-m-d",$start_week);
			$end_week = date("Y-m-d",$end_week);
			/*$items = DB::table('dbo_payloader')
			->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
			->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')
			->whereRaw('users.id = "'.$agent.'"')
			->whereRaw('gateway_groups.id = "'.$group.'"')
			->where('dbo_payloader.hub', $hubsname)
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();*/
$agentsensorsdt=DB::table('sensors')->where('hub_id', $hub)->get();
$agentsensor=array();
foreach($agentsensorsdt as $adt){
$agentsensor[]=$adt->sensor_id;
}
$pageno=$pageno-1;
$currentoffset=($pageno-1)*100;
$skip=$currentoffset;
$items=DB::table('dbo_payloader')->where('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')->whereIn('dbo_payloader.sensor_id', $agentsensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();



$start_month=$start_week;
$end_month=$end_week;












		}
		if($tme =='day')
		{
			/*$items = DB::table('dbo_payloader')
			->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->whereRaw('users.id = "'.$agent.'"')
			->whereRaw('gateway_groups.id = "'.$group.'"')
			->where('dbo_payloader.hub', $hubsname)
			->whereDate('dbo_payloader.time', Carbon::today())
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();*/

$agentsensorsdt=DB::table('sensors')->where('hub_id', $hub)->get();
$agentsensor=array();
foreach($agentsensorsdt as $adt){
$agentsensor[]=$adt->sensor_id;
}
$pageno=$pageno-1;
$currentoffset=($pageno-1)*100;
$skip=$currentoffset;
$items=DB::table('dbo_payloader')->where('dbo_payloader.hub', $hubsname)->whereDate('dbo_payloader.time', Carbon::today())->whereIn('dbo_payloader.sensor_id', $agentsensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();


$start_month=$request->input('from');
$end_month=$request->input('to');







		}
		if($tme =='month')
		{
			$start_month = strtotime("-29 day");
			$end_month = strtotime("+1 day");
			$start_month = date("Y-m-d",$start_month);
			$end_month = date("Y-m-d",$end_month);
			/*$items = DB::table('dbo_payloader')
			->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
			->whereRaw('users.id = "'.$agent.'"')
			->whereRaw('gateway_groups.id = "'.$group.'"')
			->where('dbo_payloader.hub', $hubsname)
			->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();*/
$agentsensorsdt=DB::table('sensors')->where('hub_id', $hub)->get();
$agentsensor=array();
foreach($agentsensorsdt as $adt){
$agentsensor[]=$adt->sensor_id;
}
$pageno=$pageno-1;
$currentoffset=($pageno-1)*100;
$skip=$currentoffset;
$items=DB::table('dbo_payloader')->where('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')->whereIn('dbo_payloader.sensor_id', $agentsensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();

		}
		if($tme=='one')
		{	
			$start = date("Y-m-d",strtotime($request->input('from')));
			$end = date("Y-m-d",strtotime($request->input('to')."+1 day"));
			/*$items = DB::table('dbo_payloader')
			->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
			->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')
			->whereRaw('users.id = "'.$agent.'"')
			->whereRaw('gateway_groups.id = "'.$group.'"')
			->where('dbo_payloader.hub', $hubsname)
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();*/
$agentsensorsdt=DB::table('sensors')->where('hub_id', $hub)->get();
$agentsensor=array();
foreach($agentsensorsdt as $adt){
$agentsensor[]=$adt->sensor_id;
}
$pageno=$pageno-1;
$currentoffset=($pageno-1)*100;
$skip=$currentoffset;
$items=DB::table('dbo_payloader')->where('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')->whereIn('dbo_payloader.sensor_id', $agentsensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();


$start_month=$request->input('from');
$end_month=$request->input('to');





		}
		$unit=0;
		$sensor=0;
		return view('admin.report.pagination_data3')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);



	}


	public function getsensortimefetchpagehub(Request $request){
		//dd("next");
		//dd($request);
$agent = $request->input('agent');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$tme = $request->input('tme');
		//$group = implode(",",$group);
		//$hub = implode(",",$hub);
		//$hubs = DB::table('sensor_hubs')->whereRaw('id in ('.$hub.')')->get();
		$hubs = DB::table('sensor_hubs')->where('id', $hub)->first();		
		// foreach($hubs as $hubname)
		// {
		// 	$hubsname[] = $hubname->hub_id;
		// }
		$hubsname = $hubs->hub_id;
		$currentoffset=$request->input('currentoffsethub');
		
		$pageno=$request->input('pagenohub');
//dd("testlllll");
		if($tme=='week')
		{	
			$start_week = strtotime("-6 day");
			$end_week = strtotime("+1 day");
			$start_week = date("Y-m-d",$start_week);
			$end_week = date("Y-m-d",$end_week);
			/*$items = DB::table('dbo_payloader')
			->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
			->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')
			->whereRaw('users.id = "'.$agent.'"')
			->whereRaw('gateway_groups.id = "'.$group.'"')
			->where('dbo_payloader.hub', $hubsname)
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();*/
$agentsensorsdt=DB::table('sensors')->where('hub_id', $hub)->get();
$agentsensor=array();
foreach($agentsensorsdt as $adt){
$agentsensor[]=$adt->sensor_id;
}


//$currentoffset=$currentoffset+500;
		
$currentoffset=$pageno*100;
$skip=$currentoffset;
//dd($skip,$currentoffset);
//dd($currentoffset,$pageno);
$items=DB::table('dbo_payloader')->where('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')->whereIn('dbo_payloader.sensor_id', $agentsensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();
$pageno=$pageno+1;
$start_month=$start_week;
$end_month=$end_week;















		}
		if($tme =='day')
		{
			/*$items = DB::table('dbo_payloader')
			->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->whereRaw('users.id = "'.$agent.'"')
			->whereRaw('gateway_groups.id = "'.$group.'"')
			->where('dbo_payloader.hub', $hubsname)
			->whereDate('dbo_payloader.time', Carbon::today())
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();*/

$agentsensorsdt=DB::table('sensors')->where('hub_id', $hub)->get();
$agentsensor=array();
foreach($agentsensorsdt as $adt){
$agentsensor[]=$adt->sensor_id;
}
//$currentoffset=$request->input('currentoffset');
		
		//$pageno=$request->input('pageno');
//dd($currentoffset,$pageno);
//$currentoffset=$currentoffset+500;
		
$currentoffset=$pageno*100;
$skip=$currentoffset;
//dd($skip,$currentoffset);
$items=DB::table('dbo_payloader')->where('dbo_payloader.hub', $hubsname)->whereDate('dbo_payloader.time', Carbon::today())->whereIn('dbo_payloader.sensor_id', $agentsensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();


$start_month=$request->input('from');
$end_month=$request->input('to');
$pageno=$pageno+1;






		}
		if($tme =='month')
		{
			$start_month = strtotime("-29 day");
			$end_month = strtotime("+1 day");
			$start_month = date("Y-m-d",$start_month);
			$end_month = date("Y-m-d",$end_month);
			/*$items = DB::table('dbo_payloader')
			->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
			->whereRaw('users.id = "'.$agent.'"')
			->whereRaw('gateway_groups.id = "'.$group.'"')
			->where('dbo_payloader.hub', $hubsname)
			->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();*/
$agentsensorsdt=DB::table('sensors')->where('hub_id', $hub)->get();
$agentsensor=array();
foreach($agentsensorsdt as $adt){
$agentsensor[]=$adt->sensor_id;
}
//$currentoffset=$request->input('currentoffset');
		
		//$pageno=$request->input('pageno');

//$currentoffset=$currentoffset+500;
		
$currentoffset=$pageno*100;
$skip=$currentoffset;
$items=DB::table('dbo_payloader')->where('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')->whereIn('dbo_payloader.sensor_id', $agentsensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();

$pageno=$pageno+1;











		}
		if($tme=='one')
		{	
			$start = date("Y-m-d",strtotime($request->input('from')));
			$end = date("Y-m-d",strtotime($request->input('to')."+1 day"));
			/*$items = DB::table('dbo_payloader')
			->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
			->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')
			->whereRaw('users.id = "'.$agent.'"')
			->whereRaw('gateway_groups.id = "'.$group.'"')
			->where('dbo_payloader.hub', $hubsname)
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();*/
$agentsensorsdt=DB::table('sensors')->where('hub_id', $hub)->get();
$agentsensor=array();
foreach($agentsensorsdt as $adt){
$agentsensor[]=$adt->sensor_id;
}
//$currentoffset=$request->input('currentoffset');
		
		//$pageno=$request->input('pageno');

//$currentoffset=$currentoffset+500;
		
$currentoffset=$pageno*100;
$skip=$currentoffset;

$items=DB::table('dbo_payloader')->where('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')->whereIn('dbo_payloader.sensor_id', $agentsensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();
$pageno=$pageno+1;


$start_month=$request->input('from');
$end_month=$request->input('to');





		}
		$unit=0;
		$sensor=0;
		//dd($currentoffset,$pageno);
		return view('admin.report.pagination_data3')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);








	}
	public function getSensordata(Request $request)
	{
		error_reporting(0);
		//echo "test";die();
		// $hub = $request->input('hub');
		// $agent = $request->input('agent');
		// $group = $request->input('group');
		// $group = implode(",",$group);
		// $hub = implode(",",$hub);
		// $agent = implode(",", $agent);
		// $sensors = DB::table('sensors')	
		// ->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
		// ->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
		// ->join('users', 'sensor_hubs.agent', '=', 'users.id')
		// ->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
		// ->whereRaw('gateway_groups.id in ('.$group.')')
		// ->whereRaw('sensor_hubs.id in ('.$hub.')')
		// ->whereRaw('sensor_hubs.agent in ('.$agent.')')
		// //->where('sensor_hubs.agent', $agent)
		// //->groupBy('dbo_payloader.sensor_id')
		// ->orderBy('dbo_payloader.time', 'ASC')
		// ->select('sensors.id as sid', 'dbo_payloader.*')
		// ->get();
		// //print_r($sensors);
		// return view('admin.algorithms.sensordata')->with(['sensors'=>$sensors]);
		// $agent = $request->input('agent');
		// $group = $request->input('group');
		// $hub = $request->input('hub');
		// $agent = implode(",",$agent);
		// $group = implode(",",$group);
		// $hub = implode(",",$hub);
		// $unit = $request->input('unit');
		// $groups = DB::table('sensors')
		// ->join('sensor_hubs', 'sensors.hub_id', '=', 'sensor_hubs.id')
		// ->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
		// ->join('users', 'sensor_hubs.agent', '=', 'users.id')
		// ->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
		// ->join('chart', 'chart.unit', '=', 'sensors.unit')
		// ->whereRaw('users.id in ('.$agent.')')
		// ->whereRaw('gateway_groups.id in ('.$group.')')
		// ->whereRaw('sensor_hubs.id in ('.$hub.')')
		// ->where('dbo_payloader.unit', $unit)
		// ->select(array('dbo_payloader.*', 'chart.name as chartnam', \DB::raw("DATE(dbo_payloader.time) as date")))
		// ->get();
		// $group=array();
		// $arr=array();
		// foreach($groups as $item)
		// {
		// 	// $timestemp = $item->time;
		// 	// $day = Carbon::createFromFormat('Y-m-d H:i:s', $timestemp)->format('l');
		// 	$arr['hour'][]  = date('d-m-Y', strtotime($item->time));
		// 	$arr['value'][] = (float)$item->value;
		// 	$arr['chart'][0] = $item->chartnam;	
		// }	
		// return json_encode($arr);
		$agent = $request->input('agent');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$tme = $request->input('tme');
		//$group = implode(",",$group);
		//$hub = implode(",",$hub);
		//$hubs = DB::table('sensor_hubs')->whereRaw('id in ('.$hub.')')->get();
		$hubs = DB::table('sensor_hubs')->where('id', $hub)->first();		
		// foreach($hubs as $hubname)
		// {
		// 	$hubsname[] = $hubname->hub_id;
		// }
		$hubsname = $hubs->hub_id;
//dd("testlllll");
		if($tme=='week')
		{	
			$start_week = strtotime("-6 day");
			$end_week = strtotime("+1 day");
			$start_week = date("Y-m-d",$start_week);
			$end_week = date("Y-m-d",$end_week);
			/*$items = DB::table('dbo_payloader')
			->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
			->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')
			->whereRaw('users.id = "'.$agent.'"')
			->whereRaw('gateway_groups.id = "'.$group.'"')
			->where('dbo_payloader.hub', $hubsname)
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();*/
$agentsensorsdt=DB::table('sensors')->where('hub_id', $hub)->get();
$agentsensor=array();
foreach($agentsensorsdt as $adt){
$agentsensor[]=$adt->sensor_id;
}

$items=DB::table('dbo_payloader')->where('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')->whereIn('dbo_payloader.sensor_id', $agentsensor)->orderby('dbo_payloader.id','desc')->skip(0)->take(100)->get();
$skip1=0;
$limit1=100;
$arrids[]=array();
$nooftimes=1;
$i=0;
$currentoffset=0;
$pageno=1;


$start_month=$start_week;
$end_month=$end_week;












		}
		if($tme =='day')
		{
			/*$items = DB::table('dbo_payloader')
			->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->whereRaw('users.id = "'.$agent.'"')
			->whereRaw('gateway_groups.id = "'.$group.'"')
			->where('dbo_payloader.hub', $hubsname)
			->whereDate('dbo_payloader.time', Carbon::today())
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();*/

$agentsensorsdt=DB::table('sensors')->where('hub_id', $hub)->get();
$agentsensor=array();
foreach($agentsensorsdt as $adt){
$agentsensor[]=$adt->sensor_id;
}

$items=DB::table('dbo_payloader')->where('dbo_payloader.hub', $hubsname)->whereDate('dbo_payloader.time', Carbon::today())->whereIn('dbo_payloader.sensor_id', $agentsensor)->orderby('dbo_payloader.id','desc')->skip(0)->take(100)->get();
$skip1=0;
$limit1=100;
$arrids[]=array();
$nooftimes=1;
$i=0;
$currentoffset=0;
$pageno=1;

$start_month=$request->input('from');
$end_month=$request->input('to');







		}
		if($tme =='month')
		{
			$start_month = strtotime("-29 day");
			$end_month = strtotime("+1 day");
			$start_month = date("Y-m-d",$start_month);
			$end_month = date("Y-m-d",$end_month);
			/*$items = DB::table('dbo_payloader')
			->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
			->whereRaw('users.id = "'.$agent.'"')
			->whereRaw('gateway_groups.id = "'.$group.'"')
			->where('dbo_payloader.hub', $hubsname)
			->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();*/
$agentsensorsdt=DB::table('sensors')->where('hub_id', $hub)->get();
$agentsensor=array();
foreach($agentsensorsdt as $adt){
$agentsensor[]=$adt->sensor_id;
}

$items=DB::table('dbo_payloader')->where('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')->whereIn('dbo_payloader.sensor_id', $agentsensor)->orderby('dbo_payloader.id','desc')->skip(0)->take(100)->get();
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
			/*$items = DB::table('dbo_payloader')
			->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
			->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')
			->whereRaw('users.id = "'.$agent.'"')
			->whereRaw('gateway_groups.id = "'.$group.'"')
			->where('dbo_payloader.hub', $hubsname)
			->orderBy('dbo_payloader.sensor_id')
			->select('dbo_payloader.*', 'users.fname', 'sensor_groups.name')
			->get();*/
$agentsensorsdt=DB::table('sensors')->where('hub_id', $hub)->get();
$agentsensor=array();
foreach($agentsensorsdt as $adt){
$agentsensor[]=$adt->sensor_id;
}

$items=DB::table('dbo_payloader')->where('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')->whereIn('dbo_payloader.sensor_id', $agentsensor)->orderby('dbo_payloader.id','desc')->skip(0)->take(100)->get();
$skip1=0;
$limit1=100;
$arrids[]=array();
$nooftimes=1;
$i=0;
$currentoffset=0;
$pageno=1;

$start_month=$request->input('from');
$end_month=$request->input('to');





		}
		$unit=0;
		$sensor=0;
		return view('admin.report.pagination_data3')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);
	}
	public function getSensordatachart_30_7_2020_san(Request $request)
	{
		$agent = $request->input('agent');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$tme = $request->input('tme');
		$hubs = DB::table('sensor_hubs')->where('id', $hub)->first();
		$hubsname = $hubs->hub_id;
		$hubscount = DB::table('sensors')
			->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
			->where('sensor_hubs.hub_id', $hubsname)
			->groupBy('unit')
			->select('sensors.unit')
			->get();	
		$noofselectedsensors = count($hubscount);
		if($noofselectedsensors == '0')
		{
			$arr['msg'] == '0';
		}
		else
		{
			foreach($hubscount as $hubscounts)
			{
				$unit[] = $hubscounts->unit;
			}
			if($tme=='week')
			{	
				$start_week = strtotime("-6 day");
				$end_week = strtotime("+1 day");
				$start_week = date("Y-m-d",$start_week);
				$end_week = date("Y-m-d",$end_week);
				foreach($unit as $units)
				{
					$groups = DB::table('dbo_payloader')
					->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
					->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
					->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
					->join('users', 'sensor_hubs.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('gateway_groups.id = "'.$group.'"')
					->where('dbo_payloader.hub', $hubsname)
					->orderBy('dbo_payloader.sensor_id')
					->select('dbo_payloader.*', 'users.fname', 'chart.name')
					->get();
					$arr=array();
					if(count($groups)>0)
					{
						foreach($groups as $item)
						{
							for($h=0;$h<$noofselectedsensors;$h++)
							{
								if ($item->unit == $unit[$h])
								{
									$arr['value'][$h][] = $item->value;
									$arr['hour'][$h][] = $item->time;
									$arr['chart'][$h][] = $item->name;
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
			if($tme =='day')
			{
				foreach($unit as $units)
				{
					$groups = DB::table('dbo_payloader')
					->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
					->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
					->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
					->join('users', 'sensor_hubs.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('gateway_groups.id = "'.$group.'"')
					->where('dbo_payloader.hub', $hubsname)
					->whereDate('dbo_payloader.time', Carbon::today())
					->orderBy('dbo_payloader.sensor_id')
					->select('dbo_payloader.*', 'users.fname', 'chart.name')
					->get();
					$arr=array();
					if(count($groups)>0)
					{
						foreach($groups as $item)
						{
							for($h=0;$h<$noofselectedsensors;$h++)
							{
								if ($item->unit == $unit[$h])
								{
									$arr['value'][$h][] = $item->value;
									$arr['hour'][$h][] = $item->time;
									$arr['chart'][$h][] = $item->name;
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
			if($tme =='month')
			{
				
				foreach($unit as $units)
				{
					$start_month = strtotime("-29 day");
					$end_month = strtotime("+1 day");
					$start_month = date("Y-m-d",$start_month);
					$end_month = date("Y-m-d",$end_month);
//\DB::connection()->enableQueryLog();

					$groups = DB::table('dbo_payloader')
					->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
					->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
					->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
					->join('users', 'sensor_hubs.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('gateway_groups.id = "'.$group.'"')
					->where('dbo_payloader.hub', $hubsname)
					//->whereMonth('dbo_payloader.time', '=', Carbon::now()->subMonth()->month)
					->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')
					->orderBy('dbo_payloader.sensor_id')
					->select('dbo_payloader.*', 'users.fname', 'chart.name')
					->get();


//$queries = \DB::getQueryLog();
//dd($queries);

					$arr=array();
					if(count($groups)>0)
					{
						foreach($groups as $item)
						{
							for($h=0;$h<$noofselectedsensors;$h++)
							{
								if ($item->unit == $unit[$h])
								{
									$arr['value'][$h][] = $item->value;
									$arr['hour'][$h][] = $item->time;
									$arr['chart'][$h][] = $item->name;
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
				foreach($unit as $units)
				{	
					$start = date("Y-m-d",strtotime($request->input('from')));
					$end = date("Y-m-d",strtotime($request->input('to')."+1 day"));
					$groups = DB::table('dbo_payloader')
					->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
					->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
					->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
					->join('users', 'sensor_hubs.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('gateway_groups.id = "'.$group.'"')
					->where('dbo_payloader.hub', $hubsname)
					->orderBy('dbo_payloader.sensor_id')
					->select('dbo_payloader.*', 'users.fname', 'chart.name')
					->get();
					$arr=array();
					if(count($groups)>0)
					{
						foreach($groups as $item)
						{
							for($h=0;$h<$noofselectedsensors;$h++)
							{
								if ($item->unit == $unit[$h])
								{
									$arr['value'][$h][] = $item->value;
									$arr['hour'][$h][] = $item->time;
									$arr['chart'][$h][] = $item->name;
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
		}
		
		return json_encode($arr);
	}



public function getSensordatachart(Request $request)
	{
		$agent = $request->input('agent');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$tme = $request->input('tme');
		$hubs = DB::table('sensor_hubs')->where('id', $hub)->first();
		$hubsname = $hubs->hub_id;
		//\DB::connection()->enableQueryLog();
		$arrslist=array('Battery');
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
			//dd($sensorunit);
			if($tme=='week')
			{	
				$start_week = strtotime("-6 day");
				$end_week = strtotime("+1 day");
				$start_week = date("Y-m-d",$start_week);
				$end_week = date("Y-m-d",$end_week);
				foreach($unit as $units)
				{
					/*$groups = DB::table('dbo_payloadercharttemphub')
					->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
					->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
					->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloadercharttemphub.sensor_id')
					->join('users', 'sensor_hubs.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('dbo_payloadercharttemphub.time between "'.$start_week.'" and "'.$end_week.'"')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('gateway_groups.id = "'.$group.'"')
					->where('dbo_payloadercharttemphub.hub', $hubsname)
					->orderBy('dbo_payloadercharttemphub.sensor_id')
					->select('dbo_payloadercharttemphub.*', 'users.fname', 'chart.name')
					->get();*/
//\DB::connection()->enableQueryLog();
/*$groups = DB::table('dbo_payloadercharttemphub')		
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloadercharttemphub.sensor_id')
					->join('users', 'sensors.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('sensors.group_id = "'.$group.'"')
					
					->where('dbo_payloadercharttemphub.hub', $hubsname)
					->whereRaw('dbo_payloadercharttemphub.time between "'.$start_week.'" and "'.$end_week.'"')
					->orderBy('dbo_payloadercharttemphub.sensor_id')
					->select('dbo_payloadercharttemphub.*', 'users.fname', 'chart.name')
					->get();*/

//$queries = \DB::getQueryLog();
//dd($queries);


$groups = DB::table('dbo_payloader')
					->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
					->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
					->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
					->join('users', 'sensor_hubs.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('gateway_groups.id = "'.$group.'"')
					->where('dbo_payloader.hub', $hubsname)
					->orderBy('dbo_payloader.sensor_id')
					->select('dbo_payloader.*', 'users.fname', 'chart.name')
					->get();




					//$arr=array();
					if(count($groups)>0)
					{
						foreach($groups as $item)
						{
							for($h=0;$h<$noofselectedsensors;$h++)
							{
								if ($item->unit == $unit[$h])
								{
									$arr['value'][$h][] = $item->value;
									$arr['hour'][$h][] = $item->time;
									$arr['chart'][$h][] = $item->name;
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
			if($tme =='day')
			{
				foreach($unit as $units)
				{
					/*$groups = DB::table('dbo_payloadercharttemphub')
					->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
					->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
					->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
					->join('users', 'sensor_hubs.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('gateway_groups.id = "'.$group.'"')
					->where('dbo_payloadercharttemphub.hub', $hubsname)
					->whereDate('dbo_payloadercharttemphub.time', Carbon::today())
					->orderBy('dbo_payloadercharttemphub.sensor_id')
					->select('dbo_payloadercharttemphub.*', 'users.fname', 'chart.name')
					->get();*/

/*$groups = DB::table('dbo_payloadercharttemphub')		
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloadercharttemphub.sensor_id')
					->join('users', 'sensors.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('sensors.group_id = "'.$group.'"')
					
					->where('dbo_payloadercharttemphub.hub', $hubsname)
					->whereDate('dbo_payloadercharttemphub.time', Carbon::today())
					->orderBy('dbo_payloadercharttemphub.sensor_id')
					->select('dbo_payloadercharttemphub.*', 'users.fname', 'chart.name')
					->get();*/

$groups = DB::table('dbo_payloader')
					->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
					->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
					->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
					->join('users', 'sensor_hubs.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('gateway_groups.id = "'.$group.'"')
					->where('dbo_payloader.hub', $hubsname)
					->whereDate('dbo_payloader.time', Carbon::today())
					->orderBy('dbo_payloader.sensor_id')
					->select('dbo_payloader.*', 'users.fname', 'chart.name')
					->get();



					//$arr=array();
					if(count($groups)>0)
					{
						foreach($groups as $item)
						{
							for($h=0;$h<$noofselectedsensors;$h++)
							{
								if ($item->unit == $unit[$h])
								{
									$arr['value'][$h][] = $item->value;
									$arr['hour'][$h][] = $item->time;
									$arr['chart'][$h][] = $item->name;
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
			if($tme =='month')
			{
				$start_month = strtotime("-29 day");
				$end_month = strtotime("+1 day");
				$start_month = date("Y-m-d",$start_month);
				$end_month = date("Y-m-d",$end_month);

				/*$groups = DB::table('dbo_payloader')
				->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
				->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
				->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
				->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
				->join('users', 'sensor_hubs.agent', '=', 'users.id')
				->join('chart', 'chart.unit', '=', 'sensors.unit')
				->whereRaw('users.id = "'.$agent.'"')
				->whereRaw('gateway_groups.id = "'.$group.'"')
				->where('dbo_payloader.hub', $hubsname)				
				->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')
				->orderBy('dbo_payloader.sensor_id')
				->select('dbo_payloader.*', 'users.fname', 'chart.name')
				->get();*/	
				//dd($unit);
				$groups = DB::table('dbo_payloadercharttemphub')
				->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloadercharttemphub.hub')
				->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
				->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
				->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloadercharttemphub.sensor_id')
				->join('users', 'sensor_hubs.agent', '=', 'users.id')
				->join('chart', 'chart.unit', '=', 'sensors.unit')
				->whereRaw('users.id = "'.$agent.'"')
				->whereRaw('gateway_groups.id = "'.$group.'"')
				->where('dbo_payloadercharttemphub.hub', $hubsname)->whereIn('sensors.sensor_id',$arrslist)		
				->whereRaw('dbo_payloadercharttemphub.time between "'.$start_month.'" and "'.$end_month.'"')
				->orderBy('dbo_payloadercharttemphub.sensor_id')
				->select('dbo_payloadercharttemphub.*', 'users.fname', 'chart.name')
				->get();
				if(count($groups)>0)
				{													
					//for($h=0;$h<$noofselectedsensors;$h++)
					//{
						//$k=0;
						$j=0;$h=0;						
						foreach($groups as $item)
						{
							//echo $item->value;	
							//if($sensorunit[$h] == $item->sensor_id)
							//{
								//echo $item->value;
								$arr['value'][$h][] = $item->value;
								$arr['hour'][$h][] = $item->time;
								$arr['chart'][$h][] = $item->name;	
								$arr['hub'][$h] = $item->hub;									
								$arr['sensor_id'][$h] = $sensorunit[$h];
								$arr['unit'][$h] = $item->unit;																
							//}							
							$j++;
						//}
						//die();
					}
					$arr['count'] = $noofselectedsensors;			
				}
			}
			if($tme=='one')
			{
				foreach($unit as $units)
				{	
					$start = date("Y-m-d",strtotime($request->input('from')));
					$end = date("Y-m-d",strtotime($request->input('to')."+1 day"));
					$actend=date("Y-m-d",strtotime($request->input('to')));

/*$curdate=date('Y-m-d');
$prevdate = date("Y-m-d", strtotime("-1 months"));
if ( (strtotime($start) < strtotime($prevdate)) || (strtotime($actend) < strtotime($prevdate))  ){
	
$groups = DB::table('dbo_payloadercharttemphub')
					->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
					->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
					->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
					->join('users', 'sensor_hubs.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('dbo_payloadercharttemphub.time between "'.$start.'" and "'.$end.'"')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('gateway_groups.id = "'.$group.'"')
					->where('dbo_payloadercharttemphub.hub', $hubsname)
					->orderBy('dbo_payloadercharttemphub.sensor_id')
					->select('dbo_payloadercharttemphub.*', 'users.fname', 'chart.name')
					->get();








}
else{

					

$groups = DB::table('dbo_payloadercharttemphub')		
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloadercharttemphub.sensor_id')
					->join('users', 'sensors.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('sensors.group_id = "'.$group.'"')
					
					->where('dbo_payloadercharttemphub.hub', $hubsname)
					->whereRaw('dbo_payloadercharttemphub.time between "'.$start.'" and "'.$end.'"')
					->orderBy('dbo_payloadercharttemphub.sensor_id')
					->select('dbo_payloadercharttemphub.*', 'users.fname', 'chart.name')
					->get();

}*/
$groups = DB::table('dbo_payloader')
					->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
					->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
					->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
					->join('users', 'sensor_hubs.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('gateway_groups.id = "'.$group.'"')
					->where('dbo_payloader.hub', $hubsname)
					->orderBy('dbo_payloader.sensor_id')
					->select('dbo_payloader.*', 'users.fname', 'chart.name')
					->get();




					//$arr=array();
					if(count($groups)>0)
					{
						foreach($groups as $item)
						{
							for($h=0;$h<$noofselectedsensors;$h++)
							{
								if ($item->unit == $unit[$h])
								{
									$arr['value'][$h][] = $item->value;
									$arr['hour'][$h][] = $item->time;
									$arr['chart'][$h][] = $item->name;
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
		}
		
		return json_encode($arr);
	}


function getsensordatachartnextsens(Request $request){

$agent = $request->input('agent');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$tme = $request->input('tme');
		$hubs = DB::table('sensor_hubs')->where('id', $hub)->first();
		$hubsname = $hubs->hub_id;
		//\DB::connection()->enableQueryLog();
		$arrslist=array('ESP FW version');
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
			//dd($sensorunit);
			if($tme=='week')
			{	
				$start_week = strtotime("-6 day");
				$end_week = strtotime("+1 day");
				$start_week = date("Y-m-d",$start_week);
				$end_week = date("Y-m-d",$end_week);
				foreach($unit as $units)
				{
					/*$groups = DB::table('dbo_payloadercharttemphub')
					->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
					->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
					->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloadercharttemphub.sensor_id')
					->join('users', 'sensor_hubs.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('dbo_payloadercharttemphub.time between "'.$start_week.'" and "'.$end_week.'"')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('gateway_groups.id = "'.$group.'"')
					->where('dbo_payloadercharttemphub.hub', $hubsname)
					->orderBy('dbo_payloadercharttemphub.sensor_id')
					->select('dbo_payloadercharttemphub.*', 'users.fname', 'chart.name')
					->get();*/
//\DB::connection()->enableQueryLog();
/*$groups = DB::table('dbo_payloadercharttemphub')		
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloadercharttemphub.sensor_id')
					->join('users', 'sensors.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('sensors.group_id = "'.$group.'"')
					
					->where('dbo_payloadercharttemphub.hub', $hubsname)
					->whereRaw('dbo_payloadercharttemphub.time between "'.$start_week.'" and "'.$end_week.'"')
					->orderBy('dbo_payloadercharttemphub.sensor_id')
					->select('dbo_payloadercharttemphub.*', 'users.fname', 'chart.name')
					->get();*/

//$queries = \DB::getQueryLog();
//dd($queries);


$groups = DB::table('dbo_payloader')
					->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
					->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
					->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
					->join('users', 'sensor_hubs.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('gateway_groups.id = "'.$group.'"')
					->where('dbo_payloader.hub', $hubsname)
					->orderBy('dbo_payloader.sensor_id')
					->select('dbo_payloader.*', 'users.fname', 'chart.name')
					->get();




					//$arr=array();
					if(count($groups)>0)
					{
						foreach($groups as $item)
						{
							for($h=0;$h<$noofselectedsensors;$h++)
							{
								if ($item->unit == $unit[$h])
								{
									$arr['value'][$h][] = $item->value;
									$arr['hour'][$h][] = $item->time;
									$arr['chart'][$h][] = $item->name;
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
			if($tme =='day')
			{
				foreach($unit as $units)
				{
					/*$groups = DB::table('dbo_payloadercharttemphub')
					->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
					->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
					->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
					->join('users', 'sensor_hubs.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('gateway_groups.id = "'.$group.'"')
					->where('dbo_payloadercharttemphub.hub', $hubsname)
					->whereDate('dbo_payloadercharttemphub.time', Carbon::today())
					->orderBy('dbo_payloadercharttemphub.sensor_id')
					->select('dbo_payloadercharttemphub.*', 'users.fname', 'chart.name')
					->get();*/

/*$groups = DB::table('dbo_payloadercharttemphub')		
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloadercharttemphub.sensor_id')
					->join('users', 'sensors.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('sensors.group_id = "'.$group.'"')
					
					->where('dbo_payloadercharttemphub.hub', $hubsname)
					->whereDate('dbo_payloadercharttemphub.time', Carbon::today())
					->orderBy('dbo_payloadercharttemphub.sensor_id')
					->select('dbo_payloadercharttemphub.*', 'users.fname', 'chart.name')
					->get();*/

$groups = DB::table('dbo_payloader')
					->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
					->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
					->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
					->join('users', 'sensor_hubs.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('gateway_groups.id = "'.$group.'"')
					->where('dbo_payloader.hub', $hubsname)
					->whereDate('dbo_payloader.time', Carbon::today())
					->orderBy('dbo_payloader.sensor_id')
					->select('dbo_payloader.*', 'users.fname', 'chart.name')
					->get();



					//$arr=array();
					if(count($groups)>0)
					{
						foreach($groups as $item)
						{
							for($h=0;$h<$noofselectedsensors;$h++)
							{
								if ($item->unit == $unit[$h])
								{
									$arr['value'][$h][] = $item->value;
									$arr['hour'][$h][] = $item->time;
									$arr['chart'][$h][] = $item->name;
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
			if($tme =='month')
			{
				$start_month = strtotime("-29 day");
				$end_month = strtotime("+1 day");
				$start_month = date("Y-m-d",$start_month);
				$end_month = date("Y-m-d",$end_month);

				/*$groups = DB::table('dbo_payloader')
				->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
				->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
				->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
				->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
				->join('users', 'sensor_hubs.agent', '=', 'users.id')
				->join('chart', 'chart.unit', '=', 'sensors.unit')
				->whereRaw('users.id = "'.$agent.'"')
				->whereRaw('gateway_groups.id = "'.$group.'"')
				->where('dbo_payloader.hub', $hubsname)				
				->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')
				->orderBy('dbo_payloader.sensor_id')
				->select('dbo_payloader.*', 'users.fname', 'chart.name')
				->get();*/	
				//dd($unit);
				$groups = DB::table('dbo_payloadercharttemphub')
				->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloadercharttemphub.hub')
				->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
				->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
				->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloadercharttemphub.sensor_id')
				->join('users', 'sensor_hubs.agent', '=', 'users.id')
				->join('chart', 'chart.unit', '=', 'sensors.unit')
				->whereRaw('users.id = "'.$agent.'"')
				->whereRaw('gateway_groups.id = "'.$group.'"')
				->where('dbo_payloadercharttemphub.hub', $hubsname)->whereIn('sensors.sensor_id',$arrslist)		
				->whereRaw('dbo_payloadercharttemphub.time between "'.$start_month.'" and "'.$end_month.'"')
				->orderBy('dbo_payloadercharttemphub.sensor_id')
				->select('dbo_payloadercharttemphub.*', 'users.fname', 'chart.name')
				->get();
				if(count($groups)>0)
				{													
					//for($h=0;$h<$noofselectedsensors;$h++)
					//{
						//$k=0;
						$j=0;$h=0;						
						foreach($groups as $item)
						{
							//echo $item->value;	
							//if($sensorunit[$h] == $item->sensor_id)
							//{
								//echo $item->value;
								$arr['value'][$h][] = $item->value;
								$arr['hour'][$h][] = $item->time;
								$arr['chart'][$h][] = $item->name;	
								$arr['hub'][$h] = $item->hub;									
								$arr['sensor_id'][$h] = $sensorunit[$h];
								$arr['unit'][$h] = $item->unit;																
							//}							
							$j++;
						//}
						//die();
					}
					$arr['count'] = $noofselectedsensors;			
				}
			}
			if($tme=='one')
			{
				foreach($unit as $units)
				{	
					$start = date("Y-m-d",strtotime($request->input('from')));
					$end = date("Y-m-d",strtotime($request->input('to')."+1 day"));
					$actend=date("Y-m-d",strtotime($request->input('to')));

/*$curdate=date('Y-m-d');
$prevdate = date("Y-m-d", strtotime("-1 months"));
if ( (strtotime($start) < strtotime($prevdate)) || (strtotime($actend) < strtotime($prevdate))  ){
	
$groups = DB::table('dbo_payloadercharttemphub')
					->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
					->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
					->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
					->join('users', 'sensor_hubs.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('dbo_payloadercharttemphub.time between "'.$start.'" and "'.$end.'"')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('gateway_groups.id = "'.$group.'"')
					->where('dbo_payloadercharttemphub.hub', $hubsname)
					->orderBy('dbo_payloadercharttemphub.sensor_id')
					->select('dbo_payloadercharttemphub.*', 'users.fname', 'chart.name')
					->get();








}
else{

					

$groups = DB::table('dbo_payloadercharttemphub')		
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloadercharttemphub.sensor_id')
					->join('users', 'sensors.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('sensors.group_id = "'.$group.'"')
					
					->where('dbo_payloadercharttemphub.hub', $hubsname)
					->whereRaw('dbo_payloadercharttemphub.time between "'.$start.'" and "'.$end.'"')
					->orderBy('dbo_payloadercharttemphub.sensor_id')
					->select('dbo_payloadercharttemphub.*', 'users.fname', 'chart.name')
					->get();

}*/
$groups = DB::table('dbo_payloader')
					->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
					->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
					->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
					->join('users', 'sensor_hubs.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('gateway_groups.id = "'.$group.'"')
					->where('dbo_payloader.hub', $hubsname)
					->orderBy('dbo_payloader.sensor_id')
					->select('dbo_payloader.*', 'users.fname', 'chart.name')
					->get();




					//$arr=array();
					if(count($groups)>0)
					{
						foreach($groups as $item)
						{
							for($h=0;$h<$noofselectedsensors;$h++)
							{
								if ($item->unit == $unit[$h])
								{
									$arr['value'][$h][] = $item->value;
									$arr['hour'][$h][] = $item->time;
									$arr['chart'][$h][] = $item->name;
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
		}
		
		return json_encode($arr);

}
function getsensordatachartnextsens3(Request $request){

$agent = $request->input('agent');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$tme = $request->input('tme');
		$hubs = DB::table('sensor_hubs')->where('id', $hub)->first();
		$hubsname = $hubs->hub_id;
		//\DB::connection()->enableQueryLog();
		$arrslist=array('SMT100#3-2');
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
			//dd($sensorunit);
			if($tme=='week')
			{	
				$start_week = strtotime("-6 day");
				$end_week = strtotime("+1 day");
				$start_week = date("Y-m-d",$start_week);
				$end_week = date("Y-m-d",$end_week);
				foreach($unit as $units)
				{
					/*$groups = DB::table('dbo_payloadercharttemphub')
					->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
					->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
					->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloadercharttemphub.sensor_id')
					->join('users', 'sensor_hubs.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('dbo_payloadercharttemphub.time between "'.$start_week.'" and "'.$end_week.'"')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('gateway_groups.id = "'.$group.'"')
					->where('dbo_payloadercharttemphub.hub', $hubsname)
					->orderBy('dbo_payloadercharttemphub.sensor_id')
					->select('dbo_payloadercharttemphub.*', 'users.fname', 'chart.name')
					->get();*/
//\DB::connection()->enableQueryLog();
/*$groups = DB::table('dbo_payloadercharttemphub')		
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloadercharttemphub.sensor_id')
					->join('users', 'sensors.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('sensors.group_id = "'.$group.'"')
					
					->where('dbo_payloadercharttemphub.hub', $hubsname)
					->whereRaw('dbo_payloadercharttemphub.time between "'.$start_week.'" and "'.$end_week.'"')
					->orderBy('dbo_payloadercharttemphub.sensor_id')
					->select('dbo_payloadercharttemphub.*', 'users.fname', 'chart.name')
					->get();*/

//$queries = \DB::getQueryLog();
//dd($queries);


$groups = DB::table('dbo_payloader')
					->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
					->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
					->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
					->join('users', 'sensor_hubs.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('gateway_groups.id = "'.$group.'"')
					->where('dbo_payloader.hub', $hubsname)
					->orderBy('dbo_payloader.sensor_id')
					->select('dbo_payloader.*', 'users.fname', 'chart.name')
					->get();




					//$arr=array();
					if(count($groups)>0)
					{
						foreach($groups as $item)
						{
							for($h=0;$h<$noofselectedsensors;$h++)
							{
								if ($item->unit == $unit[$h])
								{
									$arr['value'][$h][] = $item->value;
									$arr['hour'][$h][] = $item->time;
									$arr['chart'][$h][] = $item->name;
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
			if($tme =='day')
			{
				foreach($unit as $units)
				{
					/*$groups = DB::table('dbo_payloadercharttemphub')
					->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
					->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
					->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
					->join('users', 'sensor_hubs.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('gateway_groups.id = "'.$group.'"')
					->where('dbo_payloadercharttemphub.hub', $hubsname)
					->whereDate('dbo_payloadercharttemphub.time', Carbon::today())
					->orderBy('dbo_payloadercharttemphub.sensor_id')
					->select('dbo_payloadercharttemphub.*', 'users.fname', 'chart.name')
					->get();*/

/*$groups = DB::table('dbo_payloadercharttemphub')		
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloadercharttemphub.sensor_id')
					->join('users', 'sensors.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('sensors.group_id = "'.$group.'"')
					
					->where('dbo_payloadercharttemphub.hub', $hubsname)
					->whereDate('dbo_payloadercharttemphub.time', Carbon::today())
					->orderBy('dbo_payloadercharttemphub.sensor_id')
					->select('dbo_payloadercharttemphub.*', 'users.fname', 'chart.name')
					->get();*/

$groups = DB::table('dbo_payloader')
					->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
					->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
					->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
					->join('users', 'sensor_hubs.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('gateway_groups.id = "'.$group.'"')
					->where('dbo_payloader.hub', $hubsname)
					->whereDate('dbo_payloader.time', Carbon::today())
					->orderBy('dbo_payloader.sensor_id')
					->select('dbo_payloader.*', 'users.fname', 'chart.name')
					->get();



					//$arr=array();
					if(count($groups)>0)
					{
						foreach($groups as $item)
						{
							for($h=0;$h<$noofselectedsensors;$h++)
							{
								if ($item->unit == $unit[$h])
								{
									$arr['value'][$h][] = $item->value;
									$arr['hour'][$h][] = $item->time;
									$arr['chart'][$h][] = $item->name;
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
			if($tme =='month')
			{
				$start_month = strtotime("-29 day");
				$end_month = strtotime("+1 day");
				$start_month = date("Y-m-d",$start_month);
				$end_month = date("Y-m-d",$end_month);

				/*$groups = DB::table('dbo_payloader')
				->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
				->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
				->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
				->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
				->join('users', 'sensor_hubs.agent', '=', 'users.id')
				->join('chart', 'chart.unit', '=', 'sensors.unit')
				->whereRaw('users.id = "'.$agent.'"')
				->whereRaw('gateway_groups.id = "'.$group.'"')
				->where('dbo_payloader.hub', $hubsname)				
				->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')
				->orderBy('dbo_payloader.sensor_id')
				->select('dbo_payloader.*', 'users.fname', 'chart.name')
				->get();*/	
				//dd($unit);
				$groups = DB::table('dbo_payloadercharttemphub')
				->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloadercharttemphub.hub')
				->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
				->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
				->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloadercharttemphub.sensor_id')
				->join('users', 'sensor_hubs.agent', '=', 'users.id')
				->join('chart', 'chart.unit', '=', 'sensors.unit')
				->whereRaw('users.id = "'.$agent.'"')
				->whereRaw('gateway_groups.id = "'.$group.'"')
				->where('dbo_payloadercharttemphub.hub', $hubsname)->whereIn('sensors.sensor_id',$arrslist)		
				->whereRaw('dbo_payloadercharttemphub.time between "'.$start_month.'" and "'.$end_month.'"')
				->orderBy('dbo_payloadercharttemphub.sensor_id')
				->select('dbo_payloadercharttemphub.*', 'users.fname', 'chart.name')
				->get();
				if(count($groups)>0)
				{													
					//for($h=0;$h<$noofselectedsensors;$h++)
					//{
						//$k=0;
						$j=0;$h=0;						
						foreach($groups as $item)
						{
							//echo $item->value;	
							//if($sensorunit[$h] == $item->sensor_id)
							//{
								//echo $item->value;
								$arr['value'][$h][] = $item->value;
								$arr['hour'][$h][] = $item->time;
								$arr['chart'][$h][] = $item->name;	
								$arr['hub'][$h] = $item->hub;									
								$arr['sensor_id'][$h] = $sensorunit[$h];
								$arr['unit'][$h] = $item->unit;																
							//}							
							$j++;
						//}
						//die();
					}
					$arr['count'] = $noofselectedsensors;			
				}
			}
			if($tme=='one')
			{
				foreach($unit as $units)
				{	
					$start = date("Y-m-d",strtotime($request->input('from')));
					$end = date("Y-m-d",strtotime($request->input('to')."+1 day"));
					$actend=date("Y-m-d",strtotime($request->input('to')));

/*$curdate=date('Y-m-d');
$prevdate = date("Y-m-d", strtotime("-1 months"));
if ( (strtotime($start) < strtotime($prevdate)) || (strtotime($actend) < strtotime($prevdate))  ){
	
$groups = DB::table('dbo_payloadercharttemphub')
					->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
					->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
					->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
					->join('users', 'sensor_hubs.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('dbo_payloadercharttemphub.time between "'.$start.'" and "'.$end.'"')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('gateway_groups.id = "'.$group.'"')
					->where('dbo_payloadercharttemphub.hub', $hubsname)
					->orderBy('dbo_payloadercharttemphub.sensor_id')
					->select('dbo_payloadercharttemphub.*', 'users.fname', 'chart.name')
					->get();








}
else{

					

$groups = DB::table('dbo_payloadercharttemphub')		
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloadercharttemphub.sensor_id')
					->join('users', 'sensors.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('sensors.group_id = "'.$group.'"')
					
					->where('dbo_payloadercharttemphub.hub', $hubsname)
					->whereRaw('dbo_payloadercharttemphub.time between "'.$start.'" and "'.$end.'"')
					->orderBy('dbo_payloadercharttemphub.sensor_id')
					->select('dbo_payloadercharttemphub.*', 'users.fname', 'chart.name')
					->get();

}*/
$groups = DB::table('dbo_payloader')
					->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
					->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
					->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
					->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
					->join('users', 'sensor_hubs.agent', '=', 'users.id')
					->join('chart', 'chart.unit', '=', 'sensors.unit')
					->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')
					->whereRaw('users.id = "'.$agent.'"')
					->whereRaw('gateway_groups.id = "'.$group.'"')
					->where('dbo_payloader.hub', $hubsname)
					->orderBy('dbo_payloader.sensor_id')
					->select('dbo_payloader.*', 'users.fname', 'chart.name')
					->get();




					//$arr=array();
					if(count($groups)>0)
					{
						foreach($groups as $item)
						{
							for($h=0;$h<$noofselectedsensors;$h++)
							{
								if ($item->unit == $unit[$h])
								{
									$arr['value'][$h][] = $item->value;
									$arr['hour'][$h][] = $item->time;
									$arr['chart'][$h][] = $item->name;
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
		}
		
		return json_encode($arr);

}










	public function insertAlgorithm(Request $request)
	{
		$agent = $request->input('agent');
		$name = $request->input('name');
		$push = $request->input('push');
		$hour = $request->input('hour');
		$minute = $request->input('minute');
		$morecondflag=0;
		$conditionall = $request->input('condition2'.'0');
		$chooseallminmax=$request->input('choose'.'0');
		if ($conditionall!='None')
		{
			$morecondflag=1;
		}
		if ($chooseallminmax==1)
		{
             $morecondflag=0;
		}
				
		$data=array('userid'=>$agent,'name'=>$name,'push_message'=>$push,'hour'=>$hour,'minute'=>$minute,'moreconditionflag'=>$morecondflag);
		$userid=DB::table('algorithm')->insertGetId($data);
		if($userid)
		{
		$group = $request->input('group');
		$hub = $request->input('hub');
		$sensor = $request->input('sensor');
		
		$condition1 = $request->input('condition1');
		$value = $request->input('value');
		
		$min = $request->input('min');
		$max = $request->input('max');
		$i=0;
		foreach($group as $item)
		{
		$choose = $request->input('choose'.$i);
		$condition2 = $request->input('condition2'.$i);
		$noneflag=0;
		if ($condition2=='None'){
			$noneflag=1;
		}
		//dd($value);
		$valuealg=DB::table('algorithm_sensor')->insert(array('algorithm_id'=>$userid,'groupid'=>$group[$i],'hub'=>$hub[$i],'sensor'=>$sensor[$i],'choose'=>$choose,'condition1'=>$condition1[$i],'value'=>$value[$i],'condition2'=>$condition2,'min_value'=>$min[$i],'max_value'=>$max[$i],'noneflag'=>$noneflag));
		$i++;
		}
		if($valuealg)
		{
		//echo "Record inserted successfully.<br/>";
		Session::flash('flash_message', 'Record inserted successfully.');
		}
		else
		{
		Session::flash('flash_message', 'Error !!!.');
		//echo '<a href = "/insert">Click Here</a> to go back.';
		}
		}
		return redirect('admin/algorithms');
	}
	public function editAlgorithm($id=0)
	{
		$agents = DB::table('users')
        ->join('role_user', 'role_user.user_id', '=', 'users.id')
		->where('role_user.role_id', 2)
		->get();
	
		$alg = DB::select('select * from algorithm where id='.$id);
		$details = DB::select('select * from algorithm_sensor where algorithm_id='.$id);
		
		$groups = DB::table('sensor_groups')
        ->join('gateway_groups', 'gateway_groups.sensor_group_id', '=', 'sensor_groups.id')
		->where('gateway_groups.agent', $alg[0]->userid)
		->select('sensor_groups.*', 'gateway_groups.id as groupid')
		->get();
		
		foreach($details as $item)
		{
		$hubs[] = DB::table('sensor_hubs')
        //->join('hubs', 'sensor_hubs.hub_id', '=', 'hubs.id')
		->where('sensor_hubs.group_id', $item->groupid)
		->where('sensor_hubs.agent', $alg[0]->userid)
		->select('sensor_hubs.*')
		->get();
		}
		
		foreach($details as $item)
		{
		$sensors[] = DB::table('sensors')
        ->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
		//->where('sensor_hubs.sensor_group_id', $group)
		->where('sensor_hubs.id', $item->hub)
		->select('sensors.*')
		->get();
		}

		return view('admin.algorithms.edit')->with(['agents'=>$agents,'groups'=>$groups,'hubs'=>$hubs,'sensors'=>$sensors,'alg'=>$alg,'details'=>$details]);
	}
	public function updateAlgorithm(Request $request)
	{
		$agent = $request->input('agent');
		$name = $request->input('name');
		$push = $request->input('push');
		$id = $request->input('eid');
		$hour = $request->input('hour');
		$minute = $request->input('minute');
		$morecondflag=0;
		$conditionall = $request->input('condition2'.'0');
		$chooseallminmax=$request->input('choose'.'0');
		if ($conditionall!='None')
		{
			$morecondflag=1;
		}
		if ($chooseallminmax==1)
		{
             $morecondflag=0;
		}
		$data=array('userid'=>$agent,'name'=>$name,'push_message'=>$push,'hour'=>$hour,'minute'=>$minute,'moreconditionflag'=>$morecondflag);
		$userid=DB::table('algorithm')
				->where('id', $id)
				->update($data);
		//echo 123;exit;
		$group = $request->input('group');
		$hub = $request->input('hub');
		$sensor = $request->input('sensor');
		
		$condition1 = $request->input('condition1');
		$value = $request->input('value');
		
		$min = $request->input('min');
		$max = $request->input('max');
		
		DB::table('algorithm_sensor')->where('algorithm_id', '=', $id)->delete();
		//exit;
		$i=0;
		foreach($group as $item)
		{
		$choose = $request->input('choose'.$i);
		$condition2 = $request->input('condition2'.$i);
		$data2=array('algorithm_id'=>$id,'groupid'=>$group[$i],'hub'=>$hub[$i],'sensor'=>$sensor[$i],'choose'=>$choose,'condition1'=>$condition1[$i],'value'=>$value[$i],'condition2'=>$condition2,'min_value'=>$min[$i],'max_value'=>$max[$i]);
		//echo $value[$i].'<br>';
		$value1=DB::table('algorithm_sensor')->insert($data2);
		$i++;
		}
		//exit;
//		if($value1)
//		{
//		//echo "Record inserted successfully.<br/>";
//		Session::flash('flash_message', 'Record inserted successfully.');
//		}
//		else
//		{
//		Session::flash('flash_message', 'Error !!!.');
//		//echo '<a href = "/insert">Click Here</a> to go back.';
//		}
		return redirect('admin/algorithms')->with('flash_message','Record updated successfully.');
		
	}
		
	
	public function deleteAlgorithm($id=0){

    if($id != 0){
      // Delete
    	DB::table('userdatamessages')->where('algorithmid', '=', $id)->delete();
	  DB::table('algorithm_sensor')->where('algorithm_id', '=', $id)->delete();
      DB::table('algorithm')->where('id', '=', $id)->delete();

      Session::flash('flash_message','Delete successfully.');
      
    }
    return redirect()->back();
    }
	######Admin##########
	
	
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
