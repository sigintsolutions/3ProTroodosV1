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
   
    public function index()
    {

    	//Fetching sensor groups,hubs,types etc
        $groups = DB::select('select * from sensor_groups order by created_at desc');
		$hubs = DB::select('select * from hubs order by created_at desc');
		$types = DB::select('select * from types order by created_at desc');
		$brands = DB::select('select * from brands order by created_at desc');
		$measureunits = DB::select('select * from measurement_units order by created_at desc');
        return view('admin.sensorgroups.index')->with(['groups'=>$groups,'hubs'=>$hubs,'types'=>$types,'brands'=>$brands,'measureunits'=>$measureunits]);
    }
	######Sensor Group##########
	public function insertGroup(Request $request)
	{
		//Adding sensor groups
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
		return redirect()->back();
	}
	public function updateGroup(Request $request)
	{
		//Updating sensor groups
		$name = $request->input('name');
		$group = DB::table('sensor_groups')->where('name', $name)->get();
		if(count($group) == '0') 
		{
			$id = $request->input('eid');
			$data=array('name'=>$name);
			$value=DB::table('sensor_groups')
				->where('id', $id)
				->update($data);
			return redirect()->back()->with('flash_message','Record updated successfully.');
		}
		else
		{
			return redirect()->back()->with('flash_message','Already Exists');
		}
	}
	public function deleteGroup($id=0){

//Deleting sensor groups
    if($id != 0){
      // Delete
      DB::table('sensor_groups')->where('id', '=', $id)->delete();

      Session::flash('flash_message','Delete successfully.');
      
    }
    return redirect()->back();
    }
	######Sensor Group##########
	######Hub##########
	public function insertHub(Request $request)
	{

		//Adding Hub
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

		//Updating Hub
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


//Deleting Hub

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

//Adding Type

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
		return redirect()->back();
	}
	public function updateType(Request $request)
	{

//Updating type

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
			return redirect()->back()->with('flash_message','Record updated successfully.');
		
	}
	
	public function deleteType($id=0){

//deleting type

    if($id != 0){
      // Delete
      DB::table('types')->where('id', '=', $id)->delete();

      Session::flash('flash_message','Delete successfully.');
      
    }
    return redirect()->back();
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

		//Adding unit
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

//Updating unit

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


//deleting unit
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

		//Adding measure unit
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

		//updating measurement unit
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
	
   



}
