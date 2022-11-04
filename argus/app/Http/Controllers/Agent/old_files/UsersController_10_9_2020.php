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

class UsersController extends Controller
{
    public function index()
    {
        //abort_unless(\Gate::allows('product_access'), 403);

        //$groups = Group::all();
		
		//$users = DB::select('select * from users inner join role_user on users.id=role_user.user_id where role_user.role_id=1');
		$users = DB::table('users')
        ->join('role_user', 'role_user.user_id', '=', 'users.id')
		->where('role_user.role_id', 1)
        ->paginate(10);
		
        return view('admin.users.index')->with(['users'=>$users]);
    }
	######Admin##########
	public function addUser()
	{
		return view('admin.users.create');
	}
	public function insertUser(Request $request){
		$fname = $request->input('fname');
		$lname = $request->input('lname');
		$email = $request->input('username');
		$password = $request->input('password');
		$hashpassword=Hash::make($password);
		
		$data=array('fname'=>$fname,'lname'=>$lname,'email'=>$email,'password'=>$hashpassword);
		$userid=DB::table('users')->insertGetId($data);
		$value=DB::table('role_user')->insert(array('user_id'=>$userid,'role_id'=>1));
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
	public function editUser($id=0)
	{
		$user = DB::select('select * from users where id='.$id);
		return view('admin.users.edit')->with(['user'=>$user]);
	}
	public function updateUser(Request $request){
		$fname = $request->input('fname');
		$lname = $request->input('lname');
		$email = $request->input('username');
		$id = $request->input('eid');
		
		$oldpassword = $request->input('oldpassword');
		$password = $request->input('password');
		$confirm = $request->input('confirm');
		if($oldpassword=="" and $password=="" and $confirm=="")
		{
		
		$data=array('fname'=>$fname,'lname'=>$lname,'email'=>$email);
		$value=DB::table('users')
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
			return redirect('admin/users');
		}
		else
		{
		$user = DB::select('select * from users where id='.$id);
		//echo $user[0]->password.'<br>';
		//echo Hash::make($oldpassword);exit;
		//print_r($user);exit;
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
		$hashpassword=Hash::make($password);
		$data=array('fname'=>$fname,'lname'=>$lname,'email'=>$email,'password'=>$hashpassword);
		$value=DB::table('users')
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
		return redirect('admin/users');
		}
		
		}
			
		
	}
	
	public function deleteUser($id=0){

    if($id != 0){
      // Delete
	  DB::table('role_user')->where('user_id', '=', $id)->delete();
      DB::table('users')->where('id', '=', $id)->delete();

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
