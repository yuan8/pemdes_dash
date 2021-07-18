<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Auth;
use HPV;
use HP;

use Storage;
use Validator;
class APIDATACtrl extends Controller
{
    //

    public function index($tahun){
        // if(file_exists(storage_path('app/public/json_desa.json'))){
        //     $desa=json_decode(file_get_contents(storage_path('app/public/json_desa.json')));
        // }else{
        //     $desa=DB::table('master_desa')->get();
        //     Storage::put('public/json_desa.json',json_encode($desa));
        // }

        $desa=[];


        $data=DB::table('tb_data as d')->where('d.type','INTEGRASI')
        ->join('tb_data_detail_map as dm','dm.id_data','=','d.id')
        ->join('master_table_map as m','m.id','=','dm.id_map')
        ->groupBy('m.id')
        ->selectRaw("m.*,d.deskripsi")
        // ->where('m.dashboard',true)
        ->orderBy('m.name','ASC')->get();

        foreach ($data as $key => $d) {
            $data[$key]->map_column=DB::table('master_column_map')->where('id_ms_table',$d->id)->get();
            # code...
        }

        return view('api.index')->with(['data'=>$data,'desa'=>$desa]);

    } 

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
    			'start'=>$startF->addMinutes($miss)->toDateTimeString(),
    			'end'=>$endF->addMinutes(($miss*-1))->toDateTimeString(),
    		);
    	}
    	else if(($nowF->gte($start1)) and ($nowF->lte($end1)) ){
    		return array(
    			'grand_access'=>true,
    			'start'=>$startF->addMinutes($miss)->toDateTimeString(),
    			'end'=>$endF->addMinutes(($miss*-1))->toDateTimeString(),
    		);
    	}else{
    		return array(
    			'grand_access'=>false,
    			'start'=>$startF->addMinutes($miss)->toDateTimeString(),
    			'end'=>$endF->addMinutes(($miss*-1))->toDateTimeString(),
    		);
    	}


    }


    function getData($tahun,$id,$kodedaerah=null){

        $USER=Auth::User()??Auth::guard('api')->User();
        // dd($USER);

    	$accept=true;

        $valid=Validator::make(['kodedaerah'=>$kodedaerah,'tahun'=>$tahun],[
            'kodedaerah'=>'min:2|required',
            'tahun'=>'numeric|min:2020|max:'.date('Y')
        ]);

        $checkTime=static::checkTime();
        $data=[];
        $daerah=[];

        if($valid->fails()){
            return array(
                    'status'=>500,
                    'status_text'=>'Fail',
                    'message'=>$valid->errors(),
                    'filters'=>$daerah??[],
                    'access_user_meta'=>[
                        'name'=>$USER->name,
                        'email'=>$USER->email,
                        'username'=>$USER->username,
                        'role'=>HPV::role_user($USER->role,$USER)['text'],
                        'token'=>$USER->api_token
                        
                    ],
                    'schedule'=>$checkTime,
                    'meta'=>$data??[],
                    'count_data'=>0,
                    'data'=>[]


            );

        }

    	$data=(array)DB::table('tb_data as d')->where([
    		'd.type'=>'INTEGRASI',
    		'd.id'=>$id
    	])->selectRaw(
    		"d.id as id_data,d.title as nama,".$tahun." as tahun, m.table as key_t,m.id as key_id"
    	)
        ->join('tb_data_detail_map as dm','dm.id_data','=','d.id')
    	->join('master_table_map as m','m.id','=','dm.id_map')
    	->first();




    	$level=HP::table_level($kodedaerah);

    	$daerah=DB::table($level['table'])
    	->selectRaw($level['column_name']." as nama_daerah, '".$level['level']."' as level,".$level['column_id']." as id_daerah")
    	->where($level['column_id'],$kodedaerah)->first();

    	if(!(($level and $checkTime['grand_access']) and ($daerah and $data)) ) {
    		$accept=false;
    	}

    	if($accept){
    		if(file_exists(storage_path('app/api-data/'.$tahun.'_'.$id.'_fill_'.$kodedaerah.'.json'))){
    			
    			$check_sum=filemtime(storage_path('app/api-data/'.$tahun.'_'.$id.'_fill_'.$kodedaerah.'.json'));

                if(Carbon::parse($check_sum)->addHours(6)->gte(Carbon::now())){
                    $data_get= json_decode(file_get_contents(storage_path('app/api-data/'.$tahun.'_'.$id.'_fill_'.$kodedaerah.'.json')));
                    $data['check_sum']=Carbon::parse($check_sum)->toDateTimeString();

                }else{
                    $data_db=static::dataGet($tahun,$data,$kodedaerah,$level);
                    $data['check_sum']=$data_db['check_sum'];
                    $data_get=$data_db['data'];

                }

                


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
	    				'text'=>''
	    			],
	    			'filters'=>$daerah??[],
	    			'access_user_meta'=>[
                        'name'=>$USER->name,
                        'email'=>$USER->email,
                        'username'=>$USER->username,
                        'role'=>HPV::role_user($USER->role,$USER)['text'],
                        'token'=>$USER->api_token
                    ],
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
        $USER=Auth::User()??Auth::guard('api')->User();


    	if($schedule['grand_access']){
            return array(
                    'status'=>500,
                    'status_text'=>'Fail',
                    'message'=>[
                        'text'=>'Data Not Found'
                    ],
                    'filters'=>$daerah??[],
                    'access_user_meta'=>$USER,
                    'schedule'=>$schedule,
                    'meta'=>$data??[],
                    'count_data'=>0,
                    'data'=>[]


                );
        }else{
            return array(
                    'status'=>500,
                    'status_text'=>'Fail',
                    'message'=>[
                        'text'=>'Schedule Get Data Not Accept'
                    ],
                    'filters'=>$daerah??[],
                    'access_user_meta'=>$USER,
                    'schedule'=>$schedule,
                    'meta'=>$data??[],
                    'count_data'=>0,
                    'data'=>[]


                );
        }

    }

    static function dataGet($tahun,$data,$kodedaerah,$level){
       
        



    	$column=DB::table('master_column_map')
    	->where('id_ms_table',$data['key_id'])
    	->where('dashboard',true)
    	->selectRaw("name,name_column as key_c,satuan,definisi,tipe_data,interval_nilai")
    	->get()->toArray();


    	$column_view=[];
    	$selectRaw="desa.kddesa as kode_desa,desa.nmdesa as nama_desa";
    	foreach ($column as $key => $c) {
    		$selectRaw.=",".$c->key_c.' as data_'.$key;
    	}

    	
    	$data_db=DB::table($data['key_t'].' as data')
    	->join('master_desa as desa','desa.kddesa','=','data.kode_desa')
    	->where('desa.kddesa','like',$kodedaerah.'%')
    	->where('data.tahun',$tahun)
    	->selectRaw($selectRaw)
    	->get()->toArray();


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

    	Storage::put(('api-data/'.$tahun.'_'.$data['id_data'].'_fill_'.$kodedaerah.'.json'),json_encode($data_get));

        if(file_exists(storage_path('app/api-data/'.$tahun.'_'.$data['id_data'].'_fill_'.$kodedaerah.'.json')) ){

         $check_sum=filemtime((storage_path('app/api-data/'.$tahun.'_'.$data['id_data'].'_fill_'.$kodedaerah.'.json')));

        }else{
            $check_sum=Carbon::now();
        }

    	return [
    		'check_sum'=>Carbon::parse($check_sum)->toDateTimeString(),
    		'data'=>$data_get
    	];


    }
}
