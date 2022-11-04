<?php
 
namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Session;
use Hash;
//use App\Group;
use DB;


class ProfileController extends Controller
{
    public function index()
    {
	//ini_set('memory_limit', '2048M');
	//print_r(Session::all());
        //abort_unless(\Gate::allows('product_access'), 403);

        //$groups = Group::all();
		//$agents = DB::select('select * from users inner join role_user on users.id=role_user.user_id where role_user.role_id=1');
		$age = DB::table('users')
				->where('id',session()->get('userid'))
				->get();
				//print_r($agents);
        return view('agent.agents.index')->with(['age'=>$age]);
    }
}
