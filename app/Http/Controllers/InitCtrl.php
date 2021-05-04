<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class InitCtrl extends Controller
{
    //


    public function init(){
    	set_time_limit(-1);
    	ini_set('memory_limit', '7048M');
    	$provinsi=DB::connection('server')->table('provinsi')
    	->selectRaw("kdprovinsi, concat('PROVINSI ',nmprovinsi) as nmprovinsi")->get();
        dd($provinsi);

    	foreach ($provinsi as $key => $value) {
    		DB::table('master_provinsi')->insertOrIgnore((array)$value);
    	}

    	$kota=DB::connection('server')->table('kabkota')
    	->selectRaw("kdkabkota, concat(case when stapem=0 then 'KAB ' else 'KOTA 'end ,nmkabkota) as nmkabkota,left(kdkabkota,2) as id_parent")->get();

    	foreach ($kota as $key => $value) {
    		DB::table('master_kabkota')->insertOrIgnore((array)$value);
    	}

    	$kc=DB::connection('server')->table('kecamatan')
    	->selectRaw("kdkecamatan, concat('KECAMATAN ',nmkecamatan) as nmkecamatan,left(kdkecamatan,4) as id_parent")->get();

    	foreach ($kc as $key => $value) {
    		DB::table('master_kecamatan')->insertOrIgnore((array)$value);
    	}



    	$desa_ignore=[];
    	$desa=DB::connection('server')->table('master_desa')
    	->selectRaw("kode_bps as kddesa, (case when stapem=0 then 'DESA ' else stapem end) as stapem , desa as nmdesa,left(kode_bps,6) as id_parent")->get();

	    	foreach ($desa as $key => $value) {
	    		$check=DB::table('master_desa')->insertOrIgnore((array)$value);

	    		
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
    		[
    			'name'=>'admin 1',
    			'email'=>'admin1@domain.com',
    			'password'=>'TVRJek5284^444VTJOemc9',
    			'nik'=>'12345678910',
    			'nomer_telpon'=>'12345678910',
    			'api_token'=>'tok_',
    			'is_active'=>true,
    			'role'=>2,
    			'jabatan'=>'-'
    		],
    		[
    			'name'=>'regional 1',
    			'email'=>'reg1@domain.com',
    			'password'=>'TVRJek5284^444VTJOemc9',
    			'nik'=>'12345678910',
    			'nomer_telpon'=>'12345678910',
    			'api_token'=>'tok_',
    			'is_active'=>true,
    			'role'=>3,
    			'jabatan'=>'-'
    		],
    		[
    			'name'=>'provinsi aceh',
    			'email'=>'prov_aceh@domain.com',
    			'password'=>'TVRJek5284^444VTJOemc9',
    			'nik'=>'12345678910',
    			'nomer_telpon'=>'12345678910',
    			'api_token'=>'tok_',
    			'is_active'=>true,
    			'role'=>4,
    			'kode_daerah'=>11,
    			'main_daerah'=>true,
    			'jabatan'=>'-'
    		],
    		[
    			'name'=>'provinsi aceh wali',
    			'email'=>'prov_acehw@domain.com',
    			'password'=>'TVRJek5284^444VTJOemc9',
    			'nik'=>'12345678910',
    			'nomer_telpon'=>'12345678910',
    			'api_token'=>'tok_',
    			'is_active'=>true,
    			'role'=>4,
    			'kode_daerah'=>11,
    			'main_daerah'=>false,
    			'walidata'=>true,
    			'jabatan'=>'-'
    		],
    		[
    			'name'=>'aceh selatan',
    			'email'=>'aceh_selatan@domain.com',
    			'password'=>'TVRJek5284^444VTJOemc9',
    			'nik'=>'12345678910',
    			'nomer_telpon'=>'12345678910',
    			'api_token'=>'tok_',
    			'is_active'=>true,
    			'role'=>4,
    			'kode_daerah'=>1101,
    			'main_daerah'=>true,
    			'jabatan'=>'-'
    		],
    		[
    			'name'=>'aceh selatan wali',
    			'email'=>'aceh_selatanw@domain.com',
    			'password'=>'TVRJek5284^444VTJOemc9',
    			'nik'=>'12345678910',
    			'nomer_telpon'=>'12345678910',
    			'api_token'=>'tok_',
    			'is_active'=>true,
    			'role'=>4,
    			'kode_daerah'=>1101,
    			'main_daerah'=>false,
    			'walidata'=>true,
    			'jabatan'=>'-'
    		],
    		[
    			'name'=>'kecamatan a',
    			'email'=>'kecamatan_a@domain.com',
    			'password'=>'TVRJek5284^444VTJOemc9',
    			'nik'=>'12345678910',
    			'nomer_telpon'=>'12345678910',
    			'api_token'=>'tok_',
    			'is_active'=>true,
    			'role'=>4,
    			'kode_daerah'=>110109,
    			'main_daerah'=>true,
    			'jabatan'=>'-'
    		],
    		[
    			'name'=>'kecamatan  a wali',
    			'email'=>'kecamatan_aw@domain.com',
    			'password'=>'TVRJek5284^444VTJOemc9',
    			'nik'=>'12345678910',
    			'nomer_telpon'=>'12345678910',
    			'api_token'=>'tok_',
    			'is_active'=>true,
    			'role'=>4,
    			'kode_daerah'=>110109,
    			'main_daerah'=>false,
    			'walidata'=>true,
    			'jabatan'=>'-'
    		],
    		[
    			'name'=>'desa a',
    			'email'=>'desa_a@domain.com',
    			'password'=>'TVRJek5284^444VTJOemc9',
    			'nik'=>'12345678910',
    			'nomer_telpon'=>'12345678910',
    			'api_token'=>'tok_',
    			'is_active'=>true,
    			'role'=>4,
    			'kode_daerah'=>1101092012,
    			'main_daerah'=>true,
    			'jabatan'=>'-'
    		],
    		[
    			'name'=>'desa a wali',
    			'email'=>'desa_aw@domain.com',
    			'password'=>'TVRJek5284^444VTJOemc9',
    			'nik'=>'12345678910',
    			'nomer_telpon'=>'12345678910',
    			'api_token'=>'tok_',
    			'is_active'=>true,
    			'role'=>4,
    			'kode_daerah'=>1101092012,
    			'main_daerah'=>false,
    			'walidata'=>true,
    			'jabatan'=>'-'
    		]
    	];

    	foreach ($users as $key => $d) {
    		$d['nomer_telpon'].=$key;
    		$d['nik'].=$key;
    		$d['api_token'].=md5($key);

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
}
