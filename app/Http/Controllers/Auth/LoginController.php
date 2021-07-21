<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use MyHash;
use App\User;
use Auth;
use DB;
use Validator;
use Alert;
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
        $valid=Validator::make($request->all(),[
            'email_atau_username'=>'required|min:2',
            'password'=>'required|string',
        ]);

        if($valid->fails()){
            return back()->withError();
        }

      
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $agent=User::where('email',$request->email_atau_username)
        ->orWhere([
            ['kode_daerah','=',($request->email_atau_username)],
            ['role','=',4],
        ])
        ->orWhere('username',$request->email_atau_username)
        ->orWhere('nik',str_replace('-', '', trim($request->email_atau_username)))
        ->orWhere('nip',str_replace('-', '', trim($request->email_atau_username)))
        ->first();


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
                    Alert::success('SELAMAT DATANG',$agent->name);
                    return $this->sendLoginResponse($request);

                }

            }else{
                    Alert::error('Gagal','user tidak diizinkan masuk');

            }
           
        }else{
                    Alert::error('Gagal','Periksa kembali id anda');

        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);

        
    }
}
