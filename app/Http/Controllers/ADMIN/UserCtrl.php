<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
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
}
