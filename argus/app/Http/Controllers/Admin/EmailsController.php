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

class EmailsController extends Controller
{
    public function index()
    {
	//fetching from settings table
		$users = DB::table('settings')
		->get();
		$count=count($users);
		//dd(DB::getQueryLog());die();
        return view('admin.emails.index')->with(['users'=>$users,'usercount'=>@$count]);
    }
	######Admin##########
	public function addUser()
	{
		return view('admin.users.create');
	}
	public function insertEmail(Request $request){


		//Adding users table
		$email = $request->input('email');
		$data=array('admin_email'=>$email);
		$userid=DB::table('settings')->insertGetId($data);
		$data2=array('email_template'=>$email);
		$value=DB::table('users')
			->join('role_user', 'role_user.user_id', '=', 'users.id')
			->where('role_user.role_id',1)
            ->update($data2);
		
		if($userid)
		{
		echo $userid;
		//Session::flash('flash_message', 'Record inserted successfully.');
		}
		else
		{
		//Session::flash('flash_message', 'Error !!!.');
		echo "Error !!!.<br/>";
		//echo '<a href = "/insert">Click Here</a> to go back.';
		}
		//return redirect('admin/users');
	}
	public function insertEmail2(Request $request){

		//Adding users table
		$email = $request->input('email2');
		$data=array('agent_email'=>$email);
		$userid=DB::table('settings')->insertGetId($data);
		$data2=array('email_template'=>$email);
		$value=DB::table('users')
			->join('role_user', 'role_user.user_id', '=', 'users.id')
			->where('role_user.role_id',2)
            ->update($data2);
		
		if($userid)
		{
		echo $userid;
		//Session::flash('flash_message', 'Record inserted successfully.');
		}
		else
		{
		//Session::flash('flash_message', 'Error !!!.');
		echo "Error !!!.<br/>";
		//echo '<a href = "/insert">Click Here</a> to go back.';
		}
		//return redirect('admin/users');
	}
	
	public function editUser($id=0)
	{

		//Fetching from users table;
		$user = DB::select('select * from users where id='.$id);
		return view('admin.users.edit')->with(['user'=>$user]);
	}
	public function updateEmail(Request $request){

		//Updating email
		$email = $request->input('email');
		$eid = $request->input('eid');
		$data=array('admin_email'=>$email);
		$userid=DB::table('settings')
			->where('id',$eid)
			->update($data);
		$data2=array('email_template'=>$email);
		$value=DB::table('users')
			->join('role_user', 'role_user.user_id', '=', 'users.id')
			->where('role_user.role_id',1)
            ->update($data2);
		
		if($userid)
		{
		echo $userid;
		//Session::flash('flash_message', 'Record inserted successfully.');
		}
		else
		{
		//Session::flash('flash_message', 'Error !!!.');
		echo "Error !!!.<br/>";
		//echo '<a href = "/insert">Click Here</a> to go back.';
		}
	}
	public function updateEmail2(Request $request){

		//Updating email id
		$email = $request->input('email2');
		$eid = $request->input('eid');
		$data=array('agent_email'=>$email);
		$userid=DB::table('settings')
			->where('id',$eid)
			->update($data);
		$data2=array('email_template'=>$email);
		$value=DB::table('users')
			->join('role_user', 'role_user.user_id', '=', 'users.id')
			->where('role_user.role_id',2)
            ->update($data2);
		
		if($userid)
		{
		echo $userid;
		//Session::flash('flash_message', 'Record inserted successfully.');
		}
		else
		{
		//Session::flash('flash_message', 'Error !!!.');
		echo "Error !!!.<br/>";
		//echo '<a href = "/insert">Click Here</a> to go back.';
		}
	}
	public function deleteUser($id=0){


//deleting user
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
