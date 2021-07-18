<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use MyHash;

class InitCtrl extends Controller
{
    //


    public function init(){
    	set_time_limit(-1);
    	ini_set('memory_limit', '7048M');
    	$provinsi=DB::connection('server')->table('provinsi')
    	->selectRaw("kdprovinsi, concat('PROVINSI ',nmprovinsi) as nmprovinsi")->get();

    	foreach ($provinsi as $key => $value) {
    		DB::table('master_provinsi')->insertOrIgnore((array)$value);
    		DB::table('users')->insertOrIgnore([
    			'username'=>$value->kdprovinsi,
    			'name'=>$value->nmprovinsi,
    			'email'=>$value->kdprovinsi.'@'.env('DOMAIN_MAIL'),
    			'password'=>MyHash::pass_encode('admin_'.$value->kdprovinsi),
    			'nip'=>$value->kdprovinsi.'-',
    			'nik'=>$value->kdprovinsi.'-',
    			'main_daerah'=>true,
    			'role'=>4,
    			'kode_daerah'=>$value->kdprovinsi,
    			'is_active'=>true,
    			'api_token'=>md5($value->kdprovinsi)

    		]);
    	}

    	$kota=DB::connection('server')->table('kabkota')
    	->selectRaw("kdkabkota, concat(case when stapem=0 then 'KAB ' else 'KOTA 'end ,nmkabkota) as nmkabkota,left(kdkabkota,2) as id_parent")->get();

    	foreach ($kota as $key => $value) {
    		
    		DB::table('master_kabkota')->insertOrIgnore((array)$value);
    		DB::table('users')->insertOrIgnore([
    			'username'=>$value->kdkabkota,
    			'name'=>$value->nmkabkota,
    			'email'=>$value->kdkabkota.'@'.env('DOMAIN_MAIL'),
    			'password'=>MyHash::pass_encode('admin_'.$value->kdkabkota),
    			'nip'=>$value->kdkabkota.'-',
    			'nik'=>$value->kdkabkota.'-',
    			'main_daerah'=>true,
    			'role'=>4,
    			'kode_daerah'=>$value->kdkabkota,
    			'is_active'=>true,
    			'api_token'=>md5($value->kdkabkota)

    		]);
    	}

    	$kc=DB::connection('server')->table('kecamatan')
    	->selectRaw("kdkecamatan, concat('KECAMATAN ',nmkecamatan) as nmkecamatan,left(kdkecamatan,4) as id_parent")->get();

    	foreach ($kc as $key => $value) {
    		
    		DB::table('master_kecamatan')->insertOrIgnore((array)$value);
    		DB::table('users')->insertOrIgnore([
    			'username'=>$value->kdkecamatan,
    			'name'=>$value->nmkecamatan,
    			'email'=>$value->kdkecamatan.'@'.env('DOMAIN_MAIL'),
    			'password'=>MyHash::pass_encode('admin_'.$value->kdkecamatan),
    			'nip'=>$value->kdkecamatan.'-',
    			'nik'=>$value->kdkecamatan.'-',
    			'main_daerah'=>true,
    			'role'=>4,
    			'kode_daerah'=>$value->kdkecamatan,
    			'is_active'=>true,
    			'api_token'=>md5($value->kdkecamatan)

    		]);
    	}



    	$desa_ignore=[];
    	$desa=DB::connection('server')->table('master_desa')
    	->selectRaw("kode_bps as kddesa, (case when stapem=0 then 'DESA ' else stapem end) as stapem , desa as nmdesa,left(kode_bps,6) as id_parent")->get();

	    	foreach ($desa as $key => $ds) {
	    		$kddesa=$ds->kddesa;
	    	$check=DB::table('master_desa')->insertOrIgnore((array)$ds);
	    	DB::table('users')->insertOrIgnore([
    			'username'=>$kddesa,
    			'name'=>$ds->nmdesa,
    			'email'=>$kddesa.'@'.env('DOMAIN_MAIL'),
    			'password'=>MyHash::pass_encode('admin_'.$kddesa),
    			'nip'=>$kddesa.'-',
    			'nik'=>$kddesa.'-',
    			'main_daerah'=>true,
    			'role'=>4,
    			'kode_daerah'=>$kddesa,
    			'is_active'=>true,
    			'api_token'=>md5($kddesa)
    		]);

	    		
	    }

	    DB::table('master_kabkota')->update([
	    	'nmprovinsi'=>DB::raw("(select nmprovinsi from master_provinsi where kdprovinsi=left(kdkabkota,2) limit 1 )")
	    ]);

	   
	    DB::table('master_kecamatan')->update([
	    	'nmprovinsi'=>DB::raw("(select nmprovinsi from master_provinsi where kdprovinsi=left(kdkecamatan,2) limit 1 )"),
	    	'nmkabkota'=>DB::raw("(select nmkabkota from master_kabkota where kdkabkota=left(kdkecamatan,4) limit 1 )"),
	    ]);

	     DB::table('master_desa')->update([
	    	'nmprovinsi'=>DB::raw("(select nmprovinsi from master_provinsi where kdprovinsi=left(kddesa,2) limit 1 )"),
	    	'nmkabkota'=>DB::raw("(select nmkabkota from master_kabkota where kdkabkota=left(kddesa,4) limit 1 )"),
	    	'nmkecamatan'=>DB::raw("(select nmkecamatan from master_kecamatan where kdkecamatan=left(kddesa,6) limit 1 )"),
	    ]);

	    // return $desa_ignore;

    	$users=[
    		[
    			'name'=>'superadmin',
    			'email'=>'super@domain.com',
    			'password'=>'TVRJek5284^444VTJOemc9',
    			'nik'=>'12345678910',
    			'nomer_telpon'=>'12345678910',
    			'api_token'=>'tok_',
    			'is_active'=>true,
    			'role'=>1,
    			'jabatan'=>'-'
    		],
    		
    	];

    	foreach ($users as $key => $d) {
    		$d['nomer_telpon'].=$key;
    		$d['nik'].=$key;
    		$d['api_token']=md5($key);

    		DB::table('users')->insertOrIgnore($d);
    	}


    	DB::table('master_table_map')->insertOrIgnore([
    		'table'=>'dash_testing_data_integrasi',
    		'name'=>'DASH TEST DATA',
    		'edit_daerah'=>TRUE,
    		'inheritance'=>TRUE,
    		'id_user'=>1
    	]);



    }

