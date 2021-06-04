<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use HP;
use HPV;
use Auth;
use Carbon\Carbon;
class BeritaAcaraCtrl extends Controller
{

    public function build($tahun,Request $request){
    	$access_data_daerah=$request->kddesa??$request->kdkecamatan??$request->kdkabkota??$request->kdprovinsi;
    	$check_access=HP::check_access($access_data_daerah);
        
        
    	$mapTb=DB::table('master_table_map as m')
    	->join('master_column_map as c',[['m.id','=','c.id_ms_table'],['c.validate','=',DB::raw(true)]])
    	->selectRaw('m.*,m.id as id_map')->where('m.id',$request->data)
    	->first();


    	$now=Carbon::now();

    	if($check_access and $mapTb){

    		$table=DB::table('master_table_map')->where('edit_daerah',true)->get();

    		$maping=HP::level_build($mapTb,$access_data_daerah,1,1);
    		$maping['column'][]="da.kddesa as id";
    		$maping['column'][]="da.nmdesa as name";

    		$maping['column'][]="da.stapem as status_desa";
    		$maping['column'][]="da.nmkabkota as nama_kota";
    		$maping['column'][]="da.nmkecamatan as nama_kecamatan";
    		$maping['column'][]="da.nmprovinsi as nama_provinsi";
    		$maping['column'][]="dt.status_validasi as status_data";
    		$maping['column'][]="dt.validasi_date as valid_date";
    		$maping['column'][]="dt.updated_at as updated_at";

    		$kecamatans=DB::table('master_kecamatan as kc')
    		->selectRaw("kc.*,(select count(da.kddesa) from master_desa as da where da.kddesa like concat(kc.kdkecamatan,'%')) as jumlah_desa")
    		->where('kdkecamatan','like',$access_data_daerah.'%')
    		->get();
    		$data_q=[];

    		foreach ($kecamatans as $kc) {
    				$data_q[$kc->kdkecamatan]=[
    					'nama'=>$kc->nmkecamatan,
    					'id'=>$kc->kdkecamatan,
    					'jumlah_desa'=>$kc->jumlah_desa,

    					'data'=>[],
    					'walidata'=>DB::table('users')->where([
    						['role','=',4],
    						['walidata','=',true],
    						['kode_daerah','=',$kc->kdkecamatan],
    						['is_active','=',true]
    					])->selectRaw('name,nik,jabatan')->get()->toArray(),
    				];

    			    $defwhere=[
		    			['da.kddesa','like',$kc->kdkecamatan.'%'],
		    			['dt.status_validasi','=',5]
		    			
		    		];
		    		

		    		$defJoin=[
		    			[
							DB::raw("left(dt.kode_desa,".($maping['level_data']['child']['count']==0?2:$maping['level_data']['child']['count']).")"),
							'=',
							$maping['level_data']['child']['column_id']
						],
						['dt.tahun','=',DB::raw($tahun)]
		    		];

		    		$OrWhere=[];

		    		

		    		if($request->verifikasi_status){
		    			$defwhere[]=['dt.status_validasi','=',$request->verifikasi_status];

		    		}
		    		if($request->status_daerah){
		    			$defwhere[]=['da.stapem','=',$request->status_daerah];
		    		}

		    		if($request->q){
		    			foreach (['nmdesa','nmkecamatan','nmprovinsi','nmkabkota'] as $key => $value) {
		    				$OrWhere[]=array_merge($defwhere,[['da.'.$value,'like','%'.$request->q.'%']]);
		    			}
		    		}

		    		 $data_query=
				        DB::table($maping['level_data']['child']['table'].' as da')
						->join($maping['data_table'],$defJoin)
						->selectRaw(implode(',',$maping['column']))
						->groupBy($maping['level_data']['child']['column_id'])
						->orderBy($maping['level_data']['child']['column_id'],'asc');

					if($OrWhere){
						foreach ($OrWhere as $key => $value) {
							if($key==0){
								$data_query=$data_query->where($value);

							}
								$data_query=$data_query->orWhere($value);


						}
					}else{
						$data_query=$data_query->where($defwhere);

					}
					
					$data_query=$data_query->get()->toArray();
					if(count($data_query)){
					$data_q[$kc->kdkecamatan]['data']=$data_query;
					$data_q[$kc->kdkecamatan]['jumlah_data']=count($data_query);
					$data_q[$kc->kdkecamatan]['persentase_pelaporan']=HPV::nformat((count($data_query)/$data_q[$kc->kdkecamatan]['jumlah_desa']) *100);



					}else{
						unset($data_q[$kc->kdkecamatan]);
					}
    			# code...
    		}
    		$data=[
    			'table_map'=>$maping,
    			'data'=>$data_q
    		];

    		DB::table('tb_berita_acara')->insertOrIgnore([
    			'kode_daerah'=>$access_data_daerah,
    			'tahun'=>$tahun,
    			'id_table_map'=>$maping['id_map']
    		]);
    		


    		return view('admin.export.berita_acara')->with(['daerah'=>$check_access,'data'=>$data,'table_map'=>$maping,'now'=>$now]);

    	}
	}
}
