<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class SettingCtrl extends Controller
{
    //

    public function public_tentang($tahun){
    	$data=(array)(DB::table('settings')->where('flag','TENTANG')->first()??['value'=>'','flag'=>'TENTANG']);
    	return view('admin.setting.public_tentang')->with('data',$data);
    }

    public function index($tahun){
    	$data=(array)(DB::table('settings')->where('flag','TENTANG')->first()??['value'=>'','flag'=>'TENTANG']);
    	return view('admin.setting.tentang')->with('data',$data);
    }

     public function update($tahun,Request $request){
     	foreach ($request->data as $flag => $value) {
     		# code...
     		$data=DB::table('settings')->updateOrInsert([
     			'flag'=>$flag
     		],
     		[
     			'flag'=>$flag,
     			'value'=>$value
     		]);
     	}

     	return back();
    	
    }
}
