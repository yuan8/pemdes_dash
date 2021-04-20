<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class SessionCtrl extends Controller
{
    //

    public function index(Request $request){
    	$data=DB::table('users as u');
    	if($request->q){
    		$data=$data->where('name','like',$request->q.'%')->orWhere('email','like',$request->q.'%');
    	}
    	$data=$data
    	->join('sessions as ss','ss.user_id','=','u.id')->paginate(15);

    	$data->appends(['q'=>$request->q]);

    	return view('admin.session.index')->with(['data'=>$data]);

    }


}
