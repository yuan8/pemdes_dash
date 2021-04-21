<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use MyHash;
use App\User;
use Auth;
use DB;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;


    protected function guard()
    {
        return Auth::guard('web');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){

        $this->validateLogin($request);

      
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $agent=User::where('email',$request->email)->first();

        if($agent){
            if($agent->is_active){
                 if(MyHash::pass_match($request->password,$agent->password)){
                    Auth::login($agent);
                    $u=Auth::User();
                    if($u){
                        if($u->role==3){
                            session(['_regional_access'=>DB::table('users_group as r')->selectRaw("rd.kode_daerah")
                                ->leftJoin('master_regional_detail as rd','rd.id_regional','=','r.id_regional')->where('r.id_user',$u->id)->get()->pluck('kode_daerah')]);
                        
                        }
                    }
                return $this->sendLoginResponse($request);

                }

            }
           
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);

        
    }
}
