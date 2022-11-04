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

class GatewaygroupController extends Controller
{
    public function index()
    {
        //abort_unless(\Gate::allows('product_access'), 403);

        //$groups = Group::all();
		
		//$agents = DB::select('select * from users inner join role_user on users.id=role_user.user_id where role_user.role_id=1');
		$groups = DB::table('gateway_groups')
		->join('users', 'gateway_groups.agent', '=', 'users.id')
		->join('role_user', 'role_user.user_id', '=', 'users.id')
		->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
		->where('role_user.role_id', 2)
		->where('users.status', 1)
		->select('gateway_groups.*', 'gateway_groups.group_id','users.fname','sensor_groups.name')
        ->paginate(10);
		//print_r($groups);
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
	public function insertGatewaygroup(Request $request){
		
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
	/*public function editGatewaygroup($id=0)
	{
		$agents = DB::table('users')
					->join('role_user', 'role_user.user_id', '=', 'users.id')
					->where('role_user.role_id', 2)
					->where('users.status', 1)
					->get();
					
		$groups = DB::table('sensor_groups')
                ->get();
				
		$group = DB::select('select * from gateway_groups where id='.$id);
		//print_r($group);exit;
		return view('admin.gatewaygroup.edit')->with(['group'=>$group,'agents'=>$agents,'groups'=>$groups]);
	}*/
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
		return view('admin.gatewaygroup.edit')->with([
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
		/*$id = $request->input('eid');
		$group = $request->input('group');
		$agent = $request->input('agent');
		$sensor_group_id = $request->input('sensor_group_id');
		$sim_no = $request->input('sim_no');
		$router_sensor_no = $request->input('router_sensor_no');
		$longitude = $request->input('longitude');
		$latitude = $request->input('latitude');
		$sensor_information = $request->input('sensor_information');
		$data=array('group_id'=>$group,'agent'=>$agent,'sensor_group_id'=>$sensor_group_id,'sim_no'=>$sim_no,'router_sensor_no'=>$router_sensor_no,'longitude'=>$longitude,'latitude'=>$latitude,'sensor_information'=>$sensor_information);
		$value=DB::table('gateway_groups')
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
		return redirect()->back();*/
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
			Session::flash('flash_message','Delete successfully.');
		}
		return redirect()->back();
    }
	public function deleteGatewaygroups($id=0)
	{
		$list = explode(',', $id);
		print_r($list);die();
		foreach($list as $lists)
		{
			DB::table('gateway_groups')->where('id', '=', $lists)->delete();
			DB::table('sensor_hubs')->where('group_id', '=', $lists)->delete();
			Session::flash('flash_message','Delete successfully.');			
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