    public function initial_dataset($tahun){
    	$table=collect(DB::select("SELECT 
                TABLE_NAME
            FROM
                information_schema.tables where TABLE_SCHEMA='".env('DB_DATABASE')."' and TABLE_NAME like 'dash_%'"))->pluck('TABLE_NAME')->toArray();

    	foreach($table as $key=>$t){
    		DB::table('master_table_map')->updateOrinsert([
    			'table'=>$t
    		],[
    			'table'=>$t,
    			'name'=>strtoupper(str_replace('_',' ',str_replace('dash_','MAP ',$t))),
    			'edit_daerah'=>true,
    			'id_user'=>1

    		]);
    		$map_t=DB::table('master_table_map')->where('table',$t)->first();

    		$id_map=$map_t->id;
    		$m=DB::select(DB::raw("DESCRIBE ".$t));
            $master_c=[];
            foreach ($m as $fi => $value) {
               $field=$value->Field;
                if(!in_array($value->Field, ['kode_desa','tahun','id','status_validasi','validasi_date','updated_at','id_user_desa_ver','id_user_kec_ver','id_user_kab_valid','daftar_draf'])){
                	$type_data='string';
                	if(strpos($value->Type,'varchar')!==false){
                		$value->Type='varchar';
                	}
                	if(strpos($value->Type,'bigint')!==false){
                		$value->Type='bigint';
                	}
                	if(strpos($value->Type,'int')!==false){
                		$value->Type='int';
                	}
                	switch ($value->Type) {
                		case 'bigint':
                			$type_data='numeric';
                			break;
                		case 'bigint(20)':
                			$type_data='numeric';
                			break;
                		case 'varchar(255)':
                		$type_data='string';
                			break;
                		case 'tinyint(1)':
                		$type_data='numeric';
                			break;
                		case 'varchar(30)':
                		$type_data='string';
                			break;
                		case 'varchar':
                		$type_data='string';
                			break;
                		case 'varchar(10)':
                		$type_data='string';
                		case 'varchar(100)':
                		$type_data='string';
                			break;
                		case 'int':
                		$type_data='numeric';
                			break;
                		case 'double':
                		$type_data='numeric';
                			break;
                		default:
                		dd($value->Type);
                			// code...
                			break;
                	}
                	DB::table('master_column_map')->updateOrInsert([
                		'id_ms_table'=>$id_map,
                		'name_column'=>$field,
                		
                	],[
                		'id_ms_table'=>$id_map,
                		'name_column'=>$field,
                		'aggregate_type'=>'SUM',
                		'satuan'=>'-',
                		'definisi'=>'-',
                		'name'=>strtoupper(str_replace('_',' ',$field)),
                		'tipe_data'=>$type_data,
                		'interval_nilai'=>null,
                		'id_user'=>1
                	]);

                	

                }

            }

            $view=[
        		['id_ms_table'=>null,
        		'type'=>'map',
        		'level'=>2,
        		'row'=>0,
        		'id_user'=>1],
        		['id_ms_table'=>null,
        		'type'=>'bar',
        		'level'=>2,
        		'row'=>0,
        		'id_user'=>1],
        		['id_ms_table'=>null,
        		'type'=>'table',
        		'level'=>2,
        		'row'=>1,
        		'id_user'=>1],
        		['id_ms_table'=>null,
        		'type'=>'map',
        		'level'=>4,
        		'row'=>0,
        		'id_user'=>1],
        		['id_ms_table'=>null,
        		'type'=>'bar',
        		'level'=>4,
        		'row'=>0,
        		'id_user'=>1],
        		['id_ms_table'=>null,
        		'type'=>'table',
        		'level'=>4,
        		'row'=>1,
        		'id_user'=>1],
        		['id_ms_table'=>null,
        		'type'=>'bar',
        		'level'=>6,
        		'row'=>0,
        		'id_user'=>1],
        		['id_ms_table'=>null,
        		'type'=>'table',
        		'level'=>6,
        		'row'=>1,
        		'id_user'=>1],
        		['id_ms_table'=>null,
        		'type'=>'bar',
        		'level'=>10,
        		'row'=>0,
        		'id_user'=>1],
        		['id_ms_table'=>null,
        		'type'=>'table',
        		'level'=>10,
        		'row'=>1,
        		'id_user'=>1]
        	];

        	foreach ($view as $k => $v) {
        		$v['id_ms_table']=$id_map;
        		DB::table('master_view_method')->updateOrinsert([
        			'id_ms_table'=>$v['id_ms_table'],
        			'level'=>$v['level'],
        			'type'=>$v['type'],
        		],$v);
        	}


        	DB::table('tb_data')->updateOrinsert([
        		'title'=>strtoupper(str_replace('_',' ',str_replace('dash_','DATA ',$t))),
        	],[
        		'type'=>'INTEGRASI',
        		'tahun'=>$tahun,
        		'id_user'=>1,
        		'id_user_update'=>1,
        		'status'=>1
        	]);

        	$dataset=DB::table('tb_data')->where('title',strtoupper(str_replace('_',' ',str_replace('dash_','DATA ',$t))))->first();

        	$id_dataset=$dataset->id;

        	DB::table('tb_data_detail_map')->updateOrInsert([
        		'id_data'=>$id_dataset,
        		'id_map'=>$id_map,
        	],[
        		'id_data'=>$id_dataset,
        		'id_map'=>$id_map,
        	]);

        	DB::table('tb_data_group')->updateOrinsert([
        		'id_data'=>$id_dataset,
        		'id_category'=>1,

        	],[
        		'id_data'=>$id_dataset,
        		'id_category'=>1,
        	]);

        	DB::table('tb_data_instansi')->updateOrinsert([
        		'id_data'=>$id_dataset,
        		'id_instansi'=>1,

        	],[
        		'id_data'=>$id_dataset,
        		'id_instansi'=>1,
        	]);




    	}
    }


    public function bulild_column($table=null){
    	$table_name=[];

    	if($table){
    		$table_name=[$table];
    	}else{
    		$table_name=DB::table('master_table_map')->pluck('table')->get()->toArray();

    	}



    }
}
