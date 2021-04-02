<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Auth;
use HPV;
use Storage;
class APIDATACtrl extends Controller
{
    //

    static function checkTime(){
    	$now=Carbon::now();

    	// $start=Carbon::now()->endOfDay()->addHours(-2);
    	$start=Carbon::now()->startOfDay()->addHours(-2);

    	// dd($start);

    	// jam 11 malam
    	$end=Carbon::now()->endOfDay();

    	$start1=Carbon::now()->startOfDay()->addHours(3); 
    	// jam 3 pagi
    	$end1=Carbon::now()->startOfDay();

    	$nowF=Carbon::now();
    	$startF=Carbon::now()->endOfDay()->addHours(-2);
    	$endF=Carbon::now()->endOfDay()->addHours(4);

    	$miss=10;
    	// 10 menit

    	

    	if(($nowF->gte($start)) and ($nowF->lte($end)) ){
    		return array(
    			'grand_access'=>true,
    			'start'=>$startF->addMinutes($miss),
    			'end'=>$endF->addMinutes(($miss*-1)),
    		);
    	}
    	else if(($nowF->gte($start1)) and ($nowF->lte($end1)) ){
    		return array(
    			'grand_access'=>true,
    			'start'=>$startF->addMinutes($miss),
    			'end'=>$endF->addMinutes(($miss*-1)),
    		);
    	}else{
    		return array(
    			'grand_access'=>false,
    			'start'=>$startF->addMinutes($miss)->toDateTimeString(),
    			'end'=>$endF->addMinutes(($miss*-1))->toDateTimeString(),
    		);
    	}


    }


    function getData($tahun,$id,$kodedaerah){

    	$accept=true;
    	$checkTime=static::checkTime();
    	$data=(array)DB::table('data as d')->where([
    		'd.type'=>'INTEGRASI',
    		'd.id'=>$id
    	])->selectRaw(
    		"d.id as id_data,d.name as nama,".$tahun." as tahun, m.table as key_t,m.id as key_id"
    	)
    	->join('master_table_map as m','m.key_view','=','d.table_view')
    	->first();

    	$level=HPV::level($kodedaerah);
    	$daerah=DB::table($level['parent']['table'])
    	->selectRaw($level['parent']['table_name']." as nama_daerah, '".$level['parent']['level']."' as level,".$level['parent']['table_kode']." as id_daerah")
    	->where($level['parent']['table_kode'],$kodedaerah)->first();

    	if(!(($level and $checkTime['grand_access']) and ($daerah))){
    		$accept=false;
    	}

    	if($accept){
    		if(file_exists(storage_path('app/api-data/'.$tahun.'_'.$id.'_fill_'.$kodedaerah.'.json'))){
    			$data_get= json_decode(file_get_contents(storage_path('app/api-data/'.$tahun.'_'.$id.'_fill_'.$kodedaerah.'.json')));
    			$check_sum='s';
    			$data['check_sum']=$check_sum;


    		}else{
    			$data_db=static::dataGet($tahun,$data,$kodedaerah,$level);
    			$data['check_sum']=$data_db['check_sum'];
    			$data_get=$data_db['data'];
    		}

    		if(isset($data['key_t'])){
		    		unset($data['key_t']);
		    		unset($data['key_id']);

		    	}

    		return array(
	    			'status'=>200,
	    			'status_text'=>'Success',
	    			'message'=>[
	    				'text'=>'schedule not accept'
	    			],
	    			'filters'=>$daerah??[],
	    			'access_user_meta'=>Auth::User(),
	    			'schedule'=>$checkTime,
	    			'meta'=>$data??[],
	    			'count_data'=>count($data_get),
	    			'data'=>$data_get



	    		);



    	}else{
    		return static::builderror($data,$checkTime,$daerah);
    	}

    }

    static function builderror($data,$schedule,$daerah){
    	if(isset($data['key_t'])){
    		unset($data['key_t']);
    		unset($data['key_id']);

    	}

    	return array(
	    			'status'=>500,
	    			'status_text'=>'Fail',
	    			'message'=>[
	    				'text'=>'schedule not accept'
	    			],
	    			'filters'=>$daerah??[],
	    			'access_user_meta'=>Auth::User(),
	    			'schedule'=>$schedule,
	    			'meta'=>$data??[],
	    			'count_data'=>0,
	    			'data'=>[]


	    		);

    }

    static function dataGet($tahun,$data,$kodedaerah,$level){

    	$column=DB::table('master_column_map')
    	->where('id_ms_table',$data['key_id'])
    	->where('dashboard',true)
    	->selectRaw("name,name_column as key_c,satuan,definisi,tipe_data,interval_nilai")
    	->get();

    	$column_view=[];
    	$selectRaw="desa.kode_dagri as kode_desa,desa as nama_desa";
    	foreach ($column as $key => $c) {
    		$selectRaw.=",".$c->key_c.' as data_'.$key;
    	}

    	
    	$data_db=DB::table($data['key_t'].' as data')
    	->join('master_desa as desa','desa.kode_dagri','=','data.kode_desa')
    	->where('desa.kode_dagri','like',$kodedaerah.'%')
    	->where('data.tahun',$tahun)
    	->selectRaw($selectRaw)
    	->get();

    	$data_get=[];

    	foreach ($data_db as $key => $d) {
    		# code...
    		$d=(array)$d;
    		$data_get[$key]=[
    			'kode_desa'=>$d['kode_desa'],
    			'nama_desa'=>$d['nama_desa'],
    			'data'=>[]
    		];

    		foreach ($column as $c => $v) {
    				$v=(array)$v;
    				$v['value_data']=$d['data_'.$c];
    				$data_get[$key]['data'][$c]=$v;
    		}

    	}

    	Storage::put(('/api-data/'.$tahun.'_'.$data['id_data'].'_fill_'.$kodedaerah.'.json'),json_encode($data_get));

    	$check_sum=md5_file(file_get_contents(storage_path('app/api-data/'.$tahun.'_'.$data['id_data'].'_fill_'.$kodedaerah.'.json')));


    	return [
    		'check_sum'=>$check_sum,
    		'data'=>$data_get
    	];


    }
}
