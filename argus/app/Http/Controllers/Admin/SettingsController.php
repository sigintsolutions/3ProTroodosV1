<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Session;
//use App\Group;
use DB;

class SettingsController extends Controller
{
    /*public function index()
    {
        //abort_unless(\Gate::allows('product_access'), 403);

        //$groups = Group::all();
		
		$groups = DB::select('select * from sensor_groups');
		$hubs = DB::select('select * from hubs');
		$types = DB::select('select * from types');
		$brands = DB::select('select * from brands');
		$units = DB::select('select * from units');
		$measureunits = DB::select('select measurement_units.*,types.name as types,units.name as units from measurement_units inner join types on measurement_units.type=types.id inner join units on measurement_units.unit=units.id');

        return view('admin.sensorgroups.index')->with(['groups'=>$groups,'hubs'=>$hubs,'types'=>$types,'brands'=>$brands,'units'=>$units,'measureunits'=>$measureunits]);
    }*/
    public function index()
    {
        $groups = DB::select('select * from sensor_groups order by created_at desc');
		$hubs = DB::select('select * from hubs order by created_at desc');
		$types = DB::select('select * from types order by created_at desc');
		$brands = DB::select('select * from brands order by created_at desc');
		//$measureunits = DB::select('select * from measurement_units order by created_at desc');
		$aunit=array();
		$addedunits=DB::table('chart')->get();
		foreach ($addedunits as $au) {
			$aunit[]=$au->unit;
		}
		//dd();
		$measureunits = DB::table('sensordata')->whereNotIn('unit',$aunit)->groupBy('unit')->get();
		//dd($aunit,$measureunits);
		$units = DB::table('chart')->get();
        return view('admin.sensorgroups.index')->with(['groups'=>$groups,'hubs'=>$hubs,'types'=>$types,'brands'=>$brands,'measureunits'=>$measureunits,'units'=>$units]);
    }
	######Sensor Group##########
	public function insertGroup(Request $request)
	{
		$name = $request->input('name');	
		$group = DB::table('sensor_groups')->where('name', $name)->get();
		if(count($group) == '0') 
		{
			$data=array('name'=>$name);
			$value=DB::table('sensor_groups')->insert($data);
			if($value)
			{
				Session::flash('flash_message', 'Record inserted successfully.');
			}
			else
			{
				Session::flash('flash_message', 'Error !!!.');
			}
		}
		else
		{
			Session::flash('flash_message', 'Already Exists');
		}
$groups = DB::table('sensor_groups')->get();
	return view('admin.sensorgroups.sensorgroupsup')->with([
				'groups'   => $groups]);


		//return redirect()->back();
	}
	public function updateGroup(Request $request)
	{
		$name = $request->input('name');
		$group = DB::table('sensor_groups')->where('name', $name)->get();
		if(count($group) == '0') 
		{
			$id = $request->input('eid');
			$data=array('name'=>$name);
			$value=DB::table('sensor_groups')
				->where('id', $id)->update($data);
$groups = DB::table('sensor_groups')->get();
	return view('admin.sensorgroups.sensorgroupsup')->with([
				'groups'   => $groups]);
			//return redirect()->back()->with('flash_message','Record updated successfully.');
		}
		else
		{
			$groups = DB::table('sensor_groups')->get();
	return view('admin.sensorgroups.sensorgroupsup')->with([
				'groups'   => $groups]);
			//echo "Already Exists";
			//return redirect()->back()->with('flash_message','Already Exists');
		}
	}
	public function deleteGroup_old($id=0)
	{
    if($id != 0){
      // Delete
      DB::table('sensor_groups')->where('id', '=', $id)->delete();

      Session::flash('flash_message','Delete successfully.');
      
    }
    return redirect()->back();
    }
	public function deleteGroup($id=0)
	{
		$count=0;
		$getgroupdt = DB::table('gateway_groups')->where('sensor_group_id', $id)->get();
		$count = count($getgroupdt);
		if($count == '0')
		{
			DB::table('sensor_groups')->where('id', '=', $id)->delete();
			echo "del";
		}
		else
		{
			foreach($getgroupdt as $getgroupdtagent)
			{
				$agents = DB::table('users')->where('id', $getgroupdtagent->agent)->get();
				foreach($agents as $agent)
				{
					$s[] = $agent->fname.' '.$agent->lname;
				}
				//print_r($s);
			}
			$agent = implode(',', $s);
			echo "Unable to Delete this Gateway Group. The following group is currently assigned ".$agent;
		}
    }
	public function deleteGroupcnt()
	{
		$cnt = DB::table('sensor_groups')->get();
		$cnt = count($cnt);
		echo $cnt;
    }
public function getsensoreditdetails(){
	$id=$_GET['id'];
	$getgroupdt=DB::table('sensor_groups')->where('id',$id)->first();
	return json_encode($getgroupdt);
}

public function getsensoreditdetailscount(){
	//$id=$_GET['id'];

	//$getgroupdt=DB::table('sensor_groups')->get();
	//return json_encode($getgroupdt);

	$count=0;
$getgroupdt=DB::table('sensor_groups')->get();
echo $count=count($getgroupdt);
}


public function getchartcount(){

$count=0;
$units = DB::table('chart')->get();
$count=count($units);
echo $count;
}
public function getsensoreditdetailstype(){
	$id=$_GET['id'];
	//$getgroupdt=DB::table('sensor_groups')->where('id',$id)->first();
$getgroupdt=DB::table('types')->where('id',$id)->first();
//$getgroupdt = DB::select('select * from types order by created_at desc');
	return json_encode($getgroupdt);
}

public function getsensoreditdetailschart(){
	$id=$_GET['id'];
	//$getgroupdt=DB::table('sensor_groups')->where('id',$id)->first();
$getgroupdt=DB::table('chart')->where('id',$id)->first();
//$getgroupdt = DB::select('select * from types order by created_at desc');
//dd($id,$getgroupdt);
	return json_encode($getgroupdt);
}
public function getsensoreditdetailstypecount(){
	//$id=$_GET['id'];
	//$getgroupdt=DB::table('sensor_groups')->where('id',$id)->first();
	$count=0;
$getgroupdt=DB::table('types')->get();
echo $count=count($getgroupdt);
//$getgroupdt = DB::select('select * from types order by created_at desc');
	//return json_encode($getgroupdt);
}
	######Sensor Group##########
	######Hub##########
	public function insertHub(Request $request)
	{
		$name = $request->input('name');
		$group = DB::table('hubs')->where('name', $name)->get();
		if(count($group) == '0') 
		{
			$data=array('name'=>$name);
			$value=DB::table('hubs')->insert($data);
			if($value)
			{
				Session::flash('flash_message', 'Record inserted successfully.');
			}
			else
			{
				Session::flash('flash_message', 'Error !!!.');
			}
		}
		else
		{
			Session::flash('flash_message', 'Already Exists');
		}
		return redirect()->back();
	}	
	public function updateHub(Request $request)
	{
		$name = $request->input('name');
		$group = DB::table('hubs')->where('name', $name)->get();
		if(count($group) == '0') 
		{
			$id = $request->input('eid');
			$data=array('name'=>$name);
			$value=DB::table('hubs')
				->where('id', $id)
				->update($data);
			return redirect()->back()->with('flash_message','Record updated successfully.');
		}
		else
		{
			return redirect()->back()->with('flash_message','Already Exists');
		}
	}
	public function deleteHub($id=0){

    if($id != 0){
      // Delete
      DB::table('hubs')->where('id', '=', $id)->delete();

      Session::flash('flash_message','Delete successfully.');
      
    }
    return redirect()->back();
    }
	######Hub##########
	
