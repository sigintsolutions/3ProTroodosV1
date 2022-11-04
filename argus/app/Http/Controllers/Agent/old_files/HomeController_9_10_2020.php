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
		//echo "agent";die();
		// $agents = DB::table('users')
		// 	->join('role_user', 'role_user.user_id', '=', 'users.id')
		// 	->where('role_user.role_id', 2)
		// 	->get();
		// $agents_count=count($agents);
		// $sensors = DB::table('sensors')
		// 	->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
		// 	->where('sensor_hubs.agent', session()->get('userid'))
		// 	->get();
		// $sensors_count=count($sensors);
		// $groups = DB::table('sensor_groups')
		// 	->join('gateway_groups', 'gateway_groups.sensor_group_id', '=', 'sensor_groups.id')
		// 	->where('gateway_groups.agent', session()->get('userid'))
		// 	->select('sensor_groups.*')
		// 	->get();
		// $groups_count=count($groups);
		// $hubs = DB::table('hubs')
		// 	->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'hubs.id')
		// 	->where('sensor_hubs.agent', session()->get('userid'))
		// 	->get();
		// $types = DB::table('types')->get();
		// $types_count=count($types);
		// $hubs_count=count($hubs);		
		// $loginagents = DB::table('users')
		// 	->join('role_user', 'role_user.user_id', '=', 'users.id')
		// 	->where('role_user.role_id', 2)
		// 	->where('users.log_status', 1)
		// 	->get();
		// $logoutagents = DB::table('users')
		// 	->join('role_user', 'role_user.user_id', '=', 'users.id')
		// 	->where('role_user.role_id', 2)
		// 	->where('users.log_status', 0)
		// 	->get();	
		// $total=count($loginagents)+count($logoutagents);
		// $perlogin=(count($loginagents)/$total)*100;
		// $perlogout=(count($logoutagents)/$total)*100;
		// $login=DB::table('log_details')
		// 	->where('userid', session()->get('userid'))
		// 	->orderBy('created_at','DESC')
		// 	->skip(1)
		// 	->limit(11)
		// 	->get();
        // return view('home2')->with(['agents_count'=>$agents_count,'sensors_count'=>$sensors_count,'groups_count'=>$groups_count,'hubs_count'=>$hubs_count,'perlogin'=>$perlogin,'types_count'=>$types_count,'perlogout'=>$perlogout,'loginagents'=>count($loginagents),'logoutagents'=>count($logoutagents),'login'=>$login,'groups'=>$groups]);
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
		/*$sensorlists = DB::table('dbo_payloader')
			->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
			->where('sensor_hubs.agent', session()->get('userid'))
			->orderby('dbo_payloader.id', 'desc')
			->select('dbo_payloader.*')
			->paginate(100);*/
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
		$agentid=session()->get('userid');
	//$sensorlists = DB::table('dbo_payloader')->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')->take(100)->where('sensor_hubs.agent',$agentid)->orderby('dbo_payloader.id', 'desc')->select('time','dbo_payloader.hub','sensor_id','value')->get();

		/*$sensorlists = DB::table('dbo_payloader')
				->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
				->where('sensor_hubs.agent', session()->get('userid'))
				->orderby('dbo_payloader.id', 'desc')
				->select('dbo_payloader.*')
				->paginate(100);*/
	/*$sensorlists = DB::table('dbo_payloader')
				->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
				->where('sensor_hubs.agent', session()->get('userid'))
				->orderby('dbo_payloader.id', 'desc')
				->select('time','dbo_payloader.hub','sensor_id','value')->take(100)->get();*/

				/*$sensorlists = DB::table('dbo_payloadercharttemphub')
				->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloadercharttemphub.hub')->join('sensors','sensors.hub_id','=','sensor_hubs.id')
				->where('sensors.agent',session()->get('userid'))
				->orderby('dbo_payloadercharttemphub.id', 'desc')
				->select('time','dbo_payloadercharttemphub.hub','dbo_payloadercharttemphub.sensor_id','dbo_payloadercharttemphub.value')->take(100)->get();*/

	/*$sensorlists = DB::table('dbo_payloader as db')
				->join('sensors as se','se.sensor_id','=','db.sensor_id')->join('sensor_hubs as sh','sh.id','=','se.hub_id')->where('sh.agent',session()->get('userid'))
				->where('se.agent',session()->get('userid'))->take(100)
				->orderby('db.utc', 'desc')
				->select('db.utc','db.hub','db.sensor_id','db.value')->get();*/
/*$senlist=DB::table('sensors')->where('agent',session()->get('userid'))->get();
$senarr=array();
foreach ($senlist as $sl) {
					$senarr[]=$sl->sensor_id;
				}*/


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


				//$combined="$gethdt->hub_id"."_".$hubscounts->sensor_id;
//$sensorshub1[]=$combined;
//$getchtdt=DB::table('chart')->where('unit',$getudt->unit)->first();



//$chart1[]="AreaChart";

			}





				//dd($senarr);				
//DB::enableQueryLog();
/*$sensorlists = DB::table('dbo_payloader as db')
				->join('sensor_hubs as sh','sh.hub_id','=','db.hub')->join('sensors as se','se.hub_id','=','sh.id')->where('sh.agent',session()->get('userid'))
				->where('se.agent',session()->get('userid'))->take(100)
				->orderby('db.utc', 'desc')
				->select('db.utc','db.hub','db.sensor_id','db.value')->get();*/

/*$sensorlists = DB::table('dbo_payloader as db')
				->join('sensor_hubs as sh','sh.hub_id','=','db.hub')->join('sensors as se','se.hub_id','=','sh.id')->where('sh.agent',session()->get('userid'))->whereIn('se.sensor_id',$senarr)->where('sh.agent',session()->get('userid'))
				->take(100)
				->orderby('db.utc', 'desc')
				->select('db.utc','db.hub','db.sensor_id','db.value')->get();*/

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