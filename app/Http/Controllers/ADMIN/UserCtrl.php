<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class UserCtrl extends Controller
{
    //

    public function list_user_daerah($tahun,$kodedaerah,Request $request){
    	$daerah=$request['amp;daerah'];
    	$nama_data=$request['data'];
    	$data=DB::table('users')->where('kode_daerah',$kodedaerah)->where('role',4)->get();
    	return view('admin.users.list_daerah_user')->with(['nama_data'=>$nama_data,'data'=>$data,'daerah'=>$daerah]);
    }


    public function index(){
    	
    }
}
