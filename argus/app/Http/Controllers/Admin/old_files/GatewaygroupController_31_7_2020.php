<?php
 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Hash;
//use App\Group;
use DB;

class GatewaygroupController extends Controller
{
    public function index()
    {
		$groups = DB::table('gateway_groups')
		->join('users', 'gateway_groups.agent', '=', 'users.id')
		->join('role_user', 'role_user.user_id', '=', 'users.id')
		->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
		->where('role_user.role_id', 2)
		->where('users.status', 1)
		->select('gateway_groups.*', 'gateway_groups.group_id','users.fname','sensor_groups.name')
		->orderBy('added_on', 'DESC')
        ->paginate(10);
        return view('admin.gatewaygroup.index')->with(['groups'=>$groups]);
	}
	######Gateway Groups##########
	public function addGatewaygroup()
	{
		$agents = DB::table('users')
					->join('role_user', 'role_user.user_id', '=', 'users.id')
					->where('role_user.role_id', 2)
					->where('users.status', 1)
					->get();
		$groups = DB::table('sensor_groups')
                ->get();
		$group_id=$this->generateId();
		return view('admin.gatewaygroup.create')->with(['groups'=>$groups,'agents'=>$agents,'group_id'=>$group_id]);
	}
	public function insertGatewaygroup(Request $request)
	{
		$group = $request->input('group');
		$agent = $request->input('agent');
		$sensor_group_id = $request->input('sensor_group_id');
		$sim_no = $request->input('sim_no');
		$router_sensor_no = $request->input('router_sensor_no');
		$longitude = $request->input('longitude');
		$latitude = $request->input('latitude');
		$sensor_information = $request->input('sensor_information');
		$data=array('group_id'=>$group,'agent'=>$agent,'sensor_group_id'=>$sensor_group_id,'sim_no'=>$sim_no,'router_sensor_no'=>$router_sensor_no,'longitude'=>$longitude,'latitude'=>$latitude,'sensor_information'=>$sensor_information);
		$value=DB::table('gateway_groups')->insertGetId($data);
		if($value)
		{
		    Session::flash('flash_message', 'Record inserted successfully.');
		}
		else
		{
		    Session::flash('flash_message', 'Error !!!.');
		}
		return redirect()->back();
	}
	// public function editGatewaygroup($id=0)
	// {
	// 	$agents = DB::table('users')
	// 		->join('role_user', 'role_user.user_id', '=', 'users.id')
	// 		->where('role_user.role_id', 2)
	// 		->where('users.status', 1)
	// 		->get();					
	// 	$groups = DB::table('sensor_groups')->get();			
	// 	$gro.up = DB::select('select * from gateway_groups where id='.$id);
	// 	return view('admin.gatewaygroup.edit')->with(['group'=>$group,'agents'=>$agents,'groups'=>$groups]);
	// }
	public function editGatewaygroup($id=0)
	{
		$agents = DB::table('users')
			->join('role_user', 'role_user.user_id', '=', 'users.id')
			->where('role_user.role_id', 2)
			->where('users.status', 1)
			->get();							
		$groups = DB::table('sensor_groups')->get();			
		$group = DB::select('select * from gateway_groups where id='.$id);
		$user = DB::select('select * from users where id='.$group[0]->agent);
		return view('admin.gatewaygroup.edit')->with([
			'group'=>$group,
			'agents'=>$agents,
			'groups'=>$groups,
			'user'=>$user,
		]);
	}
	public function editGatewaygrouptree($id=0)
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
		$hublists = DB::table('dbo_payloader')->groupBy('hub')->get();
		//print_r()
		return view('admin.gatewaygroup.tree')->with([
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
	public function updateGatewaygroup(Request $request)
	{
		$id = $request->input('eid');
		$group = $request->input('group');	
		$agent = $request->input('agent');
		$sensor_group_id = $request->input('sensor_group_id');
		$sim_no = $request->input('sim_no');
		$router_sensor_no = $request->input('router_sensor_no');
		$longitude = $request->input('longitude');
		$latitude = $request->input('latitude');
		$sensor_information = $request->input('sensor_information');				
		$data=array('group_id'=>$group,'agent'=>$agent,'sensor_group_id'=>$sensor_group_id,'sim_no'=>$sim_no,'router_sensor_no'=>$router_sensor_no,'longitude'=>$longitude,'latitude'=>$latitude,'sensor_information'=>$sensor_information);
		$value=DB::table('gateway_groups')->where('id', $id)->update($data);
		return redirect()->back()->with('flash_message','Record updated successfully.');
	}
	
	public function deleteGatewaygroup($id=0)
	{
		if($id != 0)
		{
			DB::table('gateway_groups')->where('id', '=', $id)->delete();
			DB::table('sensor_hubs')->where('group_id', '=', $id)->delete();
			DB::table('sensors')->where('group_id', '=', $id)->delete();
			Session::flash('flash_message','Delete successfully.');
			return redirect()->back();   
    	}
    	return redirect()->back();
    }
	public function deleteGatewaygroups($id=0)
	{
		$list = explode(',', $id);
		foreach($list as $lists)
		{
			DB::table('gateway_groups')->where('id', '=', $lists)->delete();
			DB::table('sensor_hubs')->where('group_id', '=', $lists)->delete();
			DB::table('sensors')->where('group_id', '=', $lists)->delete();
			echo 'Delete successfully';
		}
    }
	public function generateId()
	{
	$affected = DB::select("select * FROM gateway_groups");
	if(count($affected)==0)
	{
	$n=1;
	}
	else
	{
	$groups = DB::table('gateway_groups')->max('id');
	$grp=DB::select("select group_id FROM gateway_groups where id=".$groups);
	$str=substr($grp[0]->group_id,2,strlen($grp[0]->group_id));
	(int)$str++;
	$n=$str;
	}
	$num_of_ids = 10000; //Number of "ids" to generate.
	$i = 0; //Loop counter.
	
	$l = "GW"; //"id" letter piece.
	
	//while ($i <= $num_of_ids) { 
	$id = $l . sprintf("%04d", $n); //Create "id". Sprintf pads the number to make it 4 digits.
	return $id;
	}
	
	######Gateway Groups##########
	
	
}
