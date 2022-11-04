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

class SensorhubController extends Controller
{
    public function index()
    {
        //echo "test";die();

        //Fetching for sensor hubs
		$hubs = DB::table('sensor_hubs')
		->join('users', 'sensor_hubs.agent', '=', 'users.id')
		->join('role_user', 'role_user.user_id', '=', 'users.id')
		->join('sensor_groups', 'sensor_groups.id', '=', 'sensor_hubs.sensor_group_id')
		->join('hubs', 'hubs.id', '=', 'sensor_hubs.hub_id')
		->where('role_user.role_id', 2)
		->where('users.status', 1)
		->select('sensor_hubs.*', 'sensor_hubs.sensor_hub_id','users.fname','sensor_groups.name as groupname','hubs.name')
        ->paginate(10);
		//print_r($groups);
        return view('admin.sensorhub.index')->with(['hubs'=>$hubs]);
    }
	######Gateway Groups##########
	public function addSensorhub()
	{

		//Adding sensor hubs
		$agents = DB::table('users')
					->join('role_user', 'role_user.user_id', '=', 'users.id')
					->where('role_user.role_id', 2)
					->where('users.status', 1)
					->get();
		$groups = DB::table('sensor_groups')
                ->get();
		$hubs = DB::table('hubs')
                ->get();
		$hub_id=$this->generateId();
		return view('admin.sensorhub.create')->with(['groups'=>$groups,'agents'=>$agents,'hub_id'=>$hub_id,'hubs'=>$hubs]);
	}
	public function insertSensorhub(Request $request)
	{
		echo "test123";die();
		// $hub_id = $request->input('hubid');
		// $hub = $request->input('hub');
		// $agent = $request->input('agent');
		// $sensor_group_id = $request->input('group');
		// $mac_id = $request->input('mac');
		// $hub_inform = $request->input('inform');
		// $groupid = $request->input('group_id');
		// $data=array('sensor_hub_id'=>$hub_id,'agent'=>$agent, 'group_id' => $groupid, 'sensor_group_id'=>$sensor_group_id,'hub_id'=>$hub,'mac_id'=>$mac_id,'hub_inform'=>$hub_inform);
		// //$hubcnt = DB::table('sensor_hubs')->where('hub_id', $hub)->where('agent', $agent)->get();
		// $hubcnt = DB::table('sensor_hubs')->where('hub_id', $hub_id)->where('group_id', $groupid)->get();
		// if(count($hubcnt) == '0')
		// {
    	// 	$value=DB::table('sensor_hubs')->insertGetId($data);
    	// 	if($value)
    	// 	{
    	// 	//echo "Record inserted successfully.<br/>";
    	// 	    Session::flash('flash_message', 'Record inserted successfully.');
    	// 	}
    	// 	else
    	// 	{
    	// 	    Session::flash('flash_message', 'Error !!!.');
    	// 	//echo '<a href = "/insert">Click Here</a> to go back.';
    	// 	}
		// }
		// else
		// {
		//     Session::flash('flash_message', 'SensorHub Name Already Exists!');
		// }
		// return redirect()->back();
	}
	/*public function editSensorhub($id=0)
	{
		$agents = DB::table('users')
					->join('role_user', 'role_user.user_id', '=', 'users.id')
					->where('role_user.role_id', 2)
					->where('users.status', 1)
					->get();
		$groups = DB::table('sensor_groups')
                ->get();
		$hubs = DB::table('hubs')
                ->get();
				
		$group = DB::select('select * from sensor_hubs where id='.$id);
		//print_r($group);exit;
		return view('admin.sensorhub.edit')->with(['group'=>$group,'agents'=>$agents,'groups'=>$groups,'hubs'=>$hubs]);
	}
	public function updateSensorhub(Request $request){
		$hub_id = $request->input('hubid');
		$hub = $request->input('hub');
		$id = $request->input('eid');
		$agent = $request->input('agent');
		$sensor_group_id = $request->input('group');
		$mac_id = $request->input('mac');
		$hub_inform = $request->input('inform');
		
		$data=array('sensor_hub_id'=>$hub_id,'agent'=>$agent,'sensor_group_id'=>$sensor_group_id,'hub_id'=>$hub,'mac_id'=>$mac_id,'hub_inform'=>$hub_inform);
		$value=DB::table('sensor_hubs')
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
		return redirect('admin/sensorhubs');
	}*/
	public function editSensorhub($id=0)
	{			


		//Editing sensor hubs
		$hubs = DB::table('hubs')->get();		
		$group = DB::select('select * from sensor_hubs where id='.$id);
		$hubname = DB::table('hubs')->where('id', $group[0]->hub_id)->get();
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
		$hublists = DB::table('hubs')->get();
		$types = DB::table('types')->get();
		$brands = DB::table('brands')->get();
		$units = DB::table('measurement_units')
				->join('units', 'measurement_units.unit', '=', 'units.id')
				->select('measurement_units.*', 'units.name')
				->get();
		$groupnames = DB::table('sensor_groups')->get();
		return view('admin.sensorhub.edit')->with([
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
	public function updateSensorhub(Request $request)
	{

		//Updating sensor hubs
		//$hub_id = $request->input('hubid');
		$hub = $request->input('hub');
		$id = $request->input('eid');
		//$agent = $request->input('agent');
		//$sensor_group_id = $request->input('group');
		$mac_id = $request->input('mac');
		$hub_inform = $request->input('inform');
		
		$data=array('hub_id'=>$hub,'mac_id'=>$mac_id,'hub_inform'=>$hub_inform);
		$value=DB::table('sensor_hubs')
            ->where('id', $id)
            ->update($data);
		return redirect()->back()->with('flash_message','Record updated successfully.');
	}
	public function deleteSensorhub($id=0)
	{

		//Deleting sensor hubs
        if($id != 0)
		{
			DB::table('sensor_hubs')->where('id', '=', $id)->delete();
			DB::table('sensors')->where('hub_id', '=', $id)->delete();
			Session::flash('flash_message','Delete successfully.');		
		}
		return redirect()->back();
    }
	public function deleteSensorhubs($id=0)
	{

		//deleting sensor hubs
		$list = explode(',', $id);
		foreach($list as $lists)
		{
			DB::table('sensor_hubs')->where('id', '=', $lists)->delete();
			DB::table('sensors')->where('hub_id', '=', $lists)->delete();
			Session::flash('flash_message','Delete successfully.');		
		}
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
	
	######Gateway Groups##########
	
	
    



}
