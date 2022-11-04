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
use Mail;

class AdminsController extends Controller
{
    public function index()
    {
		//DB::enableQueryLog();
        //abort_unless(\Gate::allows('product_access'), 403);

        //$groups = Group::all();
		
		//$users = DB::select('select * from users inner join role_user on users.id=role_user.user_id where role_user.role_id=1');
		/*Taking 10 users and showing*/
		$users = DB::table('users')
        ->join('role_user', 'role_user.user_id', '=', 'users.id')
		->where('role_user.role_id', 1)
		->orderBy('created_at', 'DESC')
        ->paginate(10);
		
		//dd(DB::getQueryLog());die();
        return view('admin.users.index')->with(['users'=>$users]);
    }
	######Admin##########
	public function addUser()
	{
		//selecting admin email id
		$settings = DB::table('settings')
		->select('admin_email')
		->get();
		return view('admin.users.create')->with(['settings'=>$settings]);
	}
	public function insertUser(Request $request)
	{
		//Adding users in users table and role table and sending email,Hash is used for creating password
		$cus_id = DB::table('users')->orderBy('id', 'desc')->first();
		$cusid = $cus_id->customer_id++;				
		$cusid = substr($cusid, 3, 5);
		$cusid = (int) $cusid + 1;
		$cusid = "AG" . sprintf('%04s', $cusid);

		$fname = $request->input('fname');
		$lname = $request->input('lname');
		$email = $request->input('username');
		$password = $request->input('password');
		$template = $request->input('template');
		$hashpassword=Hash::make($password);
		$sendmail=$request->input('sendmail');
		$customer_id=$cusid;
		
		$use = DB::table('users')
			->join('role_user', 'role_user.user_id', '=', 'users.id')
			->where('role_user.role_id', 1)
			->where('users.email', $email)
			->get();
			
		if(count($use)>0)
		{
		Session::flash('flash_message', 'Username already exists. Please choose another.');
		return redirect('admin/adduser');
		}
		else
		{		
		$data=array('fname'=>$fname,'lname'=>$lname,'email'=>$email,'password'=>$hashpassword,'original'=>$password,'email_template'=>$template,'customer_id'=>$customer_id);
		$userid=DB::table('users')->insertGetId($data);
		$value=DB::table('role_user')->insert(array('user_id'=>$userid,'role_id'=>1));
		
		if(@$sendmail=='Y')
		{
			//print_r($data);die();
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
		return redirect('admin/users');
		}
	}
	public function editUser($id=0)
	{
		//Feting data for editing a user
		$user = DB::select('select * from users where id='.$id);
		return view('admin.users.edit')->with(['user'=>$user]);
	}
	public function updateUser(Request $request)
	{


//updating a particular user and sending email

		$id = $request->input('eid');
		$user = DB::select('select * from users where id='.$id);
		$fname = $request->input('fname');
		$lname = $request->input('lname');
		$email = $request->input('username');
		
		$template = $request->input('template');
		$sendmail=$request->input('sendmail');
		$oldpassword = $request->input('oldpassword');
		$password = $request->input('password');
		$confirm = $request->input('confirm');
		
		if($oldpassword=="" and $password=="" and $confirm=="")
		{
			$data=array('fname'=>$fname,'lname'=>$lname,'email'=>$email,'email_template'=>$template,'original'=>$user[0]->original);
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
			return redirect('admin/users')->with('flash_message','Record updated successfully.');
		}
		else
		{
			if($oldpassword=="")
			{
			Session::flash('flash_message', 'Old password is mandatory');
			return redirect('admin/editUser/'.$id);
			}
			else if($password=="")
			{
			Session::flash('flash_message', 'Password is mandatory');
			return redirect('admin/editUser/'.$id);
			}
			else if($confirm=="")
			{
			Session::flash('flash_message', 'Confirm password is mandatory');
			return redirect('admin/editUser/'.$id);
			}
			else if($password!=$confirm)
			{
			Session::flash('flash_message', 'Password and Confirm password do not match');
			return redirect('admin/editUser/'.$id);
			}
			else if(!Hash::check($oldpassword, $user[0]->password))
			{
			Session::flash('flash_message', 'Old password do not match');
			return redirect('admin/editUser/'.$id);
			}
			else
			{
				//echo $sendmail;die();
				$hashpassword=Hash::make($password);
				$data=array('fname'=>$fname,'lname'=>$lname,'email'=>$email,'password'=>$hashpassword,'original'=>$password,'email_template'=>$template,);
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
				return redirect('admin/users')->with('flash_message','Record updated successfully.');
			}
		}
		
	}
	
	public function deleteUser($id=0){

//Deleting a user
    if($id != 0){
      // Delete
	  DB::table('role_user')->where('user_id', '=', $id)->delete();
      DB::table('users')->where('id', '=', $id)->delete();

      Session::flash('flash_message','Delete successfully.');
      
    }
    return redirect()->back();
    }
	######Admin##########
	
	
    




}