	######Type##########
	public function insertType(Request $request)
	{
		//$name = $request->input('name');
		$brand = $request->input('brand');
		//$unit = $request->input('unit');
		$sname = $request->input('sname');
		$modal = $request->input('modal');
		$min = $request->input('min');
		$max = $request->input('max');
		$remark = $request->input('remark');
		$group = DB::table('types')->where('sname', $sname)->get();
		if(count($group) == '0') 
		{
			$data=array('brand'=>$brand, 'sname'=>$sname, 'modal'=>$modal, 'min'=>$min, 'max'=>$max, 'remark'=>$remark);
			$value=DB::table('types')->insert($data);
			if($value)
			{
				Session::flash('flash_message', 'Record inserted successfully.');
			}
			else
			{
				Session::flash('flash_message', 'Error !!!.');
			}
		}
		else
		{
			Session::flash('flash_message', 'Name Already Exists');
		}

$types = DB::table('types')->get();
	return view('admin.sensorgroups.sensorbrand')->with([
				'types'   => $types]);



		//return redirect()->back();
	}
	public function updateType(Request $request)
	{
		//$name = $request->input('name');
		$brand = $request->input('brand');
		//$unit = $request->input('unit');
		$sname = $request->input('sname');
		$modal = $request->input('modal');
		$min = $request->input('min');
		$max = $request->input('max');
		$remark = $request->input('remark');
		//$group = DB::table('types')->where('name', $name)->get();
		//if(count($group) == '0') 
		//{
			$id = $request->input('eid');
			$data=array('brand'=>$brand, 'sname'=>$sname, 'modal'=>$modal, 'min'=>$min, 'max'=>$max, 'remark'=>$remark);
			$value=DB::table('types')
				->where('id', $id)
				->update($data);

$types = DB::table('types')->get();
	return view('admin.sensorgroups.sensorbrand')->with([
				'types'   => $types]);


				
			//return redirect()->back()->with('flash_message','Record updated successfully.');
		//}
	//	else
// 		{
// 			return redirect()->back()->with('flash_message','Already Exists');
// 		}	
	}
	
