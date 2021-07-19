<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Hash;
use DB;
use Carbon\Carbon;

class SSOCtrl extends Controller
{
    //

    public function test(Request $request){
        $T=Carbon::now();
        $self_token=Carbon::now()->format('dmy').'.'.$request->id.'.'.Carbon::now()->format('hi');
        return ['token'=>Hash::make($self_token),
                'time'=>Carbon::now(),'Y'=>Carbon::now()->format('hi a')];
    }

    public function login(Request $request){

        $valid=Validator::make($request->all(),[
            'token'=>'required|string',
            'id'=>'required|numeric|exists:users,username'
        ]);

        if($valid->fails()){
            return response(json_encode([
                'login_status'=>500,
                'user'=>[],
                'message'=>$valid->errors()->first(),
            ]), 500)->header('Content-Type', 'application/json');
                  
        }
        if(Auth::guard('web')->check()){
            if(Auth::user()->role==4){
                if(Auth::user()->kode_daerah==$request->id){
                     return response([
                        'login_status'=>200,
                        'user'=>[
                            'name'=>Auth::user()->name,
                        ],
                        'message'=>null,

                    ], 200)->header('Content-Type', 'application/json');

                }else{
                    Auth::logout();
                }
            }
        }


        $token_acc=false;

        $token=$request->token;

        $T=Carbon::now();
        $self_token=$T->format('dmy').'.'.$request->id.'.'.$T->format('hi');
        if (Hash::check($self_token, $token)) {
            $token_acc=true;
        }

        if(!$token_acc){
            return response([
                'login_status'=>500,
                'user'=>[],
                'message'=>'token not falid',
                'Y'=>$T->format('hi'),
            ], 500)->header('Content-Type', 'application/json');

        }


        $user=DB::table('users')->where('username',$request->id)->first();

        if($user){
            Auth::loginUsingId($user->id);
            return response([
                'login_status'=>200,
                'user'=>[
                    'name'=>$user->name,
                ],
                'message'=>null,

            ], 200)->header('Content-Type', 'application/json');

        }

          return response([
                'login_status'=>500,
                'user'=>[],
                'message'=>'not found',

            ], 500)->header('Content-Type', 'application/json');
                  
    }
}
