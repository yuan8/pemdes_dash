<?php
namespace App\Http\Controllers\DASH;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class KONST extends Controller
{
	public function index(Request $request){
		$a=DB::table('data')->where('id',$request->id)->first();
		if($a){
			$title=$a->name;

		}else{
			$title='';
		}

		return view('data.const')->with([
			'title'=>$title
		]);
	}

}