	public function deleteType($id=0)
	{
		$count=0;
		$getgroupdt = DB::table('sensors')->where('type', $id)->get();
		$count = count($getgroupdt);
		if($count == '0')
		{
			DB::table('types')->where('id', '=', $id)->delete();
			echo "del";
		}
		else
		{
			foreach($getgroupdt as $getgroupdtagent)
			{
				//echo $getgroupdtagent->hub_id;
				$groups = DB::table('sensor_hubs')
					->join('gateway_groups', 'gateway_groups.id', '=', 'sensor_hubs.group_id')
					->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
					->join('users', 'gateway_groups.agent', '=', 'users.id')
					->where('sensor_hubs.id', $getgroupdtagent->hub_id)
					->select('users.fname', 'users.lname', 'sensor_hubs.hub_id', 'sensor_groups.name')
					->get();
				//print_r($groups);die();
				foreach($groups as $agent)
				{
					$s[] = $agent->fname.' '.$agent->lname.' / '.$agent->name.' / '.$agent->hub_id;
				}
				//print_r($s);
			}
			$agent = implode(',', $s);
			echo "Unable to Delete this Sensor Type. The following type is currently assigned ".$agent;
		}
	}
	public function deleteTypecnt()
	{
		$cnt = DB::table('types')->get();
		$cnt = count($cnt);
		echo $cnt;
    }
	######Type##########
	
	######Brand##########
	public function insertBrand(Request $request)
	{
		$name = $request->input('name');
		$group = DB::table('brands')->where('name', $name)->get();
		if(count($group) == '0') 
		{
			$data=array('name'=>$name);
			$value=DB::table('brands')->insert($data);
			if($value)
			{
				Session::flash('flash_message', 'Record inserted successfully.');
			}
			else
			{
				Session::flash('flash_message', 'Error !!!.');
			}
		}
		else
		{
			Session::flash('flash_message', 'Already Exists');
		}
		return redirect()->back();
	}
	public function updateBrand(Request $request)
	{
		$name = $request->input('name');
		$group = DB::table('brands')->where('name', $name)->get();
		if(count($group) == '0') 
		{
			$id = $request->input('eid');
			$data=array('name'=>$name);
			$value=DB::table('brands')
				->where('id', $id)
				->update($data);	
			return redirect()->back()->with('flash_message','Record updated successfully.');
		}
		else
		{
			return redirect()->back()->with('flash_message','Already Exists');
		}
	}
	
	public function deleteBrand($id=0){

    if($id != 0){
      // Delete
      DB::table('brands')->where('id', '=', $id)->delete();

      Session::flash('flash_message','Delete successfully.');
      
    }
    return redirect()->back();
    }
	######Brand##########
	
	
	######Unit##########
	public function insertUnit(Request $request){
		$name = $request->input('name');
		
		$data=array('name'=>$name);
		$value=DB::table('units')->insert($data);
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
		return redirect()->back();
	}
	
	public function updateUnit(Request $request){
		$name = $request->input('name');
		$id = $request->input('eid');
		$data=array('name'=>$name);
		$value=DB::table('units')
            ->where('id', $id)
            ->update($data);
		if($value)
		{
		//echo "Record inserted successfully.<br/>";
		Session::flash('flash_message', 'Record updated successfully.');
		}
		else
		{
		Session::flash('flash_message', 'Error !!!.');
		//echo '<a href = "/insert">Click Here</a> to go back.';
		}
		return redirect()->back();
	}
	
	public function deleteUnit($id=0){

    if($id != 0){
      // Delete
      DB::table('units')->where('id', '=', $id)->delete();

      Session::flash('flash_message','Delete successfully.');
      
    }
    return redirect()->back();
    }
	######Unit##########
	
	
	######Measure Unit##########
	public function insertMeasureUnit(Request $request)
	{
		$min = $request->input('min');
		$max = $request->input('max');
		$unit = $request->input('unit');
		$data=array('minimum'=>$min,'maximum'=>$max,'unit'=>$unit);
		$value=DB::table('measurement_units')->insert($data);
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
		return redirect()->back();
	}
	public function updateMeasureUnit(Request $request)
	{
		$min = $request->input('min');
		$max = $request->input('max');
		$unit = $request->input('unit');
		$id = $request->input('eid');
		$data=array('minimum'=>$min,'maximum'=>$max,'unit'=>$unit);
		$value=DB::table('measurement_units')
            ->where('id', $id)
            ->update($data);
		return redirect()->back()->with('flash_message','Record updated successfully.');
	}
	public function deleteMeasureUnit($id=0){

    if($id != 0){
      // Delete
      DB::table('measurement_units')->where('id', '=', $id)->delete();

      Session::flash('flash_message','Delete successfully.');
      
    }
    return redirect()->back();
    }
	######Measure Unit##########
	
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
