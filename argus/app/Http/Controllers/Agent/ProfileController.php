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
	
	//Fetching user
		$age = DB::table('users')
				->where('id',session()->get('userid'))
				->get();
				//print_r($agents);
        return view('agent.agents.index')->with(['age'=>$age]);
    }
}
