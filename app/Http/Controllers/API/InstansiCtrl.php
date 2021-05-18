<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use HP;
class InstansiCtrl extends Controller
{
    //


    public function getInstansi($tahun,Request $request){

    	switch ($request->jenis) {
    		case 'PUSAT':
    			# code...
    			$data=DB::table('master_instansi')
    			->selectRaw("
    				id,name,'PUSAT' as jenis, image_path
    				")
    			->where('name','like','%'.$request->q.'%')
    			->get();
    			break;

    		case 'PEMDA':
    			$level=HP::table_level($request->kodedaerah)['child'];
    		
				$data=DB::table($level['table'].' as d')
				->selectRaw($level['column_id'].' as id, '.$level['column_name']." as name, null as image_path,'PEMDA' as jenis")->where($level['column_id'],'like',$request->kodedaerah.'%')->where($level['column_name'],'like','%'.$request->q.'%')
				->get();
    			break;
    		
    		default:
    			# code...
    			break;
    	}



    	return view('show_data.partials.instansi')->with(['data'=>$data]);


    }
}
