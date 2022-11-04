<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
//use DB;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
//         if (! $request->expectsJson()) {
//         	$up=DB::table('users')
//             ->where('id',249)
//             ->update(['log_status'=>'0']);
//             return route('login');
//         }
// $up=DB::table('users')
//             ->where('id',249)
//             ->update(['log_status'=>'0']);
// if (now()->diffInMinutes(session('lastActivityTime')) >= 5 ) { 
// $up=DB::table('users')
//             ->where('id',249)
//             ->update(['log_status'=>'0']);


// if (auth()->check() && auth()->id() > 1) {
	
// $user = auth()->user();
// $up=DB::table('users')
//             ->where('id',249)
//             ->update(['log_status'=>'0']);
// auth()->logout();

//$user->update(['log_status' =>0]);
//$this->reCacheAllUsersData();

//session()->forget('lastActivityTime');
 //return route('logout');
//return redirect(route('logout'));
//return redirect(route('users.login'));
////}

//}
//code end






    }
}
