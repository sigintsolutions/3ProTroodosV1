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
	//DB::enableQueryLog();
        //abort_unless(\Gate::allows('product_access'), 403);

        //$groups = Group::all();
		
		//$users = DB::select('select * from users inner join role_user on users.id=role_user.user_id where role_user.role_id=1');
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
		$user = DB::select('select * from users where id='.$id);
		return view('admin.users.edit')->with(['user'=>$user]);
	}
	public function updateEmail(Request $request){
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
