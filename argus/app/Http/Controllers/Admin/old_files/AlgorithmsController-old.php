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
//	public function getGroup(Request $request){
//		$agent = $request->input('agent');
//		$group = $request->input('group');
//		$groups = DB::table('sensor_groups')
//        ->join('gateway_groups', 'gateway_groups.sensor_group_id', '=', 'sensor_groups.id')
//		->where('gateway_groups.agent', $agent)
//		->select('sensor_groups.*')
//		->get();
//		//print_r($groups);exit;
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
//	}

	public function getGroup(Request $request){
		$agent = $request->input('agent');
		$group = $request->input('group');
		$check = $request->input('check');
		$groups = DB::table('sensor_groups')
        ->join('gateway_groups', 'gateway_groups.sensor_group_id', '=', 'sensor_groups.id')
		->where('gateway_groups.agent', $agent)
		->select('sensor_groups.*')
		->get();
		//print_r($groups);exit;
		$list='';
		$list.= "<option value=''>Select</option>";
		foreach($groups as $item)
		{
		if($group==$item->id)
		{
		$list.= "<option value='".$item->id."' selected>".$item->name."</option>";
		}
		else
		{
		$list.= "<option value='".$item->id."'>".$item->name."</option>";
		}
		}
		return $list;
	}

	
	public function getChart(Request $request){
		DB::enableQueryLog();
		$previous_week = strtotime("-1 week +1 day");
		$start_week = strtotime("last sunday midnight",$previous_week);
		$end_week = strtotime("next saturday",$start_week);
		$start_week = date("Y-m-d",$start_week);
		$end_week = date("Y-m-d",$end_week);	
		$sensor = $request->input('sensor');
		//$date=DB::raw("select DATE(espdata.RecordedDate) as date from")
		$groups = DB::table('sensors')
        ->join('espdata', 'espdata.MAC', '=', 'sensors.sensor_id')
		//->whereRaw('unit ="V"')
		->whereRaw('espdata.MAC like "'.$sensor.'"')
		->whereRaw('espdata.RecordedDate between "'.$start_week.'" and "'.$end_week.'"')
		->select(array('espdata.*',\DB::raw("DATE(espdata.RecordedDate) as date")))
		->groupBy('date')
		->get();
		//$query = DB::getQueryLog();
		//print_r($query);exit;
		$group=array();
		foreach($groups as $item)
		{
		$timestemp = $item->RecordedDate;;

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
	
//	public function getHub(Request $request){
//	//DB::enableQueryLog();
//		$group = $request->input('group');
//		$agent = $request->input('agent');
//		$hubs = DB::table('sensor_hubs')
//        ->join('hubs', 'sensor_hubs.hub_id', '=', 'hubs.id')
//		->where('sensor_hubs.sensor_group_id', $group)
//		->where('sensor_hubs.agent', $agent)
//		->select('hubs.name','hubs.id as hid','sensor_hubs.*')
//		->get();
//		//print_r($groups);exit;
//		//dd(DB::getQueryLog());
//		echo "<option value=''>Select</option>";
//		foreach($hubs as $item)
//		{
//		echo "<option value='".$item->hid."'>".$item->name."</option>";
//		}
//	}

	public function getHub(Request $request){
		//DB::enableQueryLog();
		$group = $request->input('group');
		$agent = $request->input('agent');
		if(!is_array($group))
		{
		$hubs = DB::table('sensor_hubs')
        ->join('hubs', 'sensor_hubs.hub_id', '=', 'hubs.id')
		->where('sensor_hubs.sensor_group_id', $group)
		->where('sensor_hubs.agent', $agent)
		->select('hubs.name','hubs.id as hid','sensor_hubs.*')
		->get();
		}
		else
		{
		$hubs = DB::table('sensor_hubs')
        ->join('hubs', 'sensor_hubs.hub_id', '=', 'hubs.id')
		->whereIn('sensor_hubs.sensor_group_id', $group)
		->where('sensor_hubs.agent', $agent)
		->select('hubs.name','hubs.id as hid','sensor_hubs.*')
		->get();
		}
		//print_r($groups);exit;
		//dd(DB::getQueryLog());
		echo "<option value=''>Select</option>";
		foreach($hubs as $item)
		{
		echo "<option value='".$item->hid."'>".$item->name."</option>";
		}
	}

//	public function getSensor(Request $request){
//	//DB::enableQueryLog();
//		$hub = $request->input('hub');
//		//$agent = $request->input('agent');
//		$sensors = DB::table('sensors')
//        ->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
//		//->where('sensor_hubs.sensor_group_id', $group)
//		->where('sensor_hubs.hub_id', $hub)
//		->select('sensors.*')
//		->get();
//		//print_r($groups);exit;
//		//dd(DB::getQueryLog());
//		echo "<option value=''>Select</option>";
//		foreach($sensors as $item)
//		{
//		echo "<option value='".$item->sensor_id."'>".$item->sensor_id."</option>";
//		}
//	}

	public function getSensor(Request $request){
	//DB::enableQueryLog();
		$hub = $request->input('hub');
		$agent = $request->input('agent');
		$group = $request->input('group');
		//$agent = $request->input('agent');
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
		echo "<option value=''>Select</option>";
		foreach($sensors as $item)
		{
		echo "<option value='".$item->sensor_id."'>".$item->sensor_id."</option>";
		}
	}	
	public function getSensordata(Request $request)
	{
		$hub = $request->input('hub');
		$agent = $request->input('agent');
		$group = $request->input('group');
		//$agent = $request->input('agent');
		$sensors = DB::table('sensors')
        ->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
		->join('types', 'types.id', '=', 'sensors.type')
		->join('measurement_units', 'measurement_units.id', '=', 'sensors.measure_unit')
		->join('units', 'units.id', '=', 'measurement_units.unit')
		->join('espdata', 'espdata.MAC', '=', 'sensors.sensor_id')
		->where('sensor_hubs.sensor_group_id', $group)
		->where('sensor_hubs.hub_id', $hub)
		->where('sensor_hubs.agent', $agent)
		->groupBy('espdata.MAC')
		->orderBy('espdata.RecordedDate', 'ASC')
		->select('sensors.id as sid','types.name','espdata.*','units.name as title')
		->get();
		
		return view('admin.algorithms.sensordata')->with(['sensors'=>$sensors]);
	}

	public function insertAlgorithm(Request $request){
		$agent = $request->input('agent');
		$name = $request->input('name');
		$push = $request->input('push');
				
		$data=array('userid'=>$agent,'name'=>$name,'push_message'=>$push);
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

		return view('admin.algorithms.edit')->with(['agents'=>$agents,'groups'=>$groups,'hubs'=>$hubs,'sensors'=>$sensors,'alg'=>$alg,'details'=>$details]);
	}
	public function updateAlgorithm(Request $request){
		$agent = $request->input('agent');
		$name = $request->input('name');
		$push = $request->input('push');
		$id = $request->input('eid');
		
		$data=array('userid'=>$agent,'name'=>$name,'push_message'=>$push);
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
