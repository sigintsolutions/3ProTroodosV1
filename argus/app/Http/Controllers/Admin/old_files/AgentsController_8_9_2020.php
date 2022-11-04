<?php
    namespace App\Http\Controllers\Admin;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\MassDestroyProductRequest;
    use App\Http\Requests\StoreProductRequest;
    use App\Http\Requests\UpdateProductRequest;
    use Illuminate\Http\Request;
    use App\Imports\UsersImport;
    use Maatwebsite\Excel\Facades\Excel;
    use App\Exports\AgentExport;
    use App\Exports\GroupExport;
    use App\Exports\HubExport;
    use App\Exports\SensorsExport;
    use App\Exports\GroupnameExport;
    use App\Exports\HubnameExport;
    use App\Exports\UnitExport;
    use App\Exports\TypeExport;
    use App\Exports\BrandExport;
    use Session;
    use Hash;
    use Mail;
	use File;
	use Carbon\Carbon;
    //use App\Group;
    use Redirect,Response,DB,Config;
    
    class AgentsController extends Controller
    {
    	public function index()
        {
    	
            //abort_unless(\Gate::allows('product_access'), 403);
    
            //$groups = Group::all();
    		
    		//$agents = DB::select('select * from users inner join role_user on users.id=role_user.user_id where role_user.role_id=1');
    		$agents = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
    		->where('role_user.role_id', 2)
    		->orderBy('created_at', 'DESC')
            ->paginate(10);
    		$settings = DB::table('settings')
    		->select('agent_email')
    		->get();		
            return view('admin.agents.index')->with(['agents'=>$agents])->with(['settings'=>$settings]);
        }
    	######Agents##########
    	public function addAgent()
    	{
    		$settings = DB::table('settings')
    		->select('agent_email')
    		->get();
    
    		return view('admin.agents.create')->with(['settings'=>$settings]);
    	}
    	public function insertAgent(Request $request)
    	{
    		/*$cus_id = DB::table('users')->orderBy('id', 'desc')->first();
    		$cusid = $cus_id->customer_id++;				
    		$cusid = substr($cusid, 3, 5);
    		$cusid = (int) $cusid + 1;
    		$cusid = "AG" . sprintf('%04s', $cusid);*/
    		$customer_id = $request->input('customer_id');
    		$corporate_name = $request->input('corporate_name');
    		$street = $request->input('street');
    		$city = $request->input('city');
    		$state = $request->input('state');
    		$post_code = $request->input('post_code');
    		$country = $request->input('country');
    		$service_expiry = date('d-m-Y', strtotime($request->input('service_expiry')));
    		$service_start = date('d-m-Y', strtotime($request->input('service_start')));
    		$remark = $request->input('remark');
    		$status = $request->input('status');
    		$fname = $request->input('fname');
    		$lname = $request->input('lname');
    		$email = $request->input('email');
    		$template = $request->input('template');
    		$password = $request->input('password');
    		$sendmail=$request->input('sendmail');
    		$hashpassword=Hash::make($password);		
    		$use = DB::table('users')
    			->join('role_user', 'role_user.user_id', '=', 'users.id')
    			->where('role_user.role_id', 2)
    			->where('users.email', $email)
    			->get();			
    		if(count($use)>0)
    		{
    			Session::flash('flash_message', 'Username already exists. Please choose another.');
    			return redirect('admin/addagent');
    		}
    		else
    		{
    			$data=array('fname'=>$fname,'lname'=>$lname,'email'=>$email,'password'=>$hashpassword,'original'=>$password,'customer_id'=>$customer_id,'corporate_name'=>$corporate_name,'street'=>$street,'city'=>$city,'email_template'=>$template,'state'=>$state,'post_code'=>$post_code,'country'=>$country,'service_start'=>$service_start,'service_expiry'=>$service_expiry,'remark'=>$remark,'status'=>$status);
    			$userid=DB::table('users')->insertGetId($data);
    			$value=DB::table('role_user')->insert(array('user_id'=>$userid,'role_id'=>2));

$table='dbo_payloaderalgorithmtemp'.$userid;

$statement = "create table $table(id int(11) primary key auto_increment,utc varchar(200),hub varchar(255),sensor_id varchar(200),sensor_type varchar(200),value varchar(200),unit text,time timestamp,processedflag int(11),processedflagall int(5));";
    $db=DB::statement($statement);

$tableandor='dbo_payloaderalgorithmtempandor'.$userid;

$statementandor = "create table $tableandor(id int(11) primary key auto_increment,utc varchar(200),hub varchar(255),sensor_id varchar(200),sensor_type varchar(200),value varchar(200),unit text,time timestamp,processedflag int(11),processedflagall int(5));";
    $dbandor=DB::statement($statementandor);

    			if(@$sendmail=='Y')
    			{
    				//$mailtemp=str_replace(array('<< firstname >>','<< lastname >>','<< email >>','<< username >>','<< password >>'),array($fname,$lname,$email,$email,$password),$template);
    				Mail::send(array(), $data, function($message) use ($data) {
    					$message->to($data['email'], $data['fname'])->subject('User Details');
    					$message->from('hr@eurozapp.com','Argus');
    					$message->setBody(str_replace(array('<< firstname >>','<< lastname >>','<< email >>','<< username >>','<< password >>'),array($data['fname'],$data['lname'],$data['email'],$data['email'],$data['original']),$data['email_template']));
    				});
    				
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
    			return redirect('admin/agents');
    		}
    		
    	}
    	public function editAgent($id=0)
    	{
    		$settings = DB::table('settings')
    		->select('agent_email')
    		->get();
    		$user = DB::select('select * from users where id='.$id);
    		return view('admin.agents.edit')
    			->with(['user'=>$user])
    			->with(['settings'=>$settings]);
		}
		public function editAgenttree($id=0)
    	{
    		$settings = DB::table('settings')
    		->select('agent_email')
    		->get();
    		$user = DB::select('select * from users where id='.$id);
    		//$groups = DB::select('select * from gateway_groups where agent = '.$id);	
    		$groups = DB::table('gateway_groups')
    		->join('users', 'gateway_groups.agent', '=', 'users.id')
    		->join('role_user', 'role_user.user_id', '=', 'users.id')
    		->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
    		->where('role_user.role_id', 2)
    		->where('gateway_groups.agent', $id)
    		//->where('users.status', 1)
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
			//$hublists = DB::table('dbo_payloader')->groupBy('hub')->get();
            $hublists = DB::table('sensor_hubs')->groupBy('hub_id')->get();
			//$data = DB::table('dbo_payloader')->where('hub', '=', $hubidname)->get();
    		return view('admin.agents.tree')
    			->with(['user'=>$user])
    			->with(['settings'=>$settings])
    			->with(['groups'=>$groups])
    			->with(['hublists'=>$hublists])
    			->with(['types'=>$types])
    			->with(['brands'=>$brands])
				->with(['units'=>$units])
				->with(['data'=>$hublists])
    			->with(['groupnames'=>$groupnames]);
    	}
    	public function editAgentpop($id=0)
    	{
    		$user = DB::table('users')->where('id', '=', $id)->first();
    		$settings = DB::table('settings')->select('agent_email')->get();
    		if(empty($user->email_template))
    		{
    			$user->email_template = $settings[0]->agent_email;
    		}	
    		echo json_encode($user);
    	}
    	public function updateAgent(Request $request)
    	{
    		$id = $request->input('eid');
    		$user = DB::select('select * from users where id="'.$id.'"');	
    		$customer_id = $request->input('customer_id');
    		$corporate_name = $request->input('corporate_name');
    		$street = $request->input('street');
    		$city = $request->input('city');
    		$state = $request->input('state');
    		$post_code = $request->input('post_code');
    		$country = $request->input('country');
    		$service_expiry = date('d-m-Y', strtotime($request->input('service_expiry')));
    		$service_start = date('d-m-Y', strtotime($request->input('service_start')));
    		$remark = $request->input('remark');
    		$status = $request->input('status');
    		$sendmail=$request->input('sendmail');
    		$fname = $request->input('fname');
    		$lname = $request->input('lname');
    		$email = $request->input('email');
    		
    		$template = $request->input('template');
    		
    		$oldpassword = $request->input('oldpassword');
    		$password = $request->input('password');
    		$confirm = $request->input('confirm');
    		if($password=="")
    		{
    			$data=array('fname'=>$fname,'lname'=>$lname,'email'=>$email,'customer_id'=>$customer_id,'corporate_name'=>$corporate_name,'street'=>$street,'city'=>$city,'state'=>$state,'post_code'=>$post_code,'email_template'=>$template,'country'=>$country,'service_start'=>$service_start,'service_expiry'=>$service_expiry,'remark'=>$remark,'status'=>$status,'original'=>$user[0]->original);
				
				$value=DB::table('users')
    				->where('id', $id)
    				->update($data);			
    			if(@$sendmail=='Y')
    			{
    				//$mailtemp=str_replace(array('<< firstname >>','<< lastname >>','<< email >>','<< username >>','<< password >>'),array($fname,$lname,$email,$email,$password),$template);
    				Mail::send(array(), $data, function($message) use ($data) {
    					$message->to($data['email'], $data['fname'])->subject('User Details');
    					$message->from('hr@eurozapp.com','Argus');
    					$message->setBody(str_replace(array('<< firstname >>','<< lastname >>','<< email >>','<< username >>','<< password >>'),array($data['fname'],$data['lname'],$data['email'],$data['email'],$data['original']),$data['email_template']));
    				});
    				
    			}
    			return redirect('admin/agents')->with('flash_message','Record updated successfully.');
    		}
    		else
    		{
    			if($password == "")
    			{
    				Session::flash('flash_message', 'Password is mandatory');
    				return redirect('admin/editAgent/'.$id);
    			}
    			else
    			{
    				$hashpassword=Hash::make($password);
    				$data=array('fname'=>$fname,'lname'=>$lname,'email'=>$email,'password'=>$hashpassword,'original'=>$password,'customer_id'=>$customer_id,'corporate_name'=>$corporate_name,'street'=>$street,'city'=>$city,'state'=>$state,'post_code'=>$post_code,'country'=>$country,'service_expiry'=>$service_expiry,'service_start'=>$service_start,'remark'=>$remark,'status'=>$status,'email_template'=>$template);
					//print_r($data);die();
					$value=DB::table('users')
    					->where('id', $id)
    					->update($data);
    					
    				if(@$sendmail=='Y')
    				{
    					//$mailtemp=str_replace(array('<< firstname >>','<< lastname >>','<< email >>','<< username >>','<< password >>'),array($fname,$lname,$email,$email,$password),$template);
    					Mail::send(array(), $data, function($message) use ($data) {
    						$message->to($data['email'], $data['fname'])->subject('User Details');
    						$message->from('hr@eurozapp.com','Argus');
    						$message->setBody(str_replace(array('<< firstname >>','<< lastname >>','<< email >>','<< username >>','<< password >>'),array($data['fname'],$data['lname'],$data['email'],$data['email'],$data['original']),$data['email_template']));
    					});
    					
    				}
    				return redirect('admin/agents')->with('flash_message','Record updated successfully.');
    			}
    		}
    	}	
    	public function deleteAgent($id=0)
    	{
    		if($id != 0)
    		{
    			// Delete
    			DB::table('role_user')->where('user_id', '=', $id)->delete();
    			DB::table('users')->where('id', '=', $id)->delete();
    			
    			DB::table('gateway_groups')->where('agent', '=', $id)->delete();
				DB::table('sensor_hubs')->where('agent', '=', $id)->delete();
				DB::table('sensors')->where('agent', '=', $id)->delete();
				Session::flash('flash_message','Delete successfully.');	
				return redirect()->back();	
    		}
    		Session::flash('flash_message','Delete successfully.');
            return redirect()->back();
    	}
    	public function deleteagnt($id=0)
    	{
    		$list = explode(',', $id);
    		foreach($list as $lists)
    		{
    			$documents = DB::table('role_user')->where('user_id', $lists)->delete();
    			if($documents)
    			{
    				DB::table('users')->where('id', $lists)->delete();
    				DB::table('gateway_groups')->where('agent', '=', $lists)->delete();
					DB::table('sensor_hubs')->where('agent', '=', $lists)->delete();
					DB::table('sensors')->where('agent', '=', $lists)->delete();
					// Session::flash('flash_message','Delete successfully.');		
    				// return redirect()->back();
				}	
				// Session::flash('flash_message','Delete successfully.');		
    			// return redirect()->back();		
    		}
    		// Session::flash('flash_message','Delete successfully.');
            // return redirect()->back();
        }
    	function import(Request $request)
    	{
    		$this->validate($request, [
    		'select_file'  => 'required|mimes:xls,xlsx'
    		]);
    		$datas = Excel::toArray(new UsersImport,request()->file('select_file'));
    		foreach($datas as $key => $value)
            {				
    			$cus_id = DB::table('users')->orderBy('id', 'desc')->first();							
    			foreach($value as $row)
    			{
    				$cusid = $cus_id->customer_id++;
    				$cusid = substr($cusid, 3, 5);
    				$cusid = (int) $cusid + 1;
    				$cusid = "AG" . sprintf('%04s', $cusid);
    				$userscus = DB::table('users')->where('email', $row[2])->get();
    				if(count($userscus) == '0')
    				{
    				    if(!empty($row[2]))
    					{
        					$hashpassword = Hash::make($row[12]);
        					$insert_data = array(
        						'fname'         => $row[0],
        						'lname'         => $row[1],
        						'email'         => $row[2],
        						'customer_id'   => $cusid,
        						'corporate_name'=> $row[3],
        						'street'        => $row[4],
        						'city'          => $row[5],
        						'state'         => $row[6],
        						'post_code'     => $row[7],
        						'country'       => $row[8],
        						'service_start' => $row[9],
        						'service_expiry'=> $row[10],
        						'remark'        => $row[11],
        						'password'      => $hashpassword,
        						'original'      => $row[12],
        					);
        					if(!empty($insert_data))
        					{
        						$ins = DB::table('users')->insert($insert_data);
        						if($ins)
        						{
        							//echo $ins-
        							$userid = DB::table('users')->where('email', $row[2])->get();
        							$insertrole = DB::table('role_user')->insert(array('user_id' => $userid[0]->id, 'role_id' => '2'));
        						}
        					}
    					}
    				}
    			}			
    		}		
    		return back()->with('success', 'Excel Data Imported successfully.');
    	}
    	public function groups()
        {
    		$agentid = request()->agentid;
    		$user = DB::select('select * from users where id ='.$agentid);
            $groups = DB::table('gateway_groups')
    		->join('users', 'gateway_groups.agent', '=', 'users.id')
    		->join('role_user', 'role_user.user_id', '=', 'users.id')
    		->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
    		->where('role_user.role_id', 2)
    		->where('gateway_groups.agent', $agentid)
    		//->where('users.status', 1)
    		->select('gateway_groups.*', 'gateway_groups.group_id','users.fname','sensor_groups.name')
    		->orderBy('added_on', 'DESC')
    		->paginate(10);
    		//print_r($groups);die();
    		$groupnames = DB::table('sensor_groups')->get();
    		return view('admin.gatewaygroup.index')->with(['groups'=>$groups])->with(['user'=>$user])->with(['groupnames'=>$groupnames]);
    	}
    	function importgroup(Request $request)
    	{
    		$this->validate($request, [
    		'select_file'  => 'required|mimes:xls,xlsx'
    		]);
    		$datas = Excel::toArray(new UsersImport,request()->file('select_file'));
    		foreach($datas as $key => $value)
            {							
    			$cus_id = DB::table('gateway_groups')->orderBy('id', 'desc')->first();							
    			foreach($value as $row)
    			{				
    				if(empty($cus_id->group_id)) 
    				{
    					$cusid = 'GW0001';
    				}
    				else
    				{
    					$cusid = $cus_id->group_id++;				
    					$cusid = substr($cusid, 3, 5);
    					$cusid = (int) $cusid + 1;
    					$cusid = "GW" . sprintf('%04s', $cusid);
    				}
    				$userscus = DB::table('gateway_groups')->where('latitude', $row[3])->where('longitude', $row[4])->where('agent', $request->input('agent'))->get();
    				if(count($userscus) == '0')
    				{
    					$agent = $request->input('agent');
    					$sengroups = DB::table('sensor_groups')->where('name', $row[0])->get();
    					if(count($sengroups) == '0')
    					{
    						$insert_data = array(
    							'name'     	=> $row[0],
    						);
    						if(!empty($insert_data))
    						{
    							$ins = DB::table('sensor_groups')->insert($insert_data);
    							if($ins)
    							{
    								$sengroupsins = DB::table('sensor_groups')->where('name', $row[0])->get();
    								$sensor_group_id = $sengroupsins[0]->id;
    							}
    							
    						}				
    					}
    					else
    					{
    						if(!empty($sengroups[0]->id)) 
    						{
    							$sensor_group_id = $sengroups[0]->id;
    						}
    						else
    						{
    							$sensor_group_id = '';
    						}
    					}
    					$insert_data = array(
    						'group_id'          => $cusid,
    						'agent'             => $agent,
    						'sensor_group_id'   => $sensor_group_id,
    						'sim_no'            => $row[1],
    						'router_sensor_no'  => $row[2],
    						'latitude'          => $row[3],
    						'longitude'         => $row[4],
    						'sensor_information'=> $row[5],
    					);
    					if(!empty($insert_data))
    					{
    						$ins = DB::table('gateway_groups')->insert($insert_data);
    					}
    				}
    			}				
    		}
    		//die();	
    		return back()->with('flash_message', 'Excel Data Imported successfully.');
    	}
    	function importmulgroup(Request $request)
    	{
    		$this->validate($request, [
    		'select_file'  => 'required|mimes:xls,xlsx'
    		]);
    		$list = explode(',', $request->input('agentidimport'));
    		foreach($list as $lists)
    		{
    			$datas = Excel::toArray(new UsersImport,request()->file('select_file'));
    			foreach($datas as $key => $value)
    			{							
    				$cus_id = DB::table('gateway_groups')->orderBy('id', 'desc')->first();							
    				foreach($value as $row)
    				{				
    					if(empty($cus_id->group_id)) 
    					{
    						$cusid = 'GW0001';
    						//$cusid = $cusid++;
    					}
    					else
    					{
    						$cusid = $cus_id->group_id++;				
    						$cusid = substr($cusid, 3, 5);
    						$cusid = (int) $cusid + 1;
    						$cusid = "GW" . sprintf('%04s', $cusid);
    					}
    					$userscus = DB::table('gateway_groups')->where('latitude', $row[3])->where('longitude', $row[4])->where('agent', $lists)->get();
    					if(count($userscus) == '0')
    					{
    						//$agent = $request->input('agent');
    						$sengroups = DB::table('sensor_groups')->where('name', $row[0])->get();
    						if(count($sengroups) == '0')
        					{
        						$insert_data = array(
        							'name'     	=> $row[0],
        						);
        						if(!empty($insert_data))
        						{
        							$ins = DB::table('sensor_groups')->insert($insert_data);
        							if($ins)
        							{
        								$sengroupsins = DB::table('sensor_groups')->where('name', $row[0])->get();
        								$sensor_group_id = $sengroupsins[0]->id;
        							}
        							
        						}				
        					}
        					else
        					{
        						if(!empty($sengroups[0]->id)) 
        						{
        							$sensor_group_id = $sengroups[0]->id;
        						}
        						else
        						{
        							$sensor_group_id = '';
        						}
        					}
    						$insert_data = array(
    							'group_id'          => $cusid,
    							'agent'             => $lists,
    							'sensor_group_id'   => $sensor_group_id,
    							'sim_no'            => $row[1],
    							'router_sensor_no'  => $row[2],
    							'latitude'          => $row[3],
    							'longitude'         => $row[4],
    							'sensor_information'=> $row[5],
    						);
    						if(!empty($insert_data))
    						{
    							$ins = DB::table('gateway_groups')->insert($insert_data);
    						}
    					}
    				}				
    			}
    		}
    		//die();	
    		return back()->with('flash_message', 'Excel Data Imported successfully.');
    	}
    	public function sensorhubs()
        {
    		$agentid = request()->agentid;
    		$groupid = request()->groupid;
    		$user = DB::select('select * from users where id ='.$agentid);
    		$group = DB::select('select * from gateway_groups where id ='.$groupid);
    		$groupname = DB::select('select * from sensor_groups where id ='.$group[0]->sensor_group_id);
            $hubs = DB::table('sensor_hubs')
    		->join('users', 'sensor_hubs.agent', '=', 'users.id')
    		->join('role_user', 'role_user.user_id', '=', 'users.id')
    		->join('sensor_groups', 'sensor_groups.id', '=', 'sensor_hubs.sensor_group_id')
    		->join('gateway_groups', 'gateway_groups.id', '=', 'sensor_hubs.group_id')
    		->where('role_user.role_id', 2)
    		//->where('users.status', 1)
    		->where('sensor_hubs.agent', request()->agentid)
    		->where('sensor_hubs.group_id', request()->groupid)
			->select('sensor_hubs.*', 'sensor_hubs.sensor_hub_id','users.fname','sensor_groups.name as groupname')
    		->orderBy('added_on', 'DESC')
    		->get();
			$hubdata = DB::table('hubdata')->first();
			$hublists = explode(',', $hubdata->hub);
			return view('admin.sensorhub.index')->with(['hubs' => $hubs])->with(['user' => $user])->with(['groupname' => $groupname])->with(['group' => $group])->with(['hublists' => $hublists]);
    	}
    	public function addgrouppop($id=0)
    	{
    		$hubs = DB::table('gateway_groups')
    		->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
    		->where('gateway_groups.id', $id)
    		->select('gateway_groups.*', 'sensor_groups.name')
    		->first();
    		echo json_encode($hubs);
    	}
    	public function addsensorpop($id=0)
    	{
    		$hubs = DB::table('sensor_hubs')
    		->join('gateway_groups', 'gateway_groups.id', '=', 'sensor_hubs.group_id')
    		->join('sensor_groups', 'sensor_groups.id', '=', 'sensor_hubs.sensor_group_id')
    		//->join('hubs', 'hubs.id', '=', 'sensor_hubs.hub_id')
    		->where('sensor_hubs.id', $id)
    		->select('sensor_hubs.*', 'sensor_hubs.hub_id as hubname', 'sensor_groups.name as groupname', 'sensor_hubs.id as hubid')
    		->first();
    		echo json_encode($hubs);
		}
		public function addsensorpopval($id=0)
    	{
			//echo $id;die();
			//$hubid = 'argus/report/'.$id;
$hubid=$id;

			$hubs = DB::table('dbo_payloader')->where('hub', $hubid)->offset(0)->limit(100)->get();
			
			echo "<option value=''>Select</option>";
			foreach($hubs as $item)
			{
				echo "<option value='".$item->sensor_id."'>".$item->sensor_id."</option>";
			}
		}
		public function addsensordrop()
    	{
			$hubid = request()->val;
			$hubs = DB::table('sensordata')->where('hub', $hubid)->groupBy('sensor_id')->get();
			echo "<option value=''>Select Sensor</option>";
			foreach($hubs as $item)
			{
				echo "<option value='".$item->sensor_id."'>".$item->sensor_id."</option>";
			}
		}
		public function addsensordropedit()
    	{
			$s = request()->val2;
			$hubid = request()->val1;
			$hubs = DB::table('sensordata')->where('hub', $hubid)->groupBy('sensor_id')->get();
			echo "<option value='".$s."'>".$s."</option>";
			foreach($hubs as $item)
			{
				echo "<option value='".$item->sensor_id."'>".$item->sensor_id."</option>";
			}
		}
		public function addsensorpopval2($val1 = 0, $val2 = 0)
    	{
			$val2=$_GET['sensorid'];
			$hubid=$_GET['hb'];
           /* $hubid =$val1;
			echo $val2;
			die();
			$hubs = DB::table('dbo_payloader')->where('hub', $hubid)->offset(0)->limit(100)->get();
			echo "<option value='".$val2."' selected>".$val2."</option>";
			foreach($hubs as $item)
			{
				echo "<option value='".$item->sensor_id."'>".$item->sensor_id."</option>";
			}*/
$hubs = DB::table('dbo_payloader')->where('hub', $hubid)->offset(0)->limit(100)->get();
			echo "<option value='".$val2."' selected>".$val2."</option>";
			foreach($hubs as $item)
			{
				echo "<option value='".$item->sensor_id."'>".$item->sensor_id."</option>";
			}
//echo "hello";

    	}

public function addsensorpopval2edit(){
	echo "hello";

}

    	public function editSensorpoptree($id=0)
    	{
    		$hubs = DB::table('sensors')
    		->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
    		->join('gateway_groups', 'gateway_groups.id', '=', 'sensor_hubs.group_id')
    		->join('sensor_groups', 'sensor_groups.id', '=', 'sensor_hubs.sensor_group_id')
    		->join('types', 'types.id', '=', 'sensors.type')
    		->where('sensors.id', $id)
    		->select('sensors.*', 'sensor_hubs.hub_id as hubname', 'sensor_groups.name as groupname', 'sensors.id as sensorid', 'sensors.hub_id as hubid', 'sensors.unit as unitname', 'types.*')
			->first();
			//$hubs->unitname;die();
    		echo json_encode($hubs);
    	}
    	public function editSensorhubpoptree($id=0)
    	{
    		$hubs = DB::table('sensor_hubs')
    		->join('gateway_groups', 'gateway_groups.id', '=', 'sensor_hubs.group_id')
    		->join('sensor_groups', 'sensor_groups.id', '=', 'sensor_hubs.sensor_group_id')
    		//->join('hubs', 'hubs.id', '=', 'sensor_hubs.hub_id')
    		->where('sensor_hubs.id', $id)
    		->select('sensor_hubs.*', 'sensor_groups.name as groupname', 'sensor_hubs.id as hubid')
    		->first();
    		echo json_encode($hubs);
    	}
    	function importhub(Request $request)
    	{
    		$this->validate($request, [
    		'select_file'  => 'required|mimes:xls,xlsx'
    		]);
    		$datas = Excel::toArray(new UsersImport,request()->file('select_file'));
    		//print_r($datas);die();
    		foreach($datas as $key => $value)
            {				
    			$cus_id = DB::table('sensor_hubs')->orderBy('id', 'desc')->first();							
    			foreach($value as $row)
    			{			
    				if(empty($cus_id->sensor_hub_id)) 
    				{
    					$cusid = 'SH0001';
    				}
    				else
    				{
    					$cusid = $cus_id->sensor_hub_id++;				
    					$cusid = substr($cusid, 3, 5);
    					$cusid = (int) $cusid + 1;
    					$cusid = "SH" . sprintf('%04s', $cusid);
    				}								
    				$agent = $request->input('agent');
    				$group_id = $request->input('group_id');
    				$sensor_group_id = $request->input('sensor_group_id');
    				// $hubs = DB::table('hubs')->where('name', $row[0])->get();
    				// if(count($hubs) == '0')
					// {
					// 	$insert_data = array(
    				// 		'name'     	=> $row[0],
    				// 	);
    				// 	if(!empty($insert_data))
    				// 	{
    				// 		$ins = DB::table('hubs')->insert($insert_data);
    				// 		if($ins)
					// 		{
					// 			$sengroupsins = DB::table('hubs')->where('name', $row[0])->get();
					// 			$hub_id = $sengroupsins[0]->id;
					// 		}
    				// 	}
					// }
					// else
					// {
					// 	if(!empty($hubs[0]->id)) 
        			// 	{
        			// 		$hub_id = $hubs[0]->id;
        			// 	}
        			// 	else
        			// 	{
        			// 		$hub_id = '';
        			// 	}
					// }
					//$hubcnt = DB::table('sensor_hubs')->where('hub_id', $hub_id)->where('agent', $agent)->get();	
					$hubcnt = DB::table('sensor_hubs')->where('hub_id', $row[0])->where('group_id', $group_id)->get();
					if(count($hubcnt) == '0')
					{
        				$insert_data = array(
        					'sensor_hub_id'     => $cusid,
        					'agent'             => $agent,
        					'group_id'          => $group_id,
        					'sensor_group_id'   => $sensor_group_id,
        					'hub_id'            => $row[0],
        					'mac_id'            => $row[1],
        					'hub_inform'        => $row[2],
        				);
        				if(!empty($insert_data))
        				{
        					$ins = DB::table('sensor_hubs')->insert($insert_data);
        				}
					}
    			}			
    		}	
    		return back()->with('flash_message', 'Excel Data Imported successfully.');
    	}
    	function importmulhub(Request $request)
    	{
    		$this->validate($request, [
    		'select_file'  => 'required|mimes:xls,xlsx'
    		]);
    		//echo $request->input('group_id');die();
    		$list = explode(',', $request->input('group_id'));
    		foreach($list as $lists)
    		{
    			$datas = Excel::toArray(new UsersImport,request()->file('select_file'));
    			foreach($datas as $key => $value)
    			{				
    				$cus_id = DB::table('sensor_hubs')->orderBy('id', 'desc')->first();							
    				foreach($value as $row)
    				{	
    				    $s = DB::table('gateway_groups')->where('id', $lists)->get();
    				    //print_r($s);
    					if(empty($cus_id->sensor_hub_id)) 
    					{
    						$cusid = 'SH0001';
    					}
    					else
    					{
    						$cusid = $cus_id->sensor_hub_id++;				
    						$cusid = substr($cusid, 3, 5);
    						$cusid = (int) $cusid + 1;
    						$cusid = "SH" . sprintf('%04s', $cusid);
    					}								
    					$agent = $request->input('agent');
    					$group_id = $lists;
    					$sensor_group_id = $s[0]->sensor_group_id;
    					// $hubs = DB::table('hubs')->where('name', $row[0])->get();
    					// if(count($hubs) == '0')
    					// {
    					// 	$insert_data = array(
        				// 		'name'     	=> $row[0],
        				// 	);
        				// 	if(!empty($insert_data))
        				// 	{
        				// 		$ins = DB::table('hubs')->insert($insert_data);
        				// 		if($ins)
    					// 		{
    					// 			$sengroupsins = DB::table('hubs')->where('name', $row[0])->get();
    					// 			$hub_id = $sengroupsins[0]->id;
    					// 		}
        				// 	}
    					// }
    					// else
    					// {
    					// 	if(!empty($hubs[0]->id)) 
            			// 	{
            			// 		$hub_id = $hubs[0]->id;
            			// 	}
            			// 	else
            			// 	{
            			// 		$hub_id = '';
            			// 	}
    					// }
    					$hubcnt = DB::table('sensor_hubs')->where('hub_id', $row[0])->where('group_id', $group_id)->get();	
    					if(count($hubcnt) == '0')
    					{
        					$insert_data = array(
        						'sensor_hub_id'     => $cusid,
        						'agent'             => $agent,
        						'group_id'          => $group_id,
        						'sensor_group_id'   => $sensor_group_id,
        						'hub_id'            => $row[0],
        						'mac_id'            => $row[1],
        						'hub_inform'        => $row[2],
        					);
        					if(!empty($insert_data))
        					{
        						$ins = DB::table('sensor_hubs')->insert($insert_data);
        					}
    					}
    				}			
    			}
    		}
    		return back()->with('flash_message', 'Excel Data Imported successfully.');
    	}
    	public function editgrouppop($id=0)
    	{
    		$user = DB::table('gateway_groups')->where('id', '=', $id)->first();
    		echo json_encode($user);
    	}
    	public function editSensorhubpop($id=0)
    	{
    		$user = DB::table('sensor_hubs')->where('id', '=', $id)->first();
    		echo json_encode($user);
    	}
    	public function sensors()
        {
    		$agentid = request()->agentid;
    		$groupid = request()->groupid;
    		$hubid = request()->hubid;
    		$user = DB::select('select * from users where id ='.$agentid);
    		$group = DB::select('select * from gateway_groups where id ='.$groupid);
    		$groupname = DB::select('select * from sensor_groups where id ='.$group[0]->sensor_group_id);
    		$hub = DB::select('select * from sensor_hubs where id ='.$hubid);
			$hubname = DB::select('select * from sensor_hubs where hub_id = "'.$hub[0]->hub_id.'"');
			
    		$sensors = DB::table('sensors')
    		->where('hub_id', $hubid)
			->join('types', 'sensors.type', '=', 'types.id')
			->leftjoin('chart','chart.unit','=','sensors.unit')
    		->select('chart.name as cname','sensors.*','sensors.id as sensorid', 'sensors.sensor_type as typename', 'types.brand', 'sensors.unit')
    		->get();

    		$types = DB::table('types')->get();
    		//echo "hai";
    		return view('admin.sensor.index')->with(['sensors'=>$sensors,'hubid'=>$hubid, 'user'=>$user, 'groupname'=>$groupname, 'group'=>$group, 'hubname'=>$hubname, 'types'=>$types]);
    	}
    	function importsensor(Request $request)
    	{
    		$this->validate($request, [
    		'select_file'  => 'required|mimes:xls,xlsx'
    		]);
    		$datas = Excel::toArray(new UsersImport,request()->file('select_file'));
    		foreach($datas as $key => $value)
            {				
    			foreach($value as $row)
    			{
    			    $hub_id = $request->input('hub_id');
    				$group_id = $request->input('group_id');
    				$sensor_group_id = $request->input('sensor_group_id');
    				$type = DB::table('types')->where('sname', $row[1])->get();
    				if(count($type) == '0')
					{
						$insert_data = array(
    						//'name'     	=> $row[4],
    						'brand' => $row[3],
						    //'unit'  => $row[5],
						    'sname'  => $row[1],
    						'modal'  => $row[2],
    						'min'  => $row[7],
    						'max'  => $row[8],
    						'remark'  => $row[9],
    					);
    					if(!empty($insert_data))
    					{
    						$ins = DB::table('types')->insert($insert_data);
    						if($ins)
							{
								$sengroupsins = DB::table('types')->where('sname', $row[1])->get();
								$type_id = $sengroupsins[0]->id;
							}
    					}
					}
					else
					{
					    $insert_data = array(
    						//'name'     	=> $row[4],
    						'brand' => $row[3],
						    //'unit'  => $row[5],
						    'sname'  => $row[1],
    						'modal'  => $row[2],
    						'min'  => $row[7],
    						'max'  => $row[8],
    						'remark'  => $row[9],
    					);
    					$ins = DB::table('types')->where('sname', $row[1])->update($insert_data);
                        $sengroupsins = DB::table('types')->where('sname', $row[1])->get();
						$type_id = $sengroupsins[0]->id;
					}
    				$insert_data = array(
    					'hub_id'     	=> $hub_id,
						'sensor_id'     =>  $row[0],
						'sensor_type'   =>  $row[4],
						'unit'          =>  $row[5],
						'value'         =>  $row[6],
    					'type'          => $type_id,
    					'sensor_inform' => $row[9],
    				);
    				if(!empty($insert_data))
    				{
    					$ins = DB::table('sensors')->insert($insert_data);
    				}
    			}			
    		}	
    		return back()->with('flash_message', 'Excel Data Imported successfully.');
    	}
    	function importmulsensor(Request $request)
    	{
    		$this->validate($request, [
    		'select_file'  => 'required|mimes:xls,xlsx'
    		]);
    		$list = explode(',', $request->input('hub_id'));
    		foreach($list as $lists)
    		{
    			$datas = Excel::toArray(new UsersImport,request()->file('select_file'));
    			foreach($datas as $key => $value)
    			{				
    				foreach($value as $row)
    				{			
    					$hub_id = $lists;
    					$type = DB::table('types')->where('sname', $row[1])->get();
    					if(count($type) == '0')
    					{
    						$insert_data = array(
        						//'name'     	=> $row[4],
        						'brand' => $row[3],
    						    //'unit'  => $row[5],
    						    'sname'  => $row[1],
        						'modal'  => $row[2],
        						'min'  => $row[7],
        						'max'  => $row[8],
        						'remark'  => $row[9],
        					);
        					if(!empty($insert_data))
        					{
        						$ins = DB::table('types')->insert($insert_data);
        						if($ins)
    							{
    								$sengroupsins = DB::table('types')->where('sname', $row[1])->get();
    								$type_id = $sengroupsins[0]->id;
    							}
        					}
    					}
    					else
    					{
    					    $insert_data = array(
        						//'name'     	=> $row[4],
        						'brand' => $row[3],
    						    //'unit'  => $row[5],
    						    'sname'  => $row[1],
        						'modal'  => $row[2],
        						'min'  => $row[7],
        						'max'  => $row[8],
        						'remark'  => $row[9],
        					);
        					if(!empty($insert_data))
        					{
        						$ins = DB::table('types')->where('sname', $row[1])->update($insert_data);
        						$sengroupsins = DB::table('types')->where('sname', $row[1])->get();
								$type_id = $sengroupsins[0]->id;
        					}
    					}
    					$insert_data = array(
    						'hub_id'     	=> $hub_id,
							'sensor_id'     =>  $row[0],
							'sensor_type'   =>  $row[4],
							'unit'          =>  $row[5],
							'value'         =>  $row[6],
							'type'          => $type_id,
							'sensor_inform' => $row[9],
    					);
    					if(!empty($insert_data))
    					{
    						$ins = DB::table('sensors')->insert($insert_data);
    					}
    				}			
    			}	
    		}
    		return back()->with('flash_message', 'Excel Data Imported successfully.');
    	}
    	public function editSensorpop($id=0)
    	{
    		$user = DB::table('sensors')
    		->join('types', 'types.id', '=', 'sensors.type')
    		->where('sensors.id', '=', $id)
    		->select('sensors.*', 'sensors.id as id', 'types.*', 'sensors.unit as unit')
    		->first();
    		echo json_encode($user);
    	}
    	public function exportagent($id=0)
    	{
    		//echo $id;die();
    		return Excel::download(new AgentExport(array('agent' => $id)), 'Agents.xlsx');
    		return redirect()->back();			
        }
        public function exportgroup($id=0)
    	{
    		return Excel::download(new GroupExport(array('group' => $id)), 'Groups.xlsx');
    		return redirect()->back();			
    	}
    	public function exporthub($id=0)
    	{
    		return Excel::download(new HubExport(array('hub' => $id)), 'Hubs.xlsx');
    		return redirect()->back();			
    	}
    	public function exportsensor($id=0)
    	{
    		return Excel::download(new SensorsExport(array('sensor' => $id)), 'sensors.xlsx');
    		return redirect()->back();			
        }
        public function gethublist(Request $request)
    	{
    		$group = $request->input('group');
    		$agent = $request->input('agent');
    		$hubs = DB::table('sensor_hubs')
    		//->join('hubs', 'sensor_hubs.hub_id', '=', 'hubs.id')
    		->where('sensor_hubs.group_id', $group)
    		->where('sensor_hubs.agent', $agent)
    		->select('sensor_hubs.id as hid','sensor_hubs.*')
			->get();
			//print_r($hubs);die();
    		echo "<option value=''>Select Hub</option>";
    		foreach($hubs as $item)
    		{
    			echo "<option value='".$item->hid."'>".$item->hub_id."</option>";
    		}
    	}
    	public function getsensorlist(Request $request)
    	{
    		$hub = $request->input('hub');
    		$agent = $request->input('agent');
    		$group = $request->input('group');
    		$sensors = DB::table('sensors')
            ->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
    		->where('sensor_hubs.group_id', $group)
    		->where('sensors.hub_id', $hub)
    		->where('sensor_hubs.agent', $agent)
    		->select('sensors.*')
    		->get();
    		echo "<option value=''>Select Sensor</option>";
    		foreach($sensors as $item)
    		{
    			echo "<option value='".$item->sensor_id."'>".$item->sensor_id."</option>";
    		}
    	}
    	public function getchartlist(Request $request)
    	{
    		DB::enableQueryLog();
    		$previous_week = strtotime("-1 week +1 day");
    		$start_week = strtotime("last sunday midnight",$previous_week);
    		$end_week = strtotime("next saturday",$start_week);
    		$start_week = date("Y-m-d",$start_week);
    		$end_week = date("Y-m-d",$end_week);	
    		$sensor = $request->input('sensor');
    		$groups = DB::table('sensors')
            ->join('dbo_payloader', 'dbo_payloader.sensor_id', '=', 'sensors.sensor_id')
    		->whereRaw('dbo_payloader.sensor_id like "'.$sensor.'"')
    		->whereRaw('dbo_payloader.time between "'.$start_week.'" and "'.$end_week.'"')
    		->select(array('dbo_payloader.*',\DB::raw("DATE(dbo_payloader.time) as date")))
    		->groupBy('date')
    		->get();
    		$group=array();
    		foreach($groups as $item)
    		{
    			$timestemp = $item->time;;
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
    		return json_encode($arr);
        }
        public function dashboard($id=0)
    	{
    		$settings = DB::table('settings')->select('agent_email')->get();
    		$user = DB::select('select * from users where id='.$id);
    		$groups = DB::table('gateway_groups')
    		->join('sensor_groups', 'sensor_groups.id', '=', 'gateway_groups.sensor_group_id')
    		->where('gateway_groups.agent', $id)
    		->select('gateway_groups.*', 'gateway_groups.id as groupid', 'sensor_groups.name')
    		->orderBy('added_on', 'DESC')
    		->get();
    		$logs = DB::select('select * from log_details where userid = '.$id);
    		$list = DB::table('weather')
    		->join('loc', 'loc.id', '=', 'weather.locid')
    		->where('weather.userid', $id)
    		->select('weather.*', 'weather.id as id', 'loc.loc', 'loc.template')
            ->first();
    		$groups_count = count($groups);
    		$hubs = DB::table('sensor_hubs')->where('agent', $id)->get();
    		$hubs_count = count($hubs);
    		$sensors = DB::table('sensors')
    		->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
    		->where('sensor_hubs.agent', $id)
    		->get();
			$sensors_count = count($sensors);
			/*$sensorlists = DB::table('dbo_payloader')
				->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')
				->where('sensor_hubs.agent', $id)
				->orderby('dbo_payloader.id', 'desc')
				->select('dbo_payloader.*')
				->paginate(100);*/
                $sensorlists =array();
    		return view('admin.agents.dashboard')->with([
    			'user'=>$user,
    			'settings'=>$settings,
    			'sensors_count'=>$sensors_count,
    			'groups'=>$groups,
    			'groups_count'=>$groups_count,
    			'hubs_count'=>$hubs_count,
    			'logs' => $logs,
				'list' => $list,
				'sensorlists' => $sensorlists,'agentid'=>$id
    		]);
    	}

        function dashsensedetails(){
$agentid=$_GET['agentid'];
/*$sensorlists = DB::table('dbo_payloader')->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloader.hub')->take(100)->where('sensor_hubs.agent',$agentid)->orderby('dbo_payloader.id', 'desc')->select('time','dbo_payloader.hub','sensor_id','value')->get();*/
/*$sensorlists = DB::table('dbo_payloadercharttemphub')
            ->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'dbo_payloadercharttemphub.hub')->join('sensors','sensors.hub_id','=','sensor_hubs.id')
            ->where('sensors.agent',$agentid)
            ->orderby('dbo_payloadercharttemphub.id', 'desc')
            ->select('time','dbo_payloadercharttemphub.hub','dbo_payloadercharttemphub.sensor_id','dbo_payloadercharttemphub.value')->take(100)->get();*/
//dd($agentid);
/*$sensorlists = DB::table('dbo_payloader as db')
            ->join('sensor_hubs', 'sensor_hubs.hub_id', '=', 'db.hub')->join('sensors','sensors.hub_id','=','sensor_hubs.id')
            ->where('sensors.agent',$agentid)
            ->orderby('db.id', 'desc')->take(100)
            ->select('db.time','db.hub','db.sensor_id','db.value')->get();*/

/*$sensorlists = DB::table('dbo_payloader as db')
            ->join('sensors as se','se.sensor_id','=','db.sensor_id')
            ->where('se.agent',$agentid)->take(100)
            ->orderby('db.time', 'desc')
            ->select('db.utc','db.hub','db.sensor_id','db.value')->get();*/
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

return view('admin.agents.dashconsole')->with([                
                'sensorlists' => $sensorlists,'agentid'=>$agentid
            ]);


        }
    	function importgroupname(Request $request)
    	{
    		$this->validate($request, [
    		'select_file'  => 'required|mimes:xls,xlsx'
    		]);
    		$datas = Excel::toArray(new UsersImport,request()->file('select_file'));
    		foreach($datas as $key => $value)
    		{				
    			foreach($value as $row)
    			{	
    				$userscus = DB::table('sensor_groups')->where('name', $row[0])->get();
    				if(count($userscus) == '0')
    				{
    					$insert_data = array(
    						'name'     	=> $row[0],
    					);
    					if(!empty($insert_data))
    					{
    						$ins = DB::table('sensor_groups')->insert($insert_data);
    					}
    				}
    			}			
    		}	
    		return back()->with('flash_message', 'Excel Data Imported successfully.');
    	}
    	function importhubname(Request $request)
    	{
    		$this->validate($request, [
    		'select_file'  => 'required|mimes:xls,xlsx'
    		]);
    		$datas = Excel::toArray(new UsersImport,request()->file('select_file'));
    		foreach($datas as $key => $value)
    		{				
    			foreach($value as $row)
    			{	
    				$userscus = DB::table('hubs')->where('name', $row[0])->get();
    				if(count($userscus) == '0')
    				{
    					$insert_data = array(
    						'name'     	=> $row[0],
    					);
    					if(!empty($insert_data))
    					{
    						$ins = DB::table('hubs')->insert($insert_data);
    					}
    				}
    			}			
    		}	
    		return back()->with('flash_message', 'Excel Data Imported successfully.');
    	}
    	function importunit(Request $request)
    	{
    		$this->validate($request, [
    		'select_file'  => 'required|mimes:xls,xlsx'
    		]);
    		$datas = Excel::toArray(new UsersImport,request()->file('select_file'));
    		foreach($datas as $key => $value)
    		{				
    			foreach($value as $row)
    			{	
    				$insert_data = array(
    					'minimum'   => $row[0],
    					'maximum'   => $row[1],
    					'unit'     	=> $row[2],
    				);
    				if(!empty($insert_data))
    				{
    					$ins = DB::table('measurement_units')->insert($insert_data);
    				}
    			}			
    		}	
    		return back()->with('flash_message', 'Excel Data Imported successfully.');
    	}
    	function importtype(Request $request)
    	{
    		$this->validate($request, [
    		'select_file'  => 'required|mimes:xls,xlsx'
    		]);
    		$datas = Excel::toArray(new UsersImport,request()->file('select_file'));
    		foreach($datas as $key => $value)
    		{				
    			foreach($value as $row)
    			{	
    				$userscus = DB::table('types')->where('sname', $row[0])->get();
    				if(count($userscus) == '0')
    				{
    					$insert_data = array(
    						//'name'     	=> $row[3],
    						'brand' => $row[2],
						    //'unit'  => $row[4],
						    'sname'  => $row[0],
    						'modal'  => $row[1],
    						'min'  => $row[3],
    						'max'  => $row[4],
    						'remark'  => $row[5],
    					);
    					if(!empty($insert_data))
    					{
    						$ins = DB::table('types')->insert($insert_data);
    					}
    				}
    				else
    				{
    				    $insert_data = array(
    						//'name'     	=> $row[3],
    						'brand' => $row[2],
						    //'unit'  => $row[4],
						    'sname'  => $row[0],
    						'modal'  => $row[1],
    						'min'  => $row[3],
    						'max'  => $row[4],
    						'remark'  => $row[5],
    					);
    					if(!empty($insert_data))
    					{
    						$ins = DB::table('types')->where('sname', $row[0])->update($insert_data);
    					}
    				}
    			}			
    		}	
    		return back()->with('flash_message', 'Excel Data Imported successfully.');
    	}
    	function importbrand(Request $request)
    	{
    		$this->validate($request, [
    		'select_file'  => 'required|mimes:xls,xlsx'
    		]);
    		$datas = Excel::toArray(new UsersImport,request()->file('select_file'));
    		foreach($datas as $key => $value)
    		{				
    			foreach($value as $row)
    			{	
    				$userscus = DB::table('brands')->where('name', $row[0])->get();
    				if(count($userscus) == '0')
    				{
    					$insert_data = array(
    						'name'     	=> $row[0],
    					);
    					if(!empty($insert_data))
    					{
    						$ins = DB::table('brands')->insert($insert_data);
    					}
    				}
    			}			
    		}	
    		return back()->with('flash_message', 'Excel Data Imported successfully.');
    	}
    	public function exportgroupname()
    	{
    		return Excel::download(new GroupnameExport, 'groupname.xlsx');
    		return redirect()->back();			
    	}
    	public function exporthubname()
    	{
    		return Excel::download(new HubnameExport, 'Hubname.xlsx');
    		return redirect()->back();			
    	}
    	public function exportunit()
    	{
    		return Excel::download(new UnitExport, 'Unit.xlsx');
    		return redirect()->back();			
    	}
    	public function exporttype()
    	{
    		return Excel::download(new TypeExport, 'Type.xlsx');
    		return redirect()->back();			
    	}
    	public function exportbrand()
    	{
    		return Excel::download(new BrandExport, 'Brand.xlsx');
    		return redirect()->back();			
    	}
    	function createsensorgraph(Request $request)
    	{
    		$insert_data = array(
    			'agent'     => $request->input('agent'),
    			'sensor_id' => $request->input('grapheid'),
    			//'type'      => $request->input('type'),
    			'title'     => $request->input('title'),
    			'yaxis'     => $request->input('yaxis'),
    			'min'       => $request->input('min'),
    			'max'       => $request->input('max'),
    			'fake'      => $request->input('fake'),
    		);
    		if(!empty($insert_data))
    		{
    			$ins = DB::table('sensor_graph')->insert($insert_data);
    		}
    	}
    	function editgraph($id=0)
    	{
			//echo $id;die();
    		$data = DB::table('sensors')
				->join('sensor_graph', 'sensor_graph.sensor_id', '=', 'sensors.id')
				->join('types', 'types.id', '=', 'sensors.type')
				->join('chart', 'chart.unit', '=', 'sensors.unit')
				->where('sensor_graph.sensor_id', '=', $id)
				->where('sensors.id', '=', $id)
				->select('chart.name as cname','sensor_graph.*', 'types.*', 'sensor_graph.id as graphid', 'types.min as mingraph', 'types.max as maxgraph', 'sensors.sensor_type', 'sensors.unit as sensorunit', 'chart.name')
				->first();
		    echo json_encode($data);
    	}
    	function updategraph(Request $request)
    	{
    		$id = $request->input('grapheid');
    		$insert_data = array(
    			//'type'      => $request->input('type'),
    			'title'     => $request->input('title'),
    			'yaxis'     => $request->input('yaxis'),
    			'min'       => $request->input('min'),
    			'max'       => $request->input('max'),
    			'fake'      => $request->input('fake'),
    		);
    		if(!empty($insert_data))
    		{
    			$ins = DB::table('sensor_graph')->where('id', $id)->update($insert_data);
    		}
    		return back()->with('flash_message', 'Update Successfully');
    	}
        function sensortype($id=0)
    	{
    	    //echo $id;die();
    		$data = DB::table('types')->where('id', '=', $id)->first();
    		echo json_encode($data);
    	}
    	function addgraph($type=0)
    	{
			$data = DB::table('sensors')
			->join('types', 'types.id', '=', 'sensors.type')
			->join('chart', 'chart.unit', '=', 'sensors.unit')
			->select('types.sname', 'types.modal', 'types.brand', 'types.min', 'types.max', 'sensors.sensor_type', 'sensors.unit', 'chart.name')
			->where('sensors.id', $type)
            ->first();
			//data = DB::table('types')->where('id', '=', $type)->first();
			//echo $data->name;die();
    		echo json_encode($data);
    	}
    	function profileimport(Request $request)
    	{
    		$this->validate($request, [
    		'select_file'  => 'required|mimes:xls,xlsx'
    		]);
    		//echo $request->input('profileagentid');die();
			$datas = Excel::toArray(new UsersImport,request()->file('select_file'));
			$masterexist1="";
            $masterexist[]=array();
    		foreach($datas as $key => $value)
            {	
				$r = 0;			
    			foreach($value as $row)
    			{
					//echo $row[9];die();
					//$s = date('d-m-Y', strtotime($row[10]));
					if($row[8] == date('d-m-Y',strtotime( $row[8])))
					{
						$date1 = $row[8];
					}
					else
					{
						$unix_date = ($row[8] - 25569) * 86400;
						$excel_date = 25569 + ($unix_date / 86400);
						$unix_date = ($excel_date - 25569) * 86400;
						$date1 =  gmdate("d-m-Y", $unix_date);
					}
					if($row[9] == date('d-m-Y', strtotime($row[9])))
					{
						$date2 = $row[9];
					}
					else
					{
						$unix_date1 = ($row[9] - 25569) * 86400;
						$excel_date1 = 25569 + ($unix_date1 / 86400);
						$unix_date1 = ($excel_date1 - 25569) * 86400;
						$date2 = gmdate("d-m-Y", $unix_date1);
					}
					$hashpassword = Hash::make($row[11]);
    				$insert_data = array
    				(
    					'fname'         => $row[0],
    					'lname'         => $row[1],
    					'email'         => $row[10],
    					'corporate_name'=> $row[2],
    					'street'        => $row[3],
    					'city'          => $row[4],
    					'state'         => $row[5],
    					'post_code'     => $row[6],
    					'country'       => $row[7],
    					'service_start' => $date1,
    					'service_expiry'=> $date2,
    					'remark'        => $row[12],
    					'password'      => $hashpassword,
    					'original'      => $row[11],
					);
					//print_r($insert_data);die();
    				$userscusid = DB::table('users')->where('email', $row[10])->get();
    				//echo count($userscusid);die();
    				if(count($userscusid) == '0')
    				{
						//echo $row[0];
    				    $cus_id = DB::table('users')->orderBy('id', 'desc')->first();							
    			        $cusid = $cus_id->customer_id++;
        				$cusid = substr($cusid, 3, 5);
        				$cusid = (int) $cusid + 1;
        				$cusid = "AG" . sprintf('%04s', $cusid);
    					$userscus = DB::table('users')->where('email', $row[10])->get();
    					// if(count($userscus) == '0')
    					// {
    					    $data = array(
        						'fname'         => $row[0],
        						'lname'         => $row[1],
        						'email'         => $row[10],
        						'customer_id'   => $cusid,
        						'corporate_name'=> $row[2],
        						'street'        => $row[3],
        						'city'          => $row[4],
        						'state'         => $row[5],
        						'post_code'     => $row[6],
        						'country'       => $row[7],
        						'service_start' => $date1,
        						'service_expiry'=> $date2,
        						'remark'        => $row[12],
        						'password'      => $hashpassword,
        						'original'      => $row[11],
        					);
    						$ins = DB::table('users')->insert($data);
    						if($ins)
    						{
    							$userid = DB::table('users')->where('email', $row[10])->get();
    							$insertrole = DB::table('role_user')->insert(array('user_id' => $userid[0]->id, 'role_id' => '2'));
    						}
						//}
						Session::flash('jsAlert', 'Profile Import Successfully.');						
    				}
    				else
    				{
						//print_r($insert_data);die();
						$value = DB::table('users')
						->where('email', $row[10])
						->update($insert_data);	
						$masterexist[$r]=$row[10];
						$masterexist1.=$row[10].",";
						Session::flash('jsAlert1', 'This email '.trim($masterexist1,',').' already in list');
    				}	
				}
				//die();		
    		}		
			//return back()->with('flash_message', 'Profile Update Successfully.');
			return back()->with('flash', 'hi');
		}
		private function transformDateTime(string $value, string $format = 'Y-m-d')
		{
			try {
					return Carbon::instance(Date::excelToDateTimeObject($value))->format($format);
				} catch (\ErrorException $e) {
					return Carbon::createFromFormat($format, $value);
				}
		}
    	function groupeditimport(Request $request)
    	{
    		$this->validate($request, [
    		'select_file'  => 'required|mimes:xls,xlsx'
    		]);
			$datas = Excel::toArray(new UsersImport,request()->file('select_file'));
			$masterexist1="";
            $masterexist[]=array();
    		foreach($datas as $key => $value)
            {	
				$r=0;						
    			foreach($value as $row)
    			{				
    				$sengroups = DB::table('sensor_groups')->where('name', $row[0])->get();
					if(count($sengroups) == '0')
					{
						$insert_data = array(
							'name'     	=> $row[0],
						);
						if(!empty($insert_data))
						{
							$ins = DB::table('sensor_groups')->insert($insert_data);
							if($ins)
							{
								$sengroupsins = DB::table('sensor_groups')->where('name', $row[0])->get();
								$sensor_group_id = $sengroupsins[0]->id;
							}							
						}
						Session::flash('jsAlert', 'Excel Data Imported successfully.');				
					}
					else
					{
						//print_r($row[0]);die();
						if(!empty($sengroups[0]->id)) 
						{
							$sensor_group_id = $sengroups[0]->id;
						}
						else
						{
							$sensor_group_id = '';
						}
						$masterexist[$r]=$row[0];
						$masterexist1.=$row[0].",";
						Session::flash('jsAlert1', 'This gateway group name '.trim($masterexist1,',').' already in list');
					}
					$insert_data = array(
						'sensor_group_id'   => $sensor_group_id,
						'sim_no'            => $row[1],
						'router_sensor_no'  => $row[2],
						'latitude'          => $row[3],
						'longitude'         => $row[4],
						'sensor_information'=> $row[5],
					);
					if(empty($row[6]))
					{
						$userscus = DB::table('gateway_groups')->where('latitude', $row[3])->where('longitude', $row[4])->where('agent', $request->input('agentid'))->get();
						if(count($userscus) == '0')
						{
							$cus_id = DB::table('gateway_groups')->orderBy('id', 'desc')->first();							
							$cusid = $cus_id->group_id++;				
							$cusid = substr($cusid, 3, 5);
							$cusid = (int) $cusid + 1;
							$cusid = "GW" . sprintf('%04s', $cusid);
							$data = array(
								'group_id'          => $cusid,
								'agent'             => $request->input('agentid'),
								'sensor_group_id'   => $sensor_group_id,
								'sim_no'            => $row[1],
								'router_sensor_no'  => $row[2],
								'latitude'          => $row[3],
								'longitude'         => $row[4],
								'sensor_information'=> $row[5],
							);
							if(!empty($data))
							{
								$ins = DB::table('gateway_groups')->insert($data);
								//Session::flash('jsAlert', 'Excel Data Imported successfully.');
							}
						}
					}
					else
					{
						$userscusid = DB::table('gateway_groups')->where('group_id', $row[6])->get();
						//echo count($userscusid);
						if(count($userscusid) == '0')
						{
							$userscus = DB::table('gateway_groups')->where('latitude', $row[3])->where('longitude', $row[4])->where('agent', $request->input('agentid'))->get();
							if(count($userscus) == '0')
							{
								$cus_id = DB::table('gateway_groups')->orderBy('id', 'desc')->first();							
								$cusid = $cus_id->group_id++;				
								$cusid = substr($cusid, 3, 5);
								$cusid = (int) $cusid + 1;
								$cusid = "GW" . sprintf('%04s', $cusid);
								$data = array(
									'group_id'          => $cusid,
									'agent'             => $request->input('agentid'),
									'sensor_group_id'   => $sensor_group_id,
									'sim_no'            => $row[1],
									'router_sensor_no'  => $row[2],
									'latitude'          => $row[3],
									'longitude'         => $row[4],
									'sensor_information'=> $row[5],
								);
								if(!empty($data))
								{
									$ins = DB::table('gateway_groups')->insert($data);
								}
							}
						}
						else
						{
							if(!empty($insert_data))
							{
								$ins = DB::table('gateway_groups')->where('group_id', $row[6])->update($insert_data);
							}
						}
					}
    			}				
    		}
    		return back()->with('flash', 'Group update successfully.');
    	}
    	function hubeditimport(Request $request)
    	{
    		$this->validate($request, [
    		'select_file'  => 'required|mimes:xls,xlsx'
    		]);
    		$datas = Excel::toArray(new UsersImport,request()->file('select_file'));
            $dup="";
			$dup1="";
			$masterexist1="";
			$masterexist[]=array();
			$masterexist1new="";
			$masterexistnew[]=array();
			
			$masterexisthub1="";
			$masterexisthub[]=array();
    		foreach($datas as $key => $value)
            {	
				$r = 0;						
    			foreach($value as $row)
    			{				
    				
    				$insert_data = array(
    					'hub_id'            => $row[0],
    					'mac_id'            => $row[1],
    					'hub_inform'        => $row[2],
					);
					$group_id = $request->input('group_id');
					if(empty($row[3]))
					{
						$group_id = $request->input('group_id');
						$agent = $request->input('agent');
						$hubcnt = DB::table('sensor_hubs')->where('hub_id', $row[0])->where('group_id', $group_id)->get();
						if(count($hubcnt) == '0')
						{							
							$cus_id = DB::table('sensor_hubs')->orderBy('id', 'desc')->first();							
							$cusid = $cus_id->sensor_hub_id++;				
							$cusid = substr($cusid, 3, 5);
							$cusid = (int) $cusid + 1;
							$cusid = "SH" . sprintf('%04s', $cusid);
							$sensor_group_id = $request->input('sensor_group_id');
							$data = array(
								'sensor_hub_id'     => $cusid,
								'agent'             => $agent,
								'group_id'          => $group_id,
								'sensor_group_id'   => $sensor_group_id,
								'hub_id'            => $row[0],
								'mac_id'            => $row[1],
								'hub_inform'        => $row[2],
							);
							if(!empty($data))
							{
								//if(empty($row[3]))
								$checkmasterexist=DB::table('sensordata')->where('hub', $row[0])->count();
								if ($checkmasterexist>0)
								{
									$maccnt = DB::table('sensor_hubs')->where('mac_id', $row[1])->where('hub_id', $row[0])->count();
									if ($maccnt==0)
									{
										$ins = DB::table('sensor_hubs')->insert($data);
										Session::flash('jsAlert', 'Excel Data Imported successfully.');
									}
									else
									{
										$dup=$dup.$row[1].",";
										$masterexist[$r]=$row[1];
										$masterexist1.=$row[1].",";
										Session::flash('jsAlert1', 'This mac_id '.trim($masterexist1,',').' already in list');
									}
								}
								else
								{	
									$masterexisthub[$r] = $row[0];
									$masterexisthub1.=$row[0].",";
									Session::flash('jsAlert4', 'Rejected : '.trim($masterexisthub1,',').' this sensor hub not in the hub list');
								}
							}
						}
						else
						{
							$masterexistnew[$r] = $row[0];
							$masterexist1new.=$row[0].",";
							Session::flash('jsAlert2', 'This sensor hubs '.trim($masterexist1new,',').' already in list');	
						}
					}
					else
					{
						$userscusid = DB::table('sensor_hubs')->where('sensor_hub_id', $row[3])->get();
						//$userscusid = DB::table('sensor_hubs')->where('sensor_hub_id', $row[3])->where('group_id', $group_id)->get();
						if(count($userscusid) == '0')
						{
							$group_id = $request->input('group_id');
							$agent = $request->input('agent');
							$hubcnt = DB::table('sensor_hubs')->where('hub_id', $row[0])->where('group_id', $group_id)->get();
							if(count($hubcnt) == '0')
							{							
								$cus_id = DB::table('sensor_hubs')->orderBy('id', 'desc')->first();							
								$cusid = $cus_id->sensor_hub_id++;				
								$cusid = substr($cusid, 3, 5);
								$cusid = (int) $cusid + 1;
								$cusid = "SH" . sprintf('%04s', $cusid);
								$sensor_group_id = $request->input('sensor_group_id');
								$data = array(
									'sensor_hub_id'     => $cusid,
									'agent'             => $agent,
									'group_id'          => $group_id,
									'sensor_group_id'   => $sensor_group_id,
									'hub_id'            => $row[0],
									'mac_id'            => $row[1],
									'hub_inform'        => $row[2],
								);
								if(!empty($data))
								{
									$checkmasterexist=DB::table('sensordata')->where('hub', $row[0])->count();
									if ($checkmasterexist>0)
									{				
										$maccnt = DB::table('sensor_hubs')->where('mac_id', $row[1])->where('hub_id', $row[0])->count();
										if ($maccnt==0)
										{
											$ins = DB::table('sensor_hubs')->insert($data);
											Session::flash('jsAlert', 'Excel Data Imported successfully.');
										}
										else
										{
											$dup=$dup.$row[1].",";
											$masterexist[$r]=$row[1];
											$masterexist1.=$row[1].",";
											Session::flash('jsAlert1', 'This mac_id '.trim($masterexist1,',').' already in list');
										}
									}
									else
									{	
										$masterexisthub[$r] = $row[0];
										$masterexisthub1.=$row[0].",";
										Session::flash('jsAlert4', 'Rejected : '.trim($masterexist1new,',').' this sensor hub not in the hub list');
									}
								}
							}
							else
							{
								$masterexistnew[$r] = $row[0];
								$masterexist1new.=$row[0].",";
								Session::flash('jsAlert2', 'This sensor hubs '.trim($masterexist1new,',').' already in list');	
							}
						}
						else
						{
							if(!empty($insert_data))
							{
								$ins = DB::table('sensor_hubs')->where('sensor_hub_id', $row[3])->update($insert_data);
								//Session::flash('jsAlert', 'Excel Data Imported successfully.');
								$masterexistnew[$r] = $row[0];
								$masterexist1new.=$row[0].",";
								Session::flash('jsAlert2', 'This sensor hubs '.trim($masterexist1new,',').' already in list');
							}
						}
					}
    			}				
			}
			return back()->with('flash', 'Excel Data Imported successfully.');
//             if ($dup==''){

// return back()->with('flash_message', 'Excel Data Imported successfully.');
//             }else{
//                 //$dup1=trim(',',$dup);
//                 $dup1=trim($dup,',');
// 			return back()->with('flash_message', 'Excel Data Imported successfully.Skipped Duplicate Mac ids -'.$dup1);
//             }
    	}
    	function sensoreditimport(Request $request)
    	{
			
    		$this->validate($request, [
    		'select_file'  => 'required|mimes:xls,xlsx'
    		]);
    		$datas = Excel::toArray(new UsersImport,request()->file('select_file'));
            $dup[]=array();
            $dup1="";
            $masterexist1="";
            $masterexist[]=array();
    		foreach($datas as $key => $value)
            {			$r=0;				
    			foreach($value as $row)
    			{
    			   // echo $row[8];
     				$type = DB::table('types')->where('sname', $row[1])->get();
     				if(count($type) == '0')
					{
						$insert_data = array(
    						
    						'brand' => $row[3],						    
						    'sname'  => $row[1],
    						'modal'  => $row[2],
    						/*'min'  => $row[7],
    						'max'  => $row[8],
    						'remark'  => $row[9],*/
							'min'  => $row[6],
                            'max'  => $row[7],
                            'remark'  => $row[8],


    					);
    					if(!empty($insert_data))
    					{
    						$ins = DB::table('types')->insert($insert_data);
    						if($ins)
							{
								$sengroupsins = DB::table('types')->where('sname', $row[1])->get();
								$type_id = $sengroupsins[0]->id;
								if(empty($row[10]))
								{
									$hub_id = $request->input('hub_id');
									$data = array(
										'hub_id'     	=> $hub_id,
										'sensor_id'     =>  $row[0],
										'sensor_type'   =>  $row[4],
										'unit'          =>  $row[5],
										//'value'         =>  $row[6],
										'type'          => $type_id,
										//'sensor_inform' => $row[9],
										'sensor_inform' => $row[8],
										'agent'=> $request->input('agentdrop'),
										'group_id'=>  $request->input('groupdrop'),
										'sensor_group_id'=>  $request->input('sensorgroupdrop')
									);
                                    $agentid=$request->input('agentdrop');
                                    
									if(!empty($data))
									{
										$checksensnameexist=DB::table('sensors')->where('sensor_id',$row[0])->where('agent',$agentid)->where('hub_id',$hub_id)->count();
										$checkmasterexist=DB::table('sensordata')->where('sensor_id',$row[0])->count();
										if ($checkmasterexist>0)
										{
											if ($checksensnameexist==0)
											{
												$ins = DB::table('sensors')->insert($data);
												Session::flash('jsAlert', 'Excel Data Imported successfully.');												
											}
											else
											{
												$dup[$r]=$row[0]; 
												$dup1.=$row[0].","; 
												Session::flash('jsAlert1', 'This sensors '.trim($dup1,',').' already in list');  
											}
										}
										else
										{
											$masterexist[$r]=$row[0];
											$masterexist1.=$row[0].",";
											Session::flash('jsAlert2', 'Rejected : '.trim($masterexist1,',').' this sensor not in the hub list');
										}
									}
								}
								else
								{
									$userscusid = DB::table('sensors')->where('id', $row[10])->get();
									if(count($userscusid) == '0')
									{
										$hub_id = $request->input('hub_id');
										$data = array(
											'hub_id'     	=> $hub_id,
											'sensor_id'     =>  $row[0],
											'sensor_type'   =>  $row[4],
											'unit'          =>  $row[5],
											//'value'         =>  $row[6],
											'type'          => $type_id,
											//'sensor_inform' => $row[9],
											'sensor_inform' => $row[8],
											'agent'=> $request->input('agentdrop'),
											'group_id'=>  $request->input('groupdrop'),
											'sensor_group_id'=>  $request->input('sensorgroupdrop')
										);
										if(!empty($data))
										{

							$checksensnameexist=DB::table('sensors')->where('agent',$agentid)->where('sensor_id',$row[0])->where('hub_id',$hub_id)->count();

$checkmasterexist=DB::table('sensordata')->where('sensor_id',$row[0])->count();
if ($checkmasterexist>0){
//if (($checksensnameexist==0) && ($checkmasterexist>0)){				
if ($checksensnameexist==0){

											$ins = DB::table('sensors')->insert($data);
											Session::flash('jsAlert', 'Excel Data Imported successfully.');
}else{

     //$dup[$r]=$row[0]; 
	 $dup1.=$row[0].","; 
	 Session::flash('jsAlert1', 'This sensors '.trim($dup1,',').' already in list');  
}


}else{
    $masterexist[$r]=$row[0];
	$masterexist1.=$row[0].",";
	Session::flash('jsAlert2', 'Rejected : '.trim($masterexist1,',').' this sensor not in the hub list');
}




										}
									}
									else
									{
										$insert_data = array(
											'sensor_id'     =>  $row[0],
											'sensor_type'   =>  $row[4],
											'unit'          =>  $row[5],
											//'value'         =>  $row[6],
											'type'          => $type_id,
											//'sensor_inform' => $row[9],
'sensor_inform' => $row[8],


										);
										if(!empty($insert_data))
										{
											$ins = DB::table('sensors')->where('id', $row[10])->update($insert_data);
											Session::flash('jsAlert', 'Excel Data Imported successfully.');
										}
									}
								}
							}
    					}
					}
					else
					{
					    $insert_data = array(
    						//'name'     	=> $row[4],
    						'brand' => $row[3],
						   'unit'  => $row[5],
						    'sname'  => $row[1],
    						'modal'  => $row[2],
    						/*'min'  => $row[7],
    						'max'  => $row[8],
    						'remark'  => $row[9],*/

'min'  => $row[6],
                            'max'  => $row[7],
                            'remark'  => $row[8],



    					);
    					if(!empty($insert_data))
    					{
    						$ins = DB::table('types')->where('sname', $row[1])->update($insert_data);
    						$sengroupsins = DB::table('types')->where('sname', $row[1])->get();
							$type_id = $sengroupsins[0]->id;
							if(empty($row[10]))
							{
								$hub_id = $request->input('hub_id');
								$data = array(
									'hub_id'     	=> $hub_id,
									'sensor_id'     =>  $row[0],
									'sensor_type'   =>  $row[4],
									'unit'          =>  $row[5],
									//'value'         =>  $row[6],
									'type'          => $type_id,
									//'sensor_inform' => $row[9],
									'sensor_inform' => $row[8],
									'agent'=> $request->input('agentdrop'),
									'group_id'=>  $request->input('groupdrop'),
									'sensor_group_id'=>  $request->input('sensorgroupdrop')
								);

$agentid=$request->input('agentdrop');

								if(!empty($data))
								{

$checksensnameexist=DB::table('sensors')->where('sensor_id',$row[0])->where('agent',$agentid)->where('hub_id',$hub_id)->count();
$checkmasterexist=DB::table('sensordata')->where('sensor_id',$row[0])->count();
//if (($checksensnameexist==0) && ($checkmasterexist>0)){
if (($checkmasterexist>0)){
    if ($checksensnameexist==0){
									$ins = DB::table('sensors')->insert($data);
									Session::flash('jsAlert', 'Excel Data Imported successfully.');
								}
                                    else{
                                        $dup[$r]=$row[0]; 
										 $dup1.=$row[0].","; 
										 Session::flash('jsAlert1', 'This sensors '.trim($dup1,',').' already in list');     
                                        }

						}
                        else{
    $masterexist[$r]=$row[0];
	$masterexist1.=$row[0].",";
	Session::flash('jsAlert2', 'Rejected : '.trim($masterexist1,',').' this sensor not in the hub list');
}
			
								}
							}
							else
							{
								$userscusid = DB::table('sensors')->where('id', $row[10])->get();
								if(count($userscusid) == '0')
								{
									$hub_id = $request->input('hub_id');
									$data = array(
										'hub_id'     	=> $hub_id,
										'sensor_id'     =>  $row[0],
										'sensor_type'   =>  $row[4],
										'unit'          =>  $row[5],
										//'value'         =>  $row[6],
										'type'          => $type_id,
										//'sensor_inform' => $row[9],
										'sensor_inform' => $row[8],
										'agent'=> $request->input('agentdrop'),
										'group_id'=>  $request->input('groupdrop'),
										'sensor_group_id'=>  $request->input('sensorgroupdrop')
									);
									if(!empty($data))
									{

$checksensnameexist=DB::table('sensors')->where('sensor_id',$row[0])->where('agent',$agentid)->where('hub_id',$hub_id)->count();
$checkmasterexist=DB::table('sensordata')->where('sensor_id',$row[0])->count();
//if (($checksensnameexist==0) && ($checkmasterexist>0))
if ($checkmasterexist>0)
{
if ($checksensnameexist==0){
										$ins = DB::table('sensors')->insert($data);
										Session::flash('jsAlert', 'Excel Data Imported successfully.');
                                    }
                                        else{
                                        $dup[$r]=$row[0]; 
										 $dup1.=$row[0].","; 
										 Session::flash('jsAlert1', 'This sensors '.trim($dup1,',').' already in list');     
                                        }


}else{
    $masterexist[$r]=$row[0];
	$masterexist1.=$row[0].",";
	Session::flash('jsAlert2', 'Rejected : '.trim($masterexist1,',').' this sensor not in the hub list');
}


									}
								}
								else
								{
									$insert_data = array(
										'sensor_id'     =>  $row[0],
										'sensor_type'   =>  $row[4],
										'unit'          =>  $row[5],
										//'value'         =>  $row[6],
										'type'          => $type_id,
										//'sensor_inform' => $row[9],

'sensor_inform' => $row[8],

									);
									if(!empty($insert_data))
									{
										//$ins = DB::table('sensors')->where('id', $row[9])->update($insert_data);

$ins = DB::table('sensors')->where('id', $row[8])->update($insert_data);
Session::flash('jsAlert', 'Excel Data Imported successfully.');


									}
								}
							}
    					}
					}
                    $r++;
    			}				
			}
			return back()->with('flash', 'hi');
    	}
    	public function insertgrouppop(Request $request)
    	{
    		$name = $request->input('name');	
    		$group = DB::table('sensor_groups')->where('name', $name)->get();
    		if(count($group) == '0') 
    		{
    			$data=array('name'=>$name);
    			$value=DB::table('sensor_groups')->insert($data);
    			if($value)
    			{
    				$users = DB::table("sensor_groups")->get();  				
    			}
			}
			else
			{			
				$users['error'] = "exists";
			}
			return json_encode($users);
    	}
    	public function inserthubpop(Request $request)
    	{
    		$name = $request->input('name');	
    		$group = DB::table('hubs')->where('name', $name)->get();
    		if(count($group) == '0') 
    		{
    			$data=array('name'=>$name);
    			$value=DB::table('hubs')->insert($data);
    			if($value)
    			{
    				$users = DB::table("hubs")->get();
    				return json_encode($users);
    			}
    		}
    	}
    	public function insertsensorpop(Request $request)
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
    				$users = DB::table("types")->get();
    				return json_encode($users);
    			}
    		}
    	}
        public function weather()
        {	
    		$value = DB::table('loc')->get();	
    		$agents = DB::table('users')
    		->get();
    		$user = DB::table('weather')
    		->join('loc', 'loc.id', '=', 'weather.locid')
    		->where('weather.userid', session()->get('userid'))
    		->select('loc.template')
            ->first();
    		$lists = DB::table('weather')
    		->join('users', 'users.id', '=', 'weather.userid')
    		->join('loc', 'loc.id', '=', 'weather.locid')
    		->select('weather.*', 'weather.id as id', 'loc.loc', 'loc.template', 'users.fname', 'users.lname')
            ->get();
            return view('admin.weather.index')->with(['agents' => $agents, 'value' => $value, 'lists' => $lists, 'user' => $user]);
    	}
    	public function loc()
        {	
    		$value = DB::table('loc')->get();	
            return view('admin.weather.loc')->with(['value' => $value]);
    	}
    	function insertloc(Request $request)
    	{
    		$insert_data = array(
    			'loc'      => $request->input('loc'),
    			'template' => $request->input('template'),
    		);
    		if(!empty($insert_data))
    		{
    			$ins = DB::table('loc')->insert($insert_data);
    		}	
    		return back()->with('flash_message', 'Location Added.');
    	}
    	function editloc(Request $request)
    	{
    		$insert_data = array(
    			'loc'      => $request->input('loc'),
    			'template' => $request->input('template'),
    		);
    		if(!empty($insert_data))
    		{
    			$ins = DB::table('loc')->where('id', $request->input('locid'))->update($insert_data);
    		}	
    		return back()->with('flash_message', 'Location Updated.');
    	}
    	function deleteloc()
    	{
    		$ins = DB::table('loc')->where('id', request()->val)->delete();	
    		$ins = DB::table('weather')->where('locid', request()->val)->delete();	
    		return back()->with('flash_message', 'Location Deleted.');
    	}
    	function getwea()
    	{
    		$data = DB::table('loc')->where('id', '=', request()->val)->first();
    		echo json_encode($data);
    	}
    	function insertwea(Request $request)
    	{
    		//$request->input('userid');session()->get('userid')
    		$cnt = DB::table('weather')->where('userid', $request->input('userid'))->get();
    		if(count($cnt) == '0')
    		{
        		$insert_data = array(
        			'userid'      => $request->input('userid'),
        			'locid' => $request->input('locid'),
        		);
        		if(!empty($insert_data))
        		{
        			$ins = DB::table('weather')->insert($insert_data);
        		}	
        		return back()->with('flash_message', 'Weather Added.');
    		}
    		else
    		{
    		   return back()->with('flash_message', 'Username Already Exists'); 
    		}
    	}
    	function editwea(Request $request)
    	{
    		$insert_data = array(
    			'userid'      => $request->input('userid'),
    			'locid' => $request->input('locid'),
    		);
    		//echo $request->input('weaid');die();
    		$ins = DB::table('weather')->where('id', $request->input('weaid'))->update($insert_data);	
    		return back()->with('flash_message', 'Weather Updated.');
    	}
    	function deletewea()
    	{
    		$ins = DB::table('weather')->where('id', request()->val)->delete();	
    		return back()->with('flash_message', 'Deleted.');
		}
		function fetch(Request $request)
		{
			if($request->get('query'))
			{
				$query = $request->get('query');
				$data = DB::table('dbo_payloader')
				->where('sensor_id', 'LIKE', "%{$query}%")
				->get();
				if(!empty($data[0]->sensor_id))
				{
					$output = '<ul class="dropdown-menu" style="display:block; position:relative; height:300px;overflow:scroll">';				
				}
				else
				{
					$output = '<ul class="dropdown-menu" style="display:block; position:relative;">';
				}
				foreach($data as $row)
				{
					$output .= '
					<li><a href="#">'.$row->sensor_id.'</a></li>
					';
				}
				$output .= '</ul>';
				echo $output;
			}
		}
		function fetchagent(Request $request)
		{
			if($request->get('query'))
			{
				$query = $request->get('query');
				$data = DB::table('users')
				->where('fname', 'LIKE', "%{$query}%")
				->orwhere('lname', 'LIKE', "%{$query}%")
				->get();
				if(!empty($data[0]->sensor_id))
				{
					$output = '<ul class="dropdown-menu" style="display:block; position:relative; height:300px;overflow:scroll">';				
				}
				else
				{
					$output = '<ul class="dropdown-menu" style="display:block; position:relative;">';
				}
				foreach($data as $row)
				{
					$output .= '
					<li><a href="#">'.$row->fname.' '.$row->lname.'</a></li>
					';
				}
				$output .= '</ul>';
				echo $output;
			}
		}
		function sensordata()
    	{
			//echo $_GET['val'];die();
    		$data = DB::table('sensordata')->where('sensor_id', '=', request()->val)->first();
    		echo json_encode($data);
		}
		function getsensordrop() 
    	{
			$data = DB::table('sensors')
				->join('sensor_hubs', 'sensor_hubs.id', '=', 'sensors.hub_id')
				->where('sensor_hubs.hub_id', '=', request()->val1)
				->where('sensors.sensor_id', '=', request()->val2)
				->where('sensor_hubs.agent', '=', request()->val3)
				->get();
			echo $cnt = count($data);
		}
		function gethubdrop() 
    	{
			$data = DB::table('sensor_hubs')
				->join('users', 'users.id', '=', 'sensor_hubs.agent')
				->where('sensor_hubs.hub_id', '=', request()->val2)
				->where('sensor_hubs.agent', '!=', request()->val1)
				->groupBy('sensor_hubs.agent')
				->select('users.fname')
				->get();
			//$arr = array();
			foreach($data as $datas)
			{
				$arr[] = $datas->fname;
			}
			echo $name = implode(',', $arr);
			//echo json_encode($name);
		}
		function addunit(Request $request)
    	{
    		$cnt = DB::table('chart')->where('unit', $request->input('unit'))->get();
    		if(count($cnt) == '0')
    		{
        		$insert_data = array(
        			'unit'      => $request->input('unit'),
        			'name' => $request->input('name'),
        		);
        		if(!empty($insert_data))
        		{
        			$ins = DB::table('chart')->insert($insert_data);
        		}	
        		//return back()->with('flash_message', 'Chart Added.');
$units = DB::table('chart')->get();
$measureunits = DB::table('sensordata')->groupBy('unit')->get();
    return view('admin.sensorgroups.sensorchart')->with([
                'units'   => $units,'measureunits'=>$measureunits]);

    		}
    		else
    		{
    		   //return back()->with('flash_message', 'Unit Already Exists'); 
$units = DB::table('chart')->get();
$measureunits = DB::table('sensordata')->groupBy('unit')->get();
    return view('admin.sensorgroups.sensorchart')->with([
                'units'   => $units,'measureunits'=>$measureunits]);


    		}
		}
		function editunit(Request $request)
    	{
    		$insert_data = array(
				'unit'      => $request->input('unit'),
				'name' => $request->input('name'),
			);
    		$ins = DB::table('chart')->where('id', $request->input('eid'))->update($insert_data);

$units = DB::table('chart')->get();
$measureunits = DB::table('sensordata')->groupBy('unit')->get();
    return view('admin.sensorgroups.sensunitchart')->with([
                'units'   => $units,'measureunits'=>$measureunits]);

    		//return back()->with('flash_message', 'Chart Updated.');
		}
		function deleteunit()
    	{
    		$ins = DB::table('chart')->where('id', request()->val)->delete();	
    		return back()->with('flash_message', 'Deleted.');
		}
		function hubgetinsert()
    	{
			$ins = DB::table('dbo_payloader')->groupBy('hub')->get();
			foreach($ins as $in)
			{
				$s[] = $in->hub;		
			}
			echo $sval = implode(',', $s);
			$data  = array('hub'=>$sval);
			$value=DB::table('hubdata')->where('id', '1')->update($data);	
		}
    }
?>
