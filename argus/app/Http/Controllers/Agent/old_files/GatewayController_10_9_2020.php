<?php
 
namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Session;
use Hash;
//use App\Group;
use DB;

class GatewayController extends Controller
{
    public function index()
    {
        //abort_unless(\Gate::allows('product_access'), 403);

        //$groups = Group::all();
		
		//$agents = DB::select('select * from users inner join role_user on users.id=role_user.user_id where role_user.role_id=1');
		$sensors = DB::table('sensors')
        ->paginate(10);
		//print_r($groups);
        return view('admin.sensor.index')->with(['sensors'=>$sensors,'hubid'=>$id]);
    }
	public function showGateway(Request $request)
    {
		// ini_set('max_execution_time', 600);
		// @$id = $request->input('gateway');

				
		// @$gateways = DB::table('gateway_groups')
		// ->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
		// ->where('agent', session()->get('userid'))
		// ->select('gateway_groups.*', 'gateway_groups.group_id','sensor_groups.name','sensor_groups.id as gid')
		// ->get();
		// 		if(@$gateways)
		// 		{
		// 		if($id)
		// 		{
		// $gateway = DB::table('gateway_groups')
		// ->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
		// ->where('agent', session()->get('userid'))
		// ->where('gateway_groups.sensor_group_id', $id)
		// ->select('gateway_groups.*', 'gateway_groups.group_id','sensor_groups.name','sensor_groups.id as gid')
		// ->get();
		// 					foreach($gateway as $item)
		// 	{
		// 	$gid= @$item->gid;break;
		// 	}

		// 		}
		// 		else
		// 		{	
		// $gateway = DB::table('gateway_groups')
		// ->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
		// ->where('agent', session()->get('userid'))
		// ->select('gateway_groups.*', 'gateway_groups.group_id','sensor_groups.name','sensor_groups.id as gid')
		// ->get();
		
		// 					foreach($gateway as $item)
		// 	{
		// 	$gid= @$item->gid;break;
		// 	}

		// 		}
		// 	if(@$gid!="")
		// 	{
		// $hub = DB::table('sensor_hubs')
		// ->join('sensor_groups', 'sensor_groups.id', '=', 'sensor_hubs.sensor_group_id')
		// ->join('hubs', 'hubs.id', '=', 'sensor_hubs.hub_id')
		// ->where('agent', session()->get('userid'))
		// ->where('sensor_group_id', $gid)
		// ->select('sensor_hubs.*', 'sensor_hubs.sensor_hub_id','hubs.name')
		// 		->get();
		// 	foreach($hub as $item)
		// 	{
		// 	@$hid= $item->id;break;
		// 	}
		// $sensor = DB::table('sensors')
		// ->where('hub_id', $hid)
		// ->join('types', 'sensors.type', '=', 'types.id')
		// ->join('brands', 'sensors.brand', '=', 'brands.id')
		// ->join('measurement_units', 'sensors.measure_unit', '=', 'measurement_units.id')
		// ->join('units', 'measurement_units.unit', '=', 'units.id')
		// ->select('sensors.*','sensors.id as sensorid', 'types.name as typename', 'brands.name as brandname', 'units.name as unitname','measurement_units.*')
		// ->get();
		// }
		// }
		$agentid = session()->get('userid');
		$user = DB::select('select * from users where id ='.$agentid);
        $groups = DB::table('gateway_groups')
		->join('users', 'gateway_groups.agent', '=', 'users.id')
		->join('role_user', 'role_user.user_id', '=', 'users.id')
		->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
		->where('role_user.role_id', 2)
		->where('gateway_groups.agent', $agentid)
		->where('users.status', 1)
		->select('gateway_groups.*', 'gateway_groups.group_id','users.fname','sensor_groups.name')
		->orderBy('added_on', 'DESC')
		->paginate(10);
		$groupnames = DB::table('sensor_groups')->get();
		return view('agent.sensor.index')->with(['groups'=>$groups])->with(['user'=>$user])->with(['groupnames'=>$groupnames]);
        //return view('agent.sensor.index')->with(['gateway'=>@$gateway,'hub'=>@$hub,'sensor'=>@$sensor,'gateways'=>@$gateways]);
    }
	######Gateway Groups##########
	public function addView(Request $request)
	{
	
		@$gid = $request->get('hub');
		$hub = DB::table('sensor_hubs')
		->join('sensor_groups', 'sensor_groups.id', '=', 'sensor_hubs.sensor_group_id')
		->join('hubs', 'hubs.id', '=', 'sensor_hubs.hub_id')
		->where('agent', session()->get('userid'))
		->where('sensor_hubs.id', $gid)
		->select('sensor_hubs.*', 'sensor_hubs.sensor_hub_id','hubs.name')
				->get();
				//dd(DB::getQueryLog());
				//print_r($hub);exit;
			foreach($hub as $item)
			{
			@$hid= $item->id;break;
			}
			//echo $hid;exit;
//			if(@$hid)
//			{
//		$sensor = DB::table('sensors')
//		->where('hub_id', $hid)
//		->join('types', 'sensors.type', '=', 'types.id')
//		->join('brands', 'sensors.brand', '=', 'brands.id')
//		->join('measurement_units', 'sensors.measure_unit', '=', 'measurement_units.id')
//		->join('units', 'measurement_units.unit', '=', 'units.id')
//		->select('sensors.*','sensors.id as sensorid', 'types.name as typename', 'brands.name as brandname', 'units.name as unitname','measurement_units.*')
//		->get();
//				}
		$sensor = DB::table('sensors')
		->where('hub_id', $hid)
		->join('types', 'sensors.type', '=', 'types.id')
		->join('brands', 'sensors.brand', '=', 'brands.id')
		->join('measurement_units', 'sensors.measure_unit', '=', 'measurement_units.id')
		->join('units', 'measurement_units.unit', '=', 'units.id')
		->select('sensors.*','sensors.id as sensorid', 'types.name as typename', 'brands.name as brandname', 'units.name as unitname','measurement_units.*')
		->get();
		//print_r($sensor);exit;
        //->paginate(10); 
		//print_r($groups);
        return view('agent.sensor.show')->with(['hub'=>@$hub,'sensor'=>@$sensor]);
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
	// public function editSensor($id='',$hid='')
	// {
	// 	$types = DB::table('types')
	// 			->get();
	// 	$brands = DB::table('brands')
    //             ->get();
	// 	$units = DB::table('measurement_units')
	// 			->join('units', 'measurement_units.unit', '=', 'units.id')
	// 			->select('measurement_units.*', 'units.name')
    //             ->get();
	// 	$units2= DB::table('units')
    //             ->get();
	// 	$group = DB::select('select * from sensors where id='.$id);
	// 	//print_r($group);exit;
	// 	return view('admin.sensor.edit')->with(['types'=>$types,'brands'=>$brands,'hub_id'=>$id,'units'=>$units,'group'=>$group,'units2'=>$units2]);
	// }
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
			
		if($value)
		{
		Session::flash('flash_message', 'Record updated successfully.');
		}
		else
		{
		Session::flash('flash_message', 'Error !!!.');
		}
		return redirect('admin/showsensor/'.$hub_id);
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
	public function profileagent($id=0)
	{
		$agents = DB::table('users')
			->join('role_user', 'role_user.user_id', '=', 'users.id')
			->where('role_user.role_id', 2)
			->where('users.status', 1)
			->get();							
		$groups = DB::table('sensor_groups')->get();			
		$group = DB::select('select * from gateway_groups where id='.$id);
		$user = DB::select('select * from users where id='.$group[0]->agent);
		//echo $group[0]->agent;die();
		$grouplists = DB::table('gateway_groups')
		->join('users', 'gateway_groups.agent', '=', 'users.id')
		->join('role_user', 'role_user.user_id', '=', 'users.id')
		->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
		->where('role_user.role_id', 2)
		->where('gateway_groups.agent', $group[0]->agent)
		->where('users.status', 1)
		->select('gateway_groups.*', 'gateway_groups.group_id','users.fname','sensor_groups.name')
		->orderBy('added_on', 'DESC')
		->get();
		$types = DB::table('types')->get();
		$brands = DB::table('brands')->get();
		$units = DB::table('measurement_units')
				->join('units', 'measurement_units.unit', '=', 'units.id')
				->select('measurement_units.*', 'units.name')
                ->get();
		$groupnames = DB::table('sensor_groups')->get();
		$hublists = DB::table('hubs')->get();
		//print_r()
		return view('agent.sensor.edit')->with([
			'group'=>$group,
			'agents'=>$agents,
			'groups'=>$groups,
			'grouplists'=>$grouplists,
			'user'=>$user,
			'hublists'=>$hublists,
			'types'=>$types,
			'brands'=>$brands,
			'units'=>$units,
			'groupnames'=>$groupnames
		]);
	}
	public function editGatewaygrouptree($id=0)
	{
		$group = DB::select('select * from gateway_groups where id='.$id);
		$grouplists = DB::table('gateway_groups')
		->join('users', 'gateway_groups.agent', '=', 'users.id')
		->join('role_user', 'role_user.user_id', '=', 'users.id')
		->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
		->where('role_user.role_id', 2)
		->where('gateway_groups.agent', $group[0]->agent)
		->where('users.status', 1)
		->select('gateway_groups.*', 'gateway_groups.group_id','users.fname','sensor_groups.name')
		->orderBy('added_on', 'DESC')
		->get();
		$agents = DB::table('users')
			->join('role_user', 'role_user.user_id', '=', 'users.id')
			->where('role_user.role_id', 2)
			->where('users.status', 1)
			->get();							
		$groups = DB::table('sensor_groups')->get();			
		$user = DB::select('select * from users where id='.$group[0]->agent);
		$user = DB::select('select * from users where id='.$group[0]->agent);
		return view('agent.sensor.treegroup')->with([
			'group'=>$group,
			'agents'=>$agents,
			'grouplists'=>$grouplists,
			'groups'=>$groups,
			'user'=>$user
		]);
	}
	public function sensorhubs()
    {
		$agentid = request()->agentid;
		$groupid = request()->groupid;
		$user = DB::select('select * from users where id ='.$agentid);
		$group = DB::select('select * from gateway_groups where id ='.$groupid);
		$groupname = DB::select('select * from sensor_groups where id ='.$group[0]->sensor_group_id);
        $hubs = DB::table('sensor_hubs')
		->join('users', 'sensor_hubs.agent', '=', 'users.id')
		->join('role_user', 'role_user.user_id', '=', 'users.id')
		->join('sensor_groups', 'sensor_groups.id', '=', 'sensor_hubs.sensor_group_id')
		->join('gateway_groups', 'gateway_groups.id', '=', 'sensor_hubs.group_id')
		//->join('hubs', 'hubs.id', '=', 'sensor_hubs.hub_id')
		->where('role_user.role_id', 2)
		->where('users.status', 1)
		->where('sensor_hubs.agent', request()->agentid)
		->where('sensor_hubs.group_id', request()->groupid)
		->select('sensor_hubs.*', 'sensor_hubs.sensor_hub_id','users.fname','sensor_groups.name as groupname')
		->orderBy('added_on', 'DESC')
		//->paginate(10);
		->get();
		$hublists = DB::table('hubs')->get();
        return view('agent.sensor.hub')->with(['hubs' => $hubs])->with(['user' => $user])->with(['groupname' => $groupname])->with(['group' => $group])->with(['hublists' => $hublists]);
	}
	public function profileSensorhub($id=0)
	{			
		//$hubs = DB::table('dbo_payloader')->groupBy('hub')->get();


		$group = DB::select('select * from sensor_hubs where id='.$id);
		$hubs = DB::table('sensor_hubs')->where('agent',$group[0]->agent)->get();
		$hubname = DB::table('sensor_hubs')->where('hub_id', $group[0]->hub_id)->get();
		$agents = DB::table('users')
		->join('role_user', 'role_user.user_id', '=', 'users.id')
		->where('role_user.role_id', 2)
		->where('users.status', 1)
		->where('users.id', $group[0]->agent)
		->get();
		$grouplists = DB::table('gateway_groups')
		->join('users', 'gateway_groups.agent', '=', 'users.id')
		->join('role_user', 'role_user.user_id', '=', 'users.id')
		->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
		->where('role_user.role_id', 2)
		->where('gateway_groups.agent', $group[0]->agent)
		->where('users.status', 1)
		->select('gateway_groups.*', 'gateway_groups.group_id','users.fname','sensor_groups.name')
		->orderBy('added_on', 'DESC')
		->get();
		//print_r($grouplists);die();
		$user = DB::select('select * from users where id='.$group[0]->agent);
		$groups = DB::table('sensor_groups')->where('id', $group[0]->sensor_group_id)->get();
		$hublists =array();
		//$hublists = DB::table('dbo_payloader')->groupBy('hub')->get();
		$types = DB::table('types')->get();
		$brands = DB::table('brands')->get();
		$units = DB::table('measurement_units')
				->join('units', 'measurement_units.unit', '=', 'units.id')
				->select('measurement_units.*', 'units.name')
				->get();
		$groupnames = DB::table('sensor_groups')->get();
		return view('agent.sensor.hubedit')->with([
			'group'=>$group,
			'agents'=>$agents,
			'groups'=>$groups,
			'grouplists'=>$grouplists,
			'user'=>$user,
			'hubs'=>$hubs,
			'hubname'=>$hubname,
			'hublists'=>$hublists,
			'types'=>$types,
			'brands'=>$brands,
			'units'=>$units,
			'groupnames'=>$groupnames
		]);
	}
	public function editSensorhubtree($id=0)
	{	
		$group = DB::select('select * from sensor_hubs where id='.$id);
		$grouplists = DB::table('gateway_groups')
		->join('users', 'gateway_groups.agent', '=', 'users.id')
		->join('role_user', 'role_user.user_id', '=', 'users.id')
		->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
		->where('role_user.role_id', 2)
		->where('gateway_groups.agent', $group[0]->agent)
		->where('users.status', 1)
		->select('gateway_groups.*', 'gateway_groups.group_id','users.fname','sensor_groups.name')
		->orderBy('added_on', 'DESC')
		->get();
		$agents = DB::table('users')
		->join('role_user', 'role_user.user_id', '=', 'users.id')
		->where('role_user.role_id', 2)
		->where('users.status', 1)
		->where('users.id', $group[0]->agent)
		->get();	
		$groups = DB::table('sensor_groups')->where('id', $group[0]->sensor_group_id)->get();	
		$user = DB::select('select * from users where id='.$group[0]->agent);
		$hubname = DB::table('sensor_hubs')->where('hub_id', $group[0]->hub_id)->get();
		return view('agent.sensor.treehub')->with([
			'agents'=>$agents,
			'groups'=>$groups,
			'hubname'=>$hubname,
			'grouplists'=>$grouplists,
			'user'=>$user
		]);
	}
	public function sensors()
    {
		$agentid = request()->agentid;
		$groupid = request()->groupid;
		$hubid = request()->hubid;
		$user = DB::select('select * from users where id ='.$agentid);
		$group = DB::select('select * from gateway_groups where id ='.$groupid);
		$groupname = DB::select('select * from sensor_groups where id ='.$group[0]->sensor_group_id);
		$hub = DB::select('select * from sensor_hubs where id ='.$hubid);
		$hubname = DB::select('select * from sensor_hubs where hub_id ="'.$hub[0]->hub_id.'"');
		$sensors = DB::table('sensors')
		->where('hub_id', $hubid)
		->join('types', 'sensors.type', '=', 'types.id')
		->select('sensors.*','sensors.id as sensorid', 'sensors.sensor_type as typename', 'types.brand', 'sensors.unit')
		->get();
		$types = DB::table('types')->get();
		return view('agent.sensor.sensor')->with(['sensors'=>$sensors,'hubid'=>$hubid, 'user'=>$user, 'groupname'=>$groupname, 'group'=>$group, 'hubname'=>$hubname, 'types'=>$types]);
	}
	public function editSensor($id='',$hid='')
	{	
		$agentid = request()->agentid;
		$groupid = request()->groupid;	
		$types = DB::table('types')
				->get();
		
		$brands = DB::table('brands')
                ->get();
		$units = DB::table('measurement_units')->get();

		$group = DB::select('select * from sensors where id='.$id);
		$typname = DB::table('types')->where('id', $group[0]->type)->get();
		$user = DB::select('select * from users where id ='.$agentid);
		$groups = DB::select('select * from gateway_groups where id ='.$groupid);
		$groupname = DB::select('select * from sensor_groups where id ='.$groups[0]->sensor_group_id);
		$hub = DB::select('select * from sensor_hubs where id ='.$hid);
		$hubname = DB::select('select * from sensor_hubs where hub_id ="'.$hub[0]->hub_id.'"');
		$user = DB::select('select * from users where id='.$agentid);
		$hublists =array();
		//$hublists = DB::table('dbo_payloader')->groupBy('hub')->get();
		$groupnames = DB::table('sensor_groups')->get();
		$grouplists = DB::table('gateway_groups')
		->join('users', 'gateway_groups.agent', '=', 'users.id')
		->join('role_user', 'role_user.user_id', '=', 'users.id')
		->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
		->where('role_user.role_id', 2)
		->where('gateway_groups.agent', $agentid)
		->where('users.status', 1)
		->select('gateway_groups.*', 'gateway_groups.group_id','users.fname','sensor_groups.name')
		->orderBy('added_on', 'DESC')
		->get();
		return view('agent.sensor.sensoredit')->with([
			'types'=>$types,
			'brands'=>$brands,
			'hub_id'=>$id,
			'units'=>$units,
			'group'=>$group,
			'user'=>$user, 
			'groupname'=>$groupname, 
			'grouplists'=>$grouplists,
			'hubname'=>$hubname,
			'hublists'=>$hublists,
			'user'=>$user,
			'groupnames'=>$groupnames,
			'typname'=>$typname
		]);
	}
	public function algorithm()
    {
		$users = DB::table('algorithm')
		->join('users', 'algorithm.userid', '=', 'users.id')
		->join('algorithm_sensor', 'algorithm_sensor.algorithm_id', '=', 'algorithm.id')
		->join('gateway_groups', 'gateway_groups.id', '=', 'algorithm_sensor.groupid')
		->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
		->join('sensor_hubs', 'sensor_hubs.id', '=', 'algorithm_sensor.hub') 
		//->join('hubs', 'hubs.id', '=', 'sensor_hubs.hub_id')
		->join('sensors', 'sensors.id', '=', 'algorithm_sensor.sensor')
		->where('algorithm.userid', session()->get('userid'))
		//->orderBY('algorithm', 'asc')
		->groupBy('algorithm_sensor.algorithm_id')
		->select('algorithm.id as algorithmid', 'algorithm.name as algorithmname', 'sensor_groups.name as groupname', 'sensor_hubs.hub_id as hubname', 'sensors.sensor_id')
        ->paginate(10);
		return view('agent.algorithms.index')->with(['users'=>$users]);
    }
    public function editalgorithm($id=0)
    {
		$agents = DB::table('users')
        ->join('role_user', 'role_user.user_id', '=', 'users.id')
		->where('role_user.role_id', 2)
		->get();
		$alg = DB::select('select * from algorithm where id='.$id);
		$details = DB::select('select * from algorithm_sensor where algorithm_id='.$id);
		$groups = DB::table('sensor_groups')
        ->join('gateway_groups', 'gateway_groups.sensor_group_id', '=', 'sensor_groups.id')
		->where('gateway_groups.agent', session()->get('userid'))
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
    		->where('sensor_hubs.id', $item->hub)
    		->select('sensors.*')
    		->get();
		}
		return view('agent.algorithms.edit')->with(['agents'=>$agents,'groups'=>$groups,'hubs'=>$hubs,'sensors'=>$sensors,'alg'=>$alg,'details'=>$details]);
    }
}
