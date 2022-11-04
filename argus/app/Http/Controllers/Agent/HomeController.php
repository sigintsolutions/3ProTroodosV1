<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

use App\Exports\ReportExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;
use Session;
use Hash;
//use App\Group;
use DB;
class HomeController
{
    public function index()
    {
		//Fetching agent dashboard
		$settings = DB::table('settings')->select('agent_email')->get();
		$user = DB::select('select * from users where id='.session()->get('userid'));
		$groups = DB::table('gateway_groups')
		->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
		->where('gateway_groups.agent',session()->get('userid'))
		->select('gateway_groups.*', 'gateway_groups.id as groupid', 'sensor_groups.name')
		->orderBy('added_on', 'DESC')
		->get();
		$logs = DB::select('select * from log_details where userid = '.session()->get('userid'));
		$groups_count = count($groups);
		$hubs = DB::table('sensor_hubs')->where('agent', session()->get('userid'))->get();
		$hubs_count = count($hubs);
		$sensors = DB::table('sensors')
		->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
		->where('sensor_hubs.agent', session()->get('userid'))
		->get();
		$sensors_count = count($sensors);
		$list = DB::table('weather')
    		->join('loc', 'loc.id', '=', 'weather.locid')
    		->where('weather.userid', session()->get('userid'))
    		->select('weather.*', 'weather.id as id', 'loc.loc', 'loc.template')
			->first();
		
			$agentid=session()->get('userid');
			$sensorlists=array();
			$countmsgdt=DB::table('algorithm')->where('userid',$agentid)->where('readflaguserid',0)->get();
				$countmsgagent=count($countmsgdt);
//dd("kkk");
		return view('home2')->with([
			'user' => $user,
			'settings' => $settings,
			'sensors_count' => $sensors_count,
			'groups' => $groups,
			'groups_count' => $groups_count,
			'hubs_count' => $hubs_count,
			'logs' => $logs,
			'list' => $list,
			'sensorlists' => $sensorlists,'agentid'=>$agentid,'countmsgagent'=>$countmsgagent
		]);
	}
	function dashsensedetails(){
	//$agentid=$_GET['agentid'];

		//Displaying agent sensor console
		$agentid=session()->get('userid');
	

		
//Displaying agent sensor console screen
				

	


$hubscount = DB::table('sensors')
			->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')->where('sensor_hubs.agent',$agentid)->where('sensors.agent',$agentid)
			->groupBy('hub_id','sensor_id')
			->select('sensors.hub_id','sensors.sensor_id')
			->get();
			
    foreach($hubscount as $hubscounts)
			{
				//$getudt=DB::table('sensors')->where('sensor_id',$hubscounts->sensor_id)->where('hub_id',$hubscounts->hub_id)->first();
				$gethdt=DB::table('sensor_hubs')->where('id',$hubscounts->hub_id)->first();
				//$unit1[] = $getudt->unit;
				//$unit1[] = '*C';
				$sensors[]=$hubscounts->sensor_id;
				$sensorshubs[]=$gethdt->hub_id;


				

			}





				



				$query=DB::table('dbo_payloader as db')->orderby('db.id','desc')->skip(0)->select('db.*');

$query->where(function($query) use ($sensorshubs, $sensors)
{
	for($i=0;$i<count($sensorshubs);$i++)
	{	
		if($i==0)
		{
			//$query->where('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			$query->where(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
		}
		else
		{
			$query->orwhere(function($query) use ($sensorshubs, $sensors, $i){
				$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
			});
			//$query->orwhere('db.hub',$sensorshubs[$i])->where('db.sensor_id',$sensors[$i]);
		}
		
	}
});
$sensorlists=$query->take(100)->get();





//dd(DB::getQueryLog());die();

	return view('dashconsole')->with(['sensorlists' => $sensorlists,'agentid'=>$agentid
				]);
	}
	public function sessionexpiry()
    {  
		return view('session');
	}
}