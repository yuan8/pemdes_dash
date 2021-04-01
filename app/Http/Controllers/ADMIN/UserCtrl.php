<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use MyHash;
use Alert;
use Validator;

class UserCtrl extends Controller
{
    //

    public function index($tahun,Request $request){
    	$data=DB::table('users');

    	if($request->q){
    		$data=$data->where('name','like','%'.$request->q.'%');
    	}

    	$data=$data->paginate(10);

    	return view('admin.users.index')->with(['data'=>$data]);


    }

    public function up_profile($tahun,$id,Request $request){
        $u=Auth::User();
        if(($u->role==1)OR ($id=$u->id)){

            $data=[
                'name'=>$request->name,
            ];
            if($u->can('is_super')){
                $data['is_active']=($request->is_active=='true')?true:false;
                $data['role']=$request->role;
            }

            DB::table('users')->where('id',$id)->update($data);

            Alert::success('Berhasil','Update Profil User');

            if($request->action_to=='UPDATE_AND_BACKTOFORM'){
                return back();
            }else{
                return redirect()->route('admin.users.index',['tahun'=>$tahun]);
            }
        }
    }

    public function up_access($tahun,$id,Request $request){
        $u=Auth::User();

        if($u->can('is_super')){
            foreach ($request->role_group??[] as $key => $value) {
                DB::table('users_group')->insertOrIgnore([
                    'id_user'=>$id,
                    'id_regional'=>$value
                ]);

            }

              DB::table('users_group')
              ->where('id_user',$id)
              ->whereNotIn('id_regional',$request->role_group??[])->delete();

            Alert::success('Berhasil','Update Akses Berhasil');
            if($request->action_to=='UPDATE_AND_BACKTOFORM'){
                return back();
            }else{
                return redirect()->route('admin.users.index',['tahun'=>$tahun]);
            }



        }else{
            Alert::error('Access Denied','');
            return back();
        }

    }

     public function up_pass($tahun,$id,Request $request){
        $u=Auth::User();
        if(($u->can('is_super'))OR ($id=$u->id)){
            $data=[
                'password'=>MyHash::pass_encode($request->password),
            ];

                $valid=Validator::make($request->all(),[
                    'password'=>'required|min:8'
                ]);

                if($valid->fails()){                    
                    Alert::error('Error',$valid->errors()->first());
                    return back();
                }

            if(!$u->can('is_super')){
                $valid=Validator::make($request->all(),[
                    'password'=>'required|min:8|confirmed'
                ]);

                if($valid->fails()){                    
                    Alert::error('Error',$valid->errors()->first());
                    return back();

                    
                }
            }

             DB::table('users')->where('id',$id)->update($data);
            Alert::success('Berhasil','Update Password Berhasil');
            if($request->action_to=='UPDATE_AND_BACKTOFORM'){
                return back();
            }else{
                return redirect()->route('admin.users.index',['tahun'=>$tahun]);
            }
        }
    }

    public function show($tahun,$id){
    	$data=DB::table('users')->find($id);

    	if($data){
            $data_regional=DB::table('users_group')->where('id_user',$data->id)->get()->pluck('id_regional');
            $regional_list=DB::table('master_regional')->get();
    		return view('admin.users.detail')->with(['data'=>$data,'regional_list_acc'=>$data_regional,'regional_list'=>$regional_list]);
    	}

    }

    public function add($tahun){
    		return view('admin.users.add');
    }

     public function store($tahun,Request $request){

     	$data=DB::table('users')->insertOrIgnore([
     		'name'=>$request->name,
     		'email'=>$request->email,
     		'password'=>MyHash::pass_encode($request->password),
     		'role'=>in_array($request->role, [1,2])?$request->role:2,
     		'api_token'=>MyHash::encode($request->email),
     		'is_active'=>((boolean)$request->is_active)==true?true:false
     	]);

     	if($data){
     		return redirect()->route('admin.users.index',['tahun'=>$GLOBALS['tahun_access']]);
     	}


    		
    }
}
