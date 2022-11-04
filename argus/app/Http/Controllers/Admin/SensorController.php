<?php
 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Session;
use Hash;
//use App\Group;
use DB;

class SensorController extends Controller
{
    public function index()
    {
        //Fetching from sensors
		$sensors = DB::table('sensors')
		->orderBy('created_at', 'DESC')
        ->paginate(10);
		//print_r($groups);
        return view('admin.sensor.index')->with(['sensors'=>$sensors,'hubid'=>$id]);
    }
	public function showSensor($id="")
    {
        //Fetching from sensors
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
		$units = DB::table('measurement_units')->get();
		return view('admin.sensor.create')->with(['types'=>$types,'brands'=>$brands,'hub_id'=>$id,'units'=>$units]);
	}
	public function insertSensor(Request $request)
	{

		//Adding in sensor table
		$hub_id = $request->input('hub_id');
		$sensor_id = $request->input('sensor_id');	
		$type = $request->input('type');
		$sensor_type = $request->input('typedata');
		$unit = $request->input('unitdata');
		$value = $request->input('valuedata');
		$sensor_inform = $request->input('inform');	
		
		$sensorlist = DB::table('sensors')
				->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
				->where('sensor_hubs.id', '=', $hub_id)
				->where('sensors.sensor_id', '=', $sensor_id)
				->where('sensor_hubs.agent', '=', $request->input('agentdrop'))
				->get();
		if(count($sensorlist) == '0')
		{
			$data=array('hub_id'=>$hub_id,'sensor_id'=>$sensor_id,'type'=>$type,'sensor_inform'=>$sensor_inform,'sensor_type'=>$sensor_type,'unit'=>$unit,'value'=>$value,'agent'=> $request->input('agentdrop'),'group_id'=>  $request->input('groupdrop'),'sensor_group_id'=>  $request->input('sensorgroupdrop'));
			$value=DB::table('sensors')->insertGetId($data);
			if($value)
			{
				Session::flash('flash_message', 'Record inserted successfully.');
				return redirect()->back();
			}
		}	
		else
		{
			Session::flash('flash_message', 'Already Exists.');
			return redirect()->back();
		}	
	}
	public function editSensor($id='',$hid='')
	{	


		//Edit Sensor
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
		$hubname = DB::select('select * from sensor_hubs where hub_id = "'.$hub[0]->hub_id.'"');
		/*sumi code*/
		$hubid=$hub[0]->hub_id;
		$data = DB::table('sensordata')->where('hub', $hubid)->groupBy('sensor_id')->get();
		

		$user = DB::select('select * from users where id='.$agentid);
		$hublists = DB::table('hubs')->get();
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
		return view('admin.sensor.edit')->with([
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
			'typname'=>$typname,
			'data'=>$data,
		]);
	}
	public function updateSensor(Request $request)
	{

		//Update Sensor
		$id = $request->input('eid');	
		$hub_id = $request->input('hub_id');
		$sensor_id = $request->input('sensor_id');
		$type = $request->input('type');
		$sensor_type = $request->input('typedata');
		$unit = $request->input('unitdata');
		$value = $request->input('valuedata');
		$sensor_inform = $request->input('inform');
		$data=array('hub_id'=>$hub_id,'sensor_id'=>$sensor_id,'type'=>$type,'sensor_inform'=>$sensor_inform,'sensor_type'=>$sensor_type,'unit'=>$unit,'value'=>$value);
		$value=DB::table('sensors')
            ->where('id', $id)
            ->update($data);
		return redirect()->back()->with('flash_message','Record updated successfully.');
	}
	public function deleteSensor($id=0)
	{

		//delete sensor
        if($id != 0)
        {
          // Delete
            DB::table('sensors')->where('id', '=', $id)->delete();
            DB::table('sensor_graph')->where('sensor_id', '=', $id)->delete();
            Session::flash('flash_message','Delete successfully.');
            return redirect()->back();
        }
        Session::flash('flash_message','Delete successfully.');
		return redirect()->back();
    }
	public function deleteSensors($id=0)
	{

		//delete sensors more than one
		$list = explode(',', $id);
		foreach($list as $lists)
		{
			DB::table('sensors')->where('id', '=', $lists)->delete();
			echo 'Delete successfully.';
            //return redirect()->back();
		}
		// Session::flash('flash_message','Delete successfully.');
		// return redirect()->back();
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
