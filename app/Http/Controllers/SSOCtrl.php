<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use MyHash;
use Carbon\Carbon;
use Alert;

class SSOCtrl extends Controller
{
    //

    public function List($tahun){
    	$U=Auth::User();
    	if($U->role){
    		$data=DB::table('sso_access')->where('id_user',$U->id)->get();
            foreach ($data as $key => $d) {
                $data[$key]->app_meta=config('sso_broker')[$d->app];
                # code...
            }
    		return [
    				'data'=>view('sso.list')->with('data',$data)->render()
    		];
    	}
    }

    public function add($tahun){
        $U=Auth::User();

        if($U){
            $list=config('sso_broker');
            return ['data'=>view('sso.add')->with(['list_access'=>$list])->render()];
        }else{
            return abort(500);
        }
    }

    public function login($tahun,$id){
        $range=10;
        $start=time()-(60*$range);
        $end=time()+(60*$range);
        $time=strtotime(Carbon::now());

           $id= MyHash::pass_decode($id);
           $id=explode('//', $id)[0];
            $U=Auth::User();

            $data=DB::table('sso_access')
            ->where('id',$id)
            ->where('id_user',$U->id)->first();
            if($data){  
                $broker=config('sso_broker')[$data->app];
                $sso_akses=MyHash::encode($data->email).'//'.$data->token_sso.'//'.MyHash::encode(Carbon::now());
                return view('sso.sso_login')->with(['data'=>$data,'sso_token'=>$sso_akses,'broker'=>$broker]);
            }

            return back();

    }



    public function attemp($tahun,Request $request){
        $U=Auth::User();

        $broker=isset(config('sso_broker')[$request->app_broker])?config('sso_broker')[$request->app_broker]:null;

        if($broker){
            DB::table('sso_access')->updateOrInsert([
                    'id_user'=>$U->id,
                    'app'=>$request->app_broker,
            ],[
                'email'=>$request->mail,
                'id_user'=>$U->id,
                'app'=>$request->app_broker,
                'token_sso'=>$request->password,
                'pass'=>$request->password,

                'pemda_id'=>$U->kode_daerah,
                'updated_at'=>Carbon::now()
            ]);
            Alert::success('Berhasil', 'SSO Berhasil Ditambahkan');



            // $data=trim($request->mail,true).'//'.trim($request->password.'//'.Carbon::now());
            // $data=MyHash::encode($data);


            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL,$broker['url_attemp']);
            // curl_setopt($ch, CURLOPT_POST, 1);
            // curl_setopt($ch, CURLOPT_POSTFIELDS,
            //             "_token_access=".$data);

            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // $server_output = curl_exec($ch);



            // if (!curl_errno($ch)) {

            //     $data_response=json_decode(trim($server_output,true),true);
                
            //     if($data_response['status']==200){
            //          DB::table('sso_access')->updateOrInsert([
            //         'id_user'=>$U->id,
            //         'app'=>$request->app_broker,
            //         ],[
            //             'email'=>$request->mail,
            //             'id_user'=>$U->id,
            //             'app'=>$request->app_broker,
            //             'token_sso'=>$data_response['data']['token'],
            //             'pemda_id'=>$U->kode_daerah,
            //             'updated_at'=>Carbon::now()
            //         ]);

            //              Alert::success('Berhasil', 'SSO Berhasil Ditambahkan');

            //     }

            //      curl_close($ch);

            // } else {
            //     curl_close($ch);


            // }

        }

            return back();
        


    }


    public function test_at(Request $request){
        return [
            'status'=>200,
            'status_text'=>'success',
            'data'=>[
                'token'=>'aaa'
            ]
        ];

    } 


    
}
