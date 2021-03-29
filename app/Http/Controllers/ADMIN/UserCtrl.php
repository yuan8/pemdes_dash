<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use MyHash;

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

    public function show($tahun,$id){
    	$data=DB::table('users')->find($id);

    	if($data){
            $data_regional=DB::table('users_group')->where('id_user',$data->id)->get();
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
     		'role'=>$request->role,
     		'api_token'=>MyHash::encode($request->email),
     		'is_active'=>$request->is_active
     	]);

     	if($data){
     		return redirect()->route('admin.users.index',['tahun'=>$GLOBALS['tahun_access']]);
     	}


    		
    }
}
