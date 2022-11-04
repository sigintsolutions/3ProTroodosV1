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

class SensorhubController extends Controller
{
    public function index()
    {
        //echo "test";die();
		$hubs = DB::table('sensor_hubs')
		->join('users', 'sensor_hubs.agent', '=', 'users.id')
		->join('role_user', 'role_user.user_id', '=', 'users.id')
		->join('sensor_groups', 'sensor_groups.id', '=', 'sensor_hubs.sensor_group_id')
		->join('hubs', 'hubs.id', '=', 'sensor_hubs.hub_id')
		->where('role_user.role_id', 2)
		->where('users.status', 1)
		->select('sensor_hubs.*', 'sensor_hubs.sensor_hub_id','users.fname','sensor_groups.name as groupname','hubs.name','hubs.id as hid')
		->orderBy('added_on', 'DESC')
        ->paginate(10);
		//print_r($groups);
        return view('admin.sensorhub.index')->with(['hubs'=>$hubs]);
    }
	######Gateway Groups##########
	public function addSensorhub()
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
		$hub_id=$this->generateId();
		return view('admin.sensorhub.create')->with(['groups'=>$groups,'agents'=>$agents,'hub_id'=>$hub_id,'hubs'=>$hubs]);
	}
	public function insertSensorhub(Request $request)
	{
		$hub_id = $request->input('hubid');
		$hub = $request->input('hub');
		$agent = $request->input('agent');
		$sensor_group_id = $request->input('group');
		$mac_id = $request->input('mac');
		$hub_inform = $request->input('inform');
		$groupid = $request->input('group_id');
		$data=array('sensor_hub_id'=>$hub_id,'agent'=>$agent, 'group_id' => $groupid, 'sensor_group_id'=>$sensor_group_id,'hub_id'=>$hub,'mac_id'=>$mac_id,'hub_inform'=>$hub_inform);
		$value=DB::table('sensor_hubs')->insertGetId($data);
		//echo $value;die();
		if($value)
		{
			$sql = DB::table('sensor_hubs')->where('hub_id', $hub)->groupBy('agent')->select('agent')->get();
			foreach($sql as $fetch)
			{
				$s[] = $fetch->agent;
			}
			$sval = implode(',', $s);
			$data = array('agent' => $sval);
			/*$value = DB::table('dbo_payloader')
			->where('hub', $hub)
			->update($data);*/
			$sql1 = DB::table('sensor_hubs')->where('hub_id', $hub)->groupBy('group_id')->select('group_id')->get();
			foreach($sql1 as $fetch1)
			{
				$s1[] = $fetch1->group_id;
			}
			$sval1 = implode(',', $s1);
			$data1 = array('group_id' => $sval1);
			/*$value = DB::table('dbo_payloader')
			->where('hub', $hub)
			->update($data1);*/
			Session::flash('flash_message', 'Record inserted successfully.');
			return redirect()->back();
		}
	}
	public function insertsensorhubalert(Request $request)
	{
		$hub_id = $request->input('hubid');
		$hub = $request->input('hub');
		$agent = $request->input('agent');
		$sensor_group_id = $request->input('group');
		$mac_id = $request->input('mac');
		$hub_inform = $request->input('inform');
		$groupid = $request->input('group_id');
		$data=array('sensor_hub_id'=>$hub_id,'agent'=>$agent, 'group_id' => $groupid, 'sensor_group_id'=>$sensor_group_id,'hub_id'=>$hub,'mac_id'=>$mac_id,'hub_inform'=>$hub_inform);
		$hubcnt = DB::table('sensor_hubs')->where('hub_id', $hub)->where('group_id', $groupid)->get();
		$value=DB::table('sensor_hubs')->insertGetId($data);
		if($value)
		{
			echo "suc";
		}
	}
	public function editSensorhub($id=0)
	{			
		//$hubs = DB::table('dbo_payloader')->groupBy('hub')->get();	
		$hubdata = DB::table('hubdata')->first();
		$hubs = explode(',', $hubdata->hub);
		$group = DB::select('select * from sensor_hubs where id='.$id);
		//$hubname = DB::table('hubs')->where('id', $group[0]->hub_id)->get();
		$agents = DB::table('users')
		->join('role_user', 'role_user.user_id', '=', 'users.id')
		->where('role_user.role_id', 2)
		->where('users.status', 1)
		->where('users.id', $group[0]->agent)
		->get();
		$user = DB::select('select * from users where id='.$group[0]->agent);
		$groups = DB::table('sensor_groups')->where('id', $group[0]->sensor_group_id)->get();
		return view('admin.sensorhub.edit')->with([
			'group'=>$group,
			'agents'=>$agents,
			'groups'=>$groups,
			'user'=>$user,
			'hubs'=>$hubs,
		]);
	}
	public function editSensorhubtree($id=0)
	{			
		$hubs = DB::table('dbo_payloader')->groupBy('hub')->get();	
		$group = DB::select('select * from sensor_hubs where id='.$id);
		//$hubname = DB::table('hubs')->where('id', $group[0]->hub_id)->get();
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
		$hublists = DB::table('dbo_payloader')->groupBy('hub')->get();
		$types = DB::table('types')->get();
		$brands = DB::table('brands')->get();
		$units = DB::table('measurement_units')
				->join('units', 'measurement_units.unit', '=', 'units.id')
				->select('measurement_units.*', 'units.name')
				->get();
		$groupnames = DB::table('sensor_groups')->get();
		return view('admin.sensorhub.tree')->with([
			'group'=>$group,
			'agents'=>$agents,
			'groups'=>$groups,
			'grouplists'=>$grouplists,
			'user'=>$user,
			'hubs'=>$hubs,
			'hubname' => $group[0]->hub_id,
			'hublists'=>$hublists,
			'types'=>$types,
			'brands'=>$brands,
			'units'=>$units,
			'groupnames'=>$groupnames
		]);
	}
	public function updateSensorhub(Request $request)
	{
		//$hub_id = $request->input('hubid');
		$hub = $request->input('hub');
		$id = $request->input('eid');
		//$agent = $request->input('agent');
		//$sensor_group_id = $request->input('group');
		$mac_id = $request->input('mac');
		$hub_inform = $request->input('inform');
		
		$data=array('hub_id'=>$hub,'mac_id'=>$mac_id,'hub_inform'=>$hub_inform);
		//print_r($data);die();
		$value=DB::table('sensor_hubs')
            ->where('id', $id)
			->update($data);
			//echo $value;die();
		if($value)
		{
			//echo $hub;die();
			$sql = DB::table('sensor_hubs')->where('hub_id', $hub)->groupBy('agent')->select('agent')->get();
			foreach($sql as $fetch)
			{
				$s[] = $fetch->agent;
			}
			$sval = implode(',', $s);
			$data = array('agent' => $sval);
			$value = DB::table('dbo_payloader')
			->where('hub', $hub)
			->update($data);
			$sql1 = DB::table('sensor_hubs')->where('hub_id', $hub)->groupBy('group_id')->select('group_id')->get();
			foreach($sql1 as $fetch1)
			{
				$s1[] = $fetch1->group_id;
			}
			$sval1 = implode(',', $s1);
			$data1 = array('group_id' => $sval1);
			$value = DB::table('dbo_payloader')
			->where('hub', $hub)
			->update($data1);
		}
		return redirect()->back()->with('flash_message','Record updated successfully.');
	}
	
	public function deleteSensorhub($id=0)
	{

		if($id != 0)
		{
			// Delete
			DB::table('sensor_hubs')->where('id', '=', $id)->delete();
			Session::flash('flash_message','Delete successfully.');
			return redirect()->back();
		}
		Session::flash('flash_message','Delete successfully.');
		return redirect()->back();
    }
	public function deleteSensorhubs($id=0)
	{
		$list = explode(',', $id);
		foreach($list as $lists)
		{
			DB::table('sensor_hubs')->where('id', '=', $lists)->delete();
			DB::table('sensors')->where('hub_id', '=', $lists)->delete();
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
