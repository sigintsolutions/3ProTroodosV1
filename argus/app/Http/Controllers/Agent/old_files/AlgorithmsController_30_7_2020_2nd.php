<?php
 
namespace App\Http\Controllers\Agent;

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
	
	public function getChart(Request $request){
		DB::enableQueryLog();
		$previous_week = strtotime("-1 week +1 day");
		$start_week = strtotime("last sunday midnight",$previous_week);
		$end_week = strtotime("next saturday",$start_week);
		$start_week = date("Y-m-d",$start_week);
		$end_week = date("Y-m-d",$end_week);	
		$sensor = $request->input('sensor');
		//$date=DB::raw("select DATE(dbo_payloader.time) as date from")
		$groups = DB::table('sensors')
        ->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
		//->whereRaw('unit ="V"')
		->whereRaw('dbo_payloader.sensor_id like "'.$sensor.'"')
		->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')
		->select(array('dbo_payloader.*',\DB::raw("DATE(dbo_payloader.time) as date")))
		->groupBy('date')
		->get();
		$query = DB::getQueryLog();
		//print_r($query);exit;
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
		
//print_r($arr);exit;
		return json_encode($arr);
//		echo "<option value=''>Select</option>";
//		foreach($groups as $item)
//		{
//		if($group==$item->id)
//		{
//		echo "<option value='".$item->id."' selected>".$item->name."</option>";
//		}
//		else
//		{
//		echo "<option value='".$item->id."'>".$item->name."</option>";
//		}
//		}
	}	
	
	public function getGroup(Request $request){
	//echo 123;
		$agent = session()->get('userid');
		$group = $request->input('group');
		$groups = DB::table('sensor_groups')
        ->join('gateway_groups', 'gateway_groups.sensor_group_id', '=', 'sensor_groups.id')
		->where('gateway_groups.agent', $agent)
		->select('sensor_groups.*', 'gateway_groups.id as id')
		->get();
		//print_r($groups);exit;
		echo '<select class="form-control " id="group3" name="group[]" multiple="multiple" >';
		echo "<option value=''>Select</option>";
		foreach($groups as $item)
		{
		if($group==$item->id)
		{
		echo "<option value='".$item->id."' selected>".$item->name."</option>";
		}
		else
		{
		echo "<option value='".$item->id."'>".$item->name."</option>";
		}
		}
		echo "</select>";
	}
	public function getHub(Request $request)
	{
	//DB::enableQueryLog();
		$group = $request->input('group');
		$agent = session()->get('userid');
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
		$agent = session()->get('userid');
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
		//print_r($hubs);exit;
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
		$agent = session()->get('userid');
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
	//DB::enableQueryLog();
		$hub = $request->input('hub');
		$agent = session()->get('userid');
		$group = $request->input('group');
		$agent = session()->get('userid');

		if(!is_array($hub))
		{
		$sensors = DB::table('sensors')
        ->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
		->where('sensor_hubs.sensor_group_id', $group)
		->where('sensor_hubs.hub_id', $hub)
		->where('sensor_hubs.agent', $agent)
		->select('sensors.*')
		->get();
		}
		else
		{
		$sensors = DB::table('sensors')
        ->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
		->whereIn('sensor_hubs.sensor_group_id', $group)
		->whereIn('sensor_hubs.hub_id', $hub)
		->where('sensor_hubs.agent', $agent)
		->select('sensors.*')
		->get();
		}
		//print_r($groups);exit;
		//dd(DB::getQueryLog());
		echo '<select class="form-control sensor3" id="sensor3" name="sensor[]"  multiple="multiple" >';
		echo "<option value=''>Select</option>";
		foreach($sensors as $item)
		{
		echo "<option value='".$item->sensor_id."'>".$item->sensor_id."</option>";
		}
		echo "</select>";
	}

