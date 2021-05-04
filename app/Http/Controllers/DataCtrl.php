<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class DataCtrl extends Controller
{
    //


    public function index($tahun,Request $request){
    	$data=DB::table('tb_data as dt')
    	->whereRaw(
    		"(
    			(CASE WHEN(dt.type <> 'INTEGRASI') THEN dt.tahun=".$tahun." else dt.tahun>=".$tahun." end) 
    		) AND (
    		dt.deskripsi like '%".$request->q."%' OR dt.title like '%".$request->q."%' OR dt.deskripsi_min like '%".$request->q."%' OR dt.keywords like '%".$request->q."%'

    		)  "
    	)
    	->leftJoin('tb_data_instansi as di','di.id_data','=','dt.id')
    	->leftJoin('master_instansi as in','in.id','=','di.id_instansi')
    	->selectRaw("dt.*,in.id as i_id,in.name as i_nama")
    	->paginate(10);


    	return view('data.index')->with(['data'=>$data]);

    }


    public function detail($tahun,$d,$slug){
        $data=DB::table('tb_data as dt')->where('dt.id',$d)
        ->leftJoin('tb_data_detail_map as dtm','dtm.id_data','=','dt.id')
        ->leftJoin('master_table_map as map','map.id','=','dtm.id_map')
        ->selectRaw("dt.*,dtm.id_map,map.inheritance,map.start_level,map.stop_level")
        ->where('type','INTEGRASI')->first();
        if($data){
            return view('show_data.integrasi')->with('data',$data);
        }
    }


    
}
