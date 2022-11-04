<?php

namespace App\Http\Controllers\Admin;

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

public function multilogin()
    {
    	
    	echo "<p style='background-color: red;color: #fff;text-align: center;padding: 5px;'>Sorry Some One has logged in with this account</p>";
//echo "Sorry Some One has logged in with this account";
return view('auth.login');
    //return redirect('/home');
}
    public function index()
    {
		//echo "admin";die();
	//DB::enableQueryLog();
		$agents = DB::table('users')
			->join('role_user', 'role_user.user_id', '=', 'users.id')
			->where('role_user.role_id', 2)
			->get();
		$agents_count=count($agents);
		$sensors = DB::table('sensors')
			->get();
		$sensors_count=count($sensors);
		$groups = DB::table('gateway_groups')
		        ->join('users', 'users.id', '=', 'gateway_groups.agent')
		        ->get();
		$groups_count=count($groups);
		$hubs = DB::table('sensor_hubs')
			->where('id','!=', '1')
			->get();
		$hubs_count=count($hubs);
		
		$loginagents = DB::table('users')
			->join('role_user', 'role_user.user_id', '=', 'users.id')
			->where('role_user.role_id', 2)
			->where('users.log_status', 1)
			->get();
// 		$logoutagents = DB::table('users')
// 			->join('role_user', 'role_user.user_id', '=', 'users.id')
// 			->where('role_user.role_id', 2)
// 			->where('users.log_status', 0)
// 			->get();
		$logoutagents = DB::table('users')
			->join('role_user', 'role_user.user_id', '=', 'users.id')
			->where('role_user.role_id', 2)
			->get();
		$total=count($loginagents)+count($logoutagents);
		if($total != '0')
		{
		    $perlogin=(count($loginagents)/$total)*100;
		    $perlogout=(count($logoutagents)/$total)*100;
		}
		else
		{
		    $perlogin = '';
		    $perlogout = '';
		}
// 		$perlogin=(count($loginagents)/$total)*100;
// 		$perlogout=(count($logoutagents)/$total)*100;
		$logs = DB::table('log_details')
		->join('users', 'users.id', '=', 'log_details.userid')	
		->join('role_user', 'role_user.user_id', '=', 'users.id')	
		->where('role_user.role_id', 2)
		->orderby('log_details.id', 'desc')
		->groupby('log_details.userid')
		->select('log_details.*','users.fname','users.lname')
		->paginate(15);
		//return view('home')->with(['logs' => $logs]);
		$sensors = DB::table('dbo_payloader')->orderby('id', 'desc')->paginate(100);
		//$countmsgdt=DB::table('algorithm')->where('readflag',0)->get();
		$countmsgdt=DB::table('userdatamessages')->where('readflag',0)->get();
				$countmsg=count($countmsgdt);
//dd("helloh");
				//dd($countmsg);
        return view('home')->with(['agents_count'=>$agents_count,'agents'=>$agents,'sensors_count'=>$sensors_count,'groups_count'=>$groups_count,'hubs_count'=>$hubs_count,'perlogin'=>$perlogin,'perlogout'=>$perlogout,'loginagents'=>count($loginagents),'logoutagents'=>count($logoutagents),'logs'=> $logs,'sensors'=> $sensors,'countmsg'=>$countmsg]);
	}
	public function searchlog(Request $request)
    {
		$agents = DB::table('users')
			->join('role_user', 'role_user.user_id', '=', 'users.id')
			->where('role_user.role_id', 2)
			->get();
		$agents_count=count($agents);
		$sensors = DB::table('sensors')
			->get();
		$sensors_count=count($sensors);
		$groups = DB::table('gateway_groups')
		        ->join('users', 'users.id', '=', 'gateway_groups.agent')
		        ->get();
		$groups_count=count($groups);
		$hubs = DB::table('sensor_hubs')
			->where('id','!=', '1')
			->get();
		$hubs_count=count($hubs);
		
		$loginagents = DB::table('users')
			->join('role_user', 'role_user.user_id', '=', 'users.id')
			->where('role_user.role_id', 2)
			->where('users.log_status', 1)
			->get();
		$logoutagents = DB::table('users')
			->join('role_user', 'role_user.user_id', '=', 'users.id')
			->where('role_user.role_id', 2)
			->get();
		$total=count($loginagents)+count($logoutagents);
		if($total != '0')
		{
		    $perlogin=(count($loginagents)/$total)*100;
		    $perlogout=(count($logoutagents)/$total)*100;
		}
		else
		{
		    $perlogin = '';
		    $perlogout = '';
		}
		$name = explode(' ', $request->input('name'));
 		$logs = DB::table('log_details')
		->join('users', 'users.id', '=', 'log_details.userid')	
		->join('role_user', 'role_user.user_id', '=', 'users.id')	
		->where('role_user.role_id', 2)
		->where('users.fname', $name[0])
		->where('users.lname', $name[1])
		->orderby('log_details.id', 'desc')
		//->groupby('log_details.userid')
		->select('log_details.*','users.fname','users.lname')
		->paginate(15);
        //return view('home')->with(['logs' => $logs]);
        $sensors = DB::table('dbo_payloader')->orderby('id', 'desc')->paginate(100);
        return view('home')->with(['agents_count'=>$agents_count,'agents'=>$agents,'sensors_count'=>$sensors_count,'groups_count'=>$groups_count,'hubs_count'=>$hubs_count,'perlogin'=>$perlogin,'perlogout'=>$perlogout,'loginagents'=>count($loginagents),'logoutagents'=>count($logoutagents),'logs'=> $logs,'sensors'=>$sensors]);
    }
}
