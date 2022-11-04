<?php

namespace Illuminate\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use DB;

trait AuthenticatesUsers
{
    use RedirectsUsers, ThrottlesLogins;

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        //dd("jjj");
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'), ['status' => 1]);
        //return $request->only($this->username(), 'password');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {


       
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);
        session()->put('name', $this->guard()->user()->fname);
		
		$role=DB::table('role_user')
			->where('user_id',$this->guard()->user()->id)
			->get();
		session()->put('role', $role[0]->role_id);
		session()->put('userid', $this->guard()->user()->id);
		//echo $role[0]->role_id;die();
        /*DB::table('users')
            ->where('id',$this->guard()->user()->id)
            ->update(['log_status'=>'1']);*/
        date_default_timezone_set('Europe/Athens');
		$curtime = time();	
		$logid=DB::table('log_details')->insertGetId(
    		['userid' => $this->guard()->user()->id, 'login_status' => 1, 'created_at' => $curtime]
		);
		session()->put('logid',$logid);
		
		$algorithm=DB::table('algorithm')
			->where('userid',$this->guard()->user()->id)
			->get();
		session()->put('algid',@$algorithm[0]->id);
			echo session()->get('role');
           // exit;

            $userdt=DB::table('users')
            ->where('id',$this->guard()->user()->id)
            ->first();
            //dd($userdt);
        echo session()->put('userlogstatus',$userdt->log_status);
        //exit;
        //dd(session()->get('role'),session()->get('userlogstatus'));
		if ((session()->get('role')==1) && (session()->get('userlogstatus')==0))
		{
			DB::table('users')
            ->where('id',$this->guard()->user()->id)
            ->update(['log_status'=>'1']);
		$path='/home';
		}
		else if ((session()->get('role')==2) && (session()->get('userlogstatus')==0))
		{
			//dd($this->guard()->user()->id);
			DB::table('users')
            ->where('id',$this->guard()->user()->id)
            ->update(['log_status'=>'1']);
		$path='/home2';
		}
        else{

$path='/admin/multilogin';
             //return redirect()->back();
           // $path='/';

            //return redirect()->intended($path);
          //return redirect('https://accounts.google.com');
            //dd($path,"reached me");
            //$path='/';
            //return redirect('/argus/login');
            //return $this->sendFailedLoginResponse($request);
            //return $this->sendFailedLoginResponse($request);
/*$this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');*/




        }
        //dd('hello');
       // return $this->authenticated($request, $this->guard()->user())
                //?: redirect()->intended($this->redirectPath());
return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($path);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        session()->put('message','Login failed, Please check username and pasword with status active or not');
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        DB::table('users')
            ->where('id',$this->guard()->user()->id)
            ->update(['log_status'=>'0']);

//		DB::table('log_details')->insert(
//    		['userid' => $this->guard()->user()->id, 'status' => 0]
//		);
        date_default_timezone_set('Europe/Athens');
        $curtime = time();	
		DB::table('log_details')
            ->where('id',session()->get('logid'))
            ->update(['logout_status'=>'0', 'updated_at' => $curtime]);

        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //

$up=DB::table('users')
            ->where('id',session()->get('userid'))
            ->update(['log_status'=>'0']);



    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
