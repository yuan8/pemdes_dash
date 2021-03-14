<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
class CronJob extends Controller
{
    //

	public static function handle(){
		$tahun=date('Y');
		$D=DB::connection('real')->table('master_table_map')->where(
			'edit_daerah','=',true
		)->get();

		foreach ($D as $key => $value) {
			$row=DB::table('master_column_map')->where('id_ms_table',$value->id)->get()->pluck('name_column')->toArray();
			$row[]='kode_desa';
			$row[]='tahun';

			DB::connection('mysql')->table($value->table.' as d')->join('validasi_confirm as v',[['v.kode_desa','=','d.kode_desa'],['v.tahun','=',DB::raw($tahun)],['v.table','=',DB::raw("'".$value->table."'")]])
			->orderBy('v.tanggal_validasi','asc')
			->where('d.tahun','=',$tahun)
			->where('v.tanggal_validasi','>=',Carbon::now()->addDays(-5))
			->selectRaw('d.'.implode(',d.',$row))->chunk(100,function($res){


			});

		}

	}
}