public function getsensortimefetchpageprev(Request $request)
	{
//dd("prev");

$agent = session()->get('userid');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$tme = $request->input('tme');
		$hubs = DB::table('sensor_hubs')->where('id', $hub)->first();		
		$hubsname = $hubs->hub_id;
		$currentoffset=$request->input('currentoffsethub');
		
		$pageno=$request->input('pagenohub');

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

//$currentoffset=$request->input('currentoffset');
		
		//$pageno=$request->input('pageno');
		$pageno=$pageno-1;
$currentoffset=($pageno-1)*100;
$skip=$currentoffset;

$items=DB::table('dbo_payloader')->where('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')->whereIn('dbo_payloader.sensor_id', $agentsensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take($skip)->get();



$start_month=$start_week;
$end_month=$end_week;







		}
		if($tme =='day')
		{
			/*$items = DB::table('dbo_payloader')
			->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
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
//$hubs = DB::table('sensor_hubs')->where('id', $hub)->first();
			//sensors
			$agentsensorsdt=DB::table('sensors')->where('hub_id', $hub)->get();
$agentsensor=array();
foreach($agentsensorsdt as $adt){
$agentsensor[]=$adt->sensor_id;
}
//$currentoffset=$request->input('currentoffset');
		
		//$pageno=$request->input('pageno');
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
//$currentoffset=$request->input('currentoffset');
		
		//$pageno=$request->input('pageno');
		$pageno=$pageno-1;
$currentoffset=($pageno-1)*100;
$skip=$currentoffset;
$items=DB::table('dbo_payloader')->where('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')->whereIn('dbo_payloader.sensor_id', $agentsensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();


$start_month=$request->input('from');
$end_month=$request->input('to');



		}
		//print_r($items);die();
		$unit=0;
		$sensor=0;
		return view('agent.report.pagination_data2_sensor')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);





	}
public function getsensortimefetchpage(Request $request)
	{
//dd("next");

$agent = session()->get('userid');
		$group = $request->input('group');
		$hub = $request->input('hub');
		//dd($hub);
		$tme = $request->input('tme');
		$hubs = DB::table('sensor_hubs')->where('id', $hub)->first();		
		$hubsname = $hubs->hub_id;
$currentoffset=$request->input('currentoffsethub');
		
		$pageno=$request->input('pagenohub');



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
//$currentoffset=$request->input('currentoffset');
		
		//$pageno=$request->input('pageno');

//$currentoffset=$currentoffset+500;
		
$currentoffset=$pageno*100;
$skip=$currentoffset;
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
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
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

//$currentoffset=$currentoffset+500;
		
$currentoffset=$pageno*100;
$skip=$currentoffset;
$items=DB::table('dbo_payloader')->where('dbo_payloader.hub', $hubsname)->whereDate('dbo_payloader.time', Carbon::today())->whereIn('dbo_payloader.sensor_id', $agentsensor)->orderby('dbo_payloader.id','desc')->skip($skip)->take(100)->get();
$pageno=$pageno+1;

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
//$hubs = DB::table('sensor_hubs')->where('id', $hub)->first();
			//sensors
			$agentsensorsdt=DB::table('sensors')->where('hub_id', $hub)->get();
$agentsensor=array();
foreach($agentsensorsdt as $adt){
$agentsensor[]=$adt->sensor_id;
}
//$currentoffset=$request->input('currentoffset');
		
		//$pageno=$request->input('pageno');

//$currentoffset=$currentoffset+500;
		//$currentoffset=$request->input('currentoffset');
		
		//$pageno=$request->input('pageno');
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
		//print_r($items);die();
		$unit=0;
		$sensor=0;
		return view('agent.report.pagination_data2_sensor')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);



	}

	public function getSensordata(Request $request)
	{
		$agent = session()->get('userid');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$tme = $request->input('tme');
		$hubs = DB::table('sensor_hubs')->where('id', $hub)->first();		
		$hubsname = $hubs->hub_id;
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
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
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
//$hubs = DB::table('sensor_hubs')->where('id', $hub)->first();
			//sensors
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
		//print_r($items);die();
		$unit=0;
		$sensor=0;
		return view('agent.report.pagination_data2_sensor')->with(['items'=>$items,'unit' =>$unit,'hubsname'=> $hubsname,'sensor'=>$sensor,'start_month'=>$start_month,'end_month'=>$end_month,'agent'=>$agent,'group'=>$group,'currentoffset'=>$currentoffset,'pageno'=>$pageno]);
	}

public function savecharttempdatahub(Request $request){
//dd("chart save");
$agent = session()->get('userid');
		$group = $request->input('group');
		$hub = $request->input('hub');
		$tme = $request->input('tme');
		$hubs = DB::table('sensor_hubs')->where('id', $hub)->first();		
		$hubsname = $hubs->hub_id;
		$loginid=session()->get('userid');
		$agentdt=DB::table('users')->where('Id',$agent)->first();
$agentname=$agentdt->fname." ".$agentdt->lname;
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

$items=DB::table('dbo_payloader')->where('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')->whereIn('dbo_payloader.sensor_id', $agentsensor)->orderby('dbo_payloader.id','desc')->get();
foreach ($items as $item) {

$sensdt=DB::table('sensors')->where('sensor_id',$item->sensor_id)->where('unit',$item->unit)->first();
$hubid=$sensdt->hub_id;
$hubdt=DB::table('sensor_hubs')->where('id',$hubid)->first();
$groupid=$hubdt->sensor_group_id;
$grpdt=DB::table('sensor_groups')->where('id',$groupid)->first();
$gatewaygrp=$grpdt->name;
	//$gatewayname
	$data=array("loginid"=>$loginid,"hub"=>$item->hub,"time"=>$item->time,"sensor_id"=>$item->sensor_id,"unit"=>$item->unit,"value"=>$item->value,"sensor_type"=>$item->sensor_type,"utc"=>$item->utc,"agentname"=>$agentname,"gatewaygrp"=>$gatewaygrp);
		$value=DB::table('dbo_payloadercharttemphub')->insertGetId($data);
}





		}
		if($tme =='day')
		{
			/*$items = DB::table('dbo_payloader')
			->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
			->join('gateway_groups', 'sensor_hubs.group_id', '=', 'gateway_groups.id')
			->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
			->join('users', 'sensor_hubs.agent', '=', 'users.id')
			->join('sensors', 'sensors.sensor_id', '=', 'dbo_payloader.sensor_id')
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

$items=DB::table('dbo_payloader')->where('dbo_payloader.hub', $hubsname)->whereDate('dbo_payloader.time', Carbon::today())->whereIn('dbo_payloader.sensor_id', $agentsensor)->orderby('dbo_payloader.id','desc')->take(100)->get();
//dd($items);
foreach ($items as $item) {

$sensdt=DB::table('sensors')->where('sensor_id',$item->sensor_id)->where('unit',$item->unit)->first();
$chartdt=DB::table('chart')->where('unit',$item->unit)->first();
$chartname=$chartdt->name;
$hubid=$sensdt->hub_id;
$hubdt=DB::table('sensor_hubs')->where('id',$hubid)->first();
$groupid=$hubdt->sensor_group_id;
$grpdt=DB::table('sensor_groups')->where('id',$groupid)->first();
$gatewaygrp=$grpdt->name;
	//$gatewayname
	$data=array("loginid"=>$loginid,"hub"=>$item->hub,"time"=>$item->time,"sensor_id"=>$item->sensor_id,"unit"=>$item->unit,"value"=>$item->value,"sensor_type"=>$item->sensor_type,"utc"=>$item->utc,"agentname"=>$agentname,"gatewaygrp"=>$gatewaygrp,"name"=>$chartname);
		$value=DB::table('dbo_payloadercharttemphub')->insertGetId($data);
}








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
//$hubs = DB::table('sensor_hubs')->where('id', $hub)->first();
			//sensors

			//dd($tme);
			$agentsensorsdt=DB::table('sensors')->where('hub_id', $hub)->get();
$agentsensor=array();
foreach($agentsensorsdt as $adt){
$agentsensor[]=$adt->sensor_id;
}
//dd($hubsname,$agentsensor);
$items=DB::table('dbo_payloader')->where('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start_month.'" and "'.$end_month.'"')->whereIn('dbo_payloader.sensor_id', $agentsensor)->orderby('dbo_payloader.id','desc')->get();
//dd($items);
foreach ($items as $item) {

$sensdt=DB::table('sensors')->where('sensor_id',$item->sensor_id)->where('unit',$item->unit)->first();
$hubid=$sensdt->hub_id;
$hubdt=DB::table('sensor_hubs')->where('id',$hubid)->first();
$groupid=$hubdt->sensor_group_id;
$grpdt=DB::table('sensor_groups')->where('id',$groupid)->first();
$gatewaygrp=$grpdt->name;
	//$gatewayname
	$data=array("loginid"=>$loginid,"hub"=>$item->hub,"time"=>$item->time,"sensor_id"=>$item->sensor_id,"unit"=>$item->unit,"value"=>$item->value,"sensor_type"=>$item->sensor_type,"utc"=>$item->utc,"agentname"=>$agentname,"gatewaygrp"=>$gatewaygrp);
		$value=DB::table('dbo_payloadercharttemphub')->insertGetId($data);
}









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

$items=DB::table('dbo_payloader')->where('dbo_payloader.hub', $hubsname)->whereRaw('dbo_payloader.time between "'.$start.'" and "'.$end.'"')->whereIn('dbo_payloader.sensor_id', $agentsensor)->orderby('dbo_payloader.id','desc')->get();
foreach ($items as $item) {

$sensdt=DB::table('sensors')->where('sensor_id',$item->sensor_id)->where('unit',$item->unit)->first();
$hubid=$sensdt->hub_id;
$hubdt=DB::table('sensor_hubs')->where('id',$hubid)->first();
$groupid=$hubdt->sensor_group_id;
$grpdt=DB::table('sensor_groups')->where('id',$groupid)->first();
$gatewaygrp=$grpdt->name;
	//$gatewayname
	$data=array("loginid"=>$loginid,"hub"=>$item->hub,"time"=>$item->time,"sensor_id"=>$item->sensor_id,"unit"=>$item->unit,"value"=>$item->value,"sensor_type"=>$item->sensor_type,"utc"=>$item->utc,"agentname"=>$agentname,"gatewaygrp"=>$gatewaygrp);
		$value=DB::table('dbo_payloadercharttemphub')->insertGetId($data);
}







		}
		//print_r($items);die();
		$unit=0;
		$sensor=0;

}

	public function getSensordatachart(Request $request)
	{


//dd("chart portion");

		$agent = session()->get('userid');
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
		foreach($hubscount as $hubscounts)
		{
			$unit[] = $hubscounts->unit;
		}
		if($tme=='week')
		{	
			foreach($unit as $units)
			{
				$start_week = strtotime("-6 day");
				$end_week = strtotime("+1 day");
				$start_week = date("Y-m-d",$start_week);
				$end_week = date("Y-m-d",$end_week);
				$items = DB::table('dbo_payloader')
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
				/*$agentsensorsdt=DB::table('sensors')->where('hub_id', $hub)->get();
$agentsensor=array();
foreach($agentsensorsdt as $adt){
$agentsensor[]=$adt->sensor_id;
}

$items=DB::table('dbo_payloadercharttemphub')->where('dbo_payloadercharttemphub.hub', $hubsname)->whereRaw('dbo_payloadercharttemphub.time between "'.$start_week.'" and "'.$end_week.'"')->whereIn('dbo_payloadercharttemphub.sensor_id', $agentsensor)->orderby('dbo_payloadercharttemphub.id','desc')->get();*/
				$arr=array();
				if(count($items)>0)
				{
					foreach($items as $item)
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
				$items = DB::table('dbo_payloader')
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

/*$agentsensorsdt=DB::table('sensors')->where('hub_id', $hub)->get();
$agentsensor=array();
foreach($agentsensorsdt as $adt){
$agentsensor[]=$adt->sensor_id;
}

$items=DB::table('dbo_payloadercharttemphub')->where('dbo_payloadercharttemphub.hub', $hubsname)->whereDate('dbo_payloadercharttemphub.time', Carbon::today())->whereIn('dbo_payloadercharttemphub.sensor_id', $agentsensor)->orderby('dbo_payloadercharttemphub.id','desc')->get();*/



				$arr=array();
				if(count($items)>0)
				{
					foreach($items as $item)
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
				$items = DB::table('dbo_payloader')
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
				->get();

/*$agentsensorsdt=DB::table('sensors')->where('hub_id', $hub)->get();
$agentsensor=array();
foreach($agentsensorsdt as $adt){
$agentsensor[]=$adt->sensor_id;
}

$items=DB::table('dbo_payloadercharttemphub')->where('dbo_payloadercharttemphub.hub', $hubsname)->whereDate('dbo_payloadercharttemphub.time', Carbon::today())->whereIn('dbo_payloadercharttemphub.sensor_id', $agentsensor)->orderby('dbo_payloadercharttemphub.id','desc')->whereRaw('dbo_payloadercharttemphub.time between "'.$start_month.'" and "'.$end_month.'"')->get();*/

				$arr=array();
				if(count($items)>0)
				{
					foreach($items as $item)
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
				$items = DB::table('dbo_payloader')
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

			/*	$agentsensorsdt=DB::table('sensors')->where('hub_id', $hub)->get();
$agentsensor=array();
foreach($agentsensorsdt as $adt){
$agentsensor[]=$adt->sensor_id;
}

$items=DB::table('dbo_payloadercharttemphub')->where('dbo_payloadercharttemphub.hub', $hubsname)->whereRaw('dbo_payloadercharttemphub.time between "'.$start.'" and "'.$end.'"')->whereIn('dbo_payloadercharttemphub.sensor_id', $agentsensor)->orderby('dbo_payloadercharttemphub.id','desc')->get();*/
				$arr=array();
				if(count($items)>0)
				{
					foreach($items as $item)
					{
						for($h=0;$h<$noofselectedsensors;$h++)
						{
							if ($item->unit == $unit[$h])
							{
								$arr['value'][$h][] = $item->value;
								$arr['hour'][$h][] = $item->time;
								$arr['chart'][0] = $item->name;
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
		//dd($arr);
		return json_encode($arr);
	}
	public function insertAlgorithm(Request $request){
		$agent = $request->input('agent');
		$name = $request->input('name');
		$push = $request->input('push');
		$hour = $request->input('hour');
		$minute = $request->input('minute');
				
		$data=array('userid'=>$agent,'name'=>$name,'push_message'=>$push,'hour'=>$hour,'minute'=>$minute);
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
		$value=DB::table('algorithm_sensor')->insert(array('algorithm_id'=>$userid,'groupid'=>$group[$i],'hub'=>$hub[$i],'sensor'=>$sensor[$i],'choose'=>$choose,'condition1'=>$condition1[$i],'value'=>$value[$i],'condition2'=>$condition2,'min_value'=>$min[$i],'max_value'=>$max[$i]));
		$i++;
		}
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
		->select('sensor_groups.*')
		->get();
		
		foreach($details as $item)
		{
		$hubs[] = DB::table('sensor_hubs')
        ->join('hubs', 'sensor_hubs.hub_id', '=', 'hubs.id')
		->where('sensor_hubs.sensor_group_id', $item->groupid)
		->where('sensor_hubs.agent', $alg[0]->userid)
		->select('hubs.name','hubs.id as hid','sensor_hubs.*')
		->get();
		}
		
		foreach($details as $item)
		{
		$sensors[] = DB::table('sensors')
        ->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
		//->where('sensor_hubs.sensor_group_id', $group)
		->where('sensor_hubs.hub_id', $item->hub)
		->select('sensors.*')
		->get();
		}

		return view('agent.algorithms.edit')->with(['agents'=>$agents,'groups'=>$groups,'hubs'=>$hubs,'sensors'=>$sensors,'alg'=>$alg,'details'=>$details]);
	}
	public function updateAlgorithm(Request $request){
		$agent = $request->input('agent');
		$name = $request->input('name');
		$push = $request->input('push');
		$id = $request->input('eid');
		$hour = $request->input('hour');
		$minute = $request->input('minute');
		
		$data=array('userid'=>$agent,'name'=>$name,'push_message'=>$push,'hour'=>$hour,'minute'=>$minute);
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
		return redirect('agent/algorithm')->with('flash_message','Record updated successfully.');
		
	}
		
	
	public function deleteAlgorithm($id=0){

    if($id != 0){
      // Delete
	  DB::table('algorithm_sensor')->where('algorithm_id', '=', $id)->delete();
      DB::table('algorithm')->where('id', '=', $id)->delete();

      Session::flash('flash_message','Delete successfully.');
      
    }
    return redirect()->back();
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
    		->select('sensors.*')
    		->get();
		}
		else
		{
    		$sensors = DB::table('sensors')
            ->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
			->whereIn('sensors.hub_id', $hub)
			->where('sensors.unit', $unit)
    		->select('sensors.*')
    		->get();
		}
		echo '<select class="form-control sensor" id="sensor" name="sensor[]"  multiple="multiple" >';
		echo "<option value=''>Select</option>";
		foreach($sensors as $item)
		{
		    echo "<option value='".$item->sensor_id."'>".$item->sensor_id."</option>";
		}
		echo "</select>";
	}
	######Admin##########
}
