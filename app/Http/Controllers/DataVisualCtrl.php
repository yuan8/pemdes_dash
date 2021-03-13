<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Storage;
use HPV;
use Nahid\JsonQ\Jsonq;
use Carbon\Carbon;
use App\Http\Controllers\TestCtrl as MAP;

class DataVisualCtrl extends Controller
{
    //

    static function aggre($kode_daerah,$key,$agrre,$data){
    			if($data){
    	switch ($agrre) {
    		case 'SUM':
    		
    			return $data->sum($key);
    			break;
    		case 'MIN':
    			# code...
    			return $data->min($key);

    			break;
    		case 'MAX':
    			return $data->max($key);


    			# code...
    			break;
    		case 'COUNT':
    			return $data->max($key);

    			# code...
    			break;
    		
    		default:
    			# code...
    			break;
    		}
    	}
    	return 0;

    	
    }

    public function index($tahun,$id,Request $request){
    	$file_exist=file_exists(storage_path('/app/public/publication/DATASET_JSON/'.$tahun.'/'.$id.'.json'));
    	if($file_exist){
    		$file_json=file_get_contents(storage_path('/app/public/publication/DATASET_JSON/'.$tahun.'/'.$id.'.json'));
    		$meta_table=json_decode($file_json,true)['meta_table'];
    		$meta_table['key_view']='f';


    	}
    	 $data=DB::table('data as d')
        ->where('year',($tahun))
        ->where('type','FILE')
        ->where('delivery_type','VISUALISASI')
        ->where('id',$id)->first();

        $level=HPV::level($request->kdparent);
		

        $DATA=[];

        if($data){
        	

			$daerah=DB::table($level['table'].' as da')->selectRaw( "da.".$level['table_kode']." as id, da.".$level['table_name']." as name, (select count(ds.kode_bps) from master_desa as ds where left(ds.kode_bps,".$level['count'].") = da.".$level['table_kode'].") as jumlah_desa 
			")->where('da.'.$level['table_kode'],'like',($request->kdparent)."%")

			->get();
			foreach ($daerah as $key => $d) {
				$d=(array)$d;
				foreach ($meta_table['columns'] as $key => $col) {
					$jsonq = new Jsonq($file_json);
					$obj=$jsonq->from('data');

					$d['id_cmf']=count($obj->where('kode_desa','startswith',$d['id'])->get());
					$d['id_data']=$d['id'];
					$d['jumlah_data_desa']=$d['id_cmf'];


					if($d['id_cmf']){
						$d['data_'.$key]=static::aggre($d['id'],'data_'.$key,$col['aggregate_type'],$obj);


					}else{
						$d['data_'.$key]=0;
					}


					$d['data_'.$key.'_satuan']=$col['satuan'];

				}

				$DATA[]=$d;
			}



        }

        $data_type=[
				'data'=>$DATA
		];
        $data_type['series']=MAP::data_series('xx',$DATA,$meta_table,$level,$id,'DATASET');
		$data_type['series_map']=MAP::data_map('xx',$DATA,$meta_table,$level,$id,'DATASET');
		$data_type['data_sort']=MAP::rekap_data($DATA,$meta_table,4);

		$vie=$meta_table['view_'];
		foreach ([2,4,7,10] as $key => $value) {
			$meta_entity[$value]=(isset($vie[$value]))?$vie[$value]:[];
		}

		if($request->kdparent){
			$nama_pemda=((array)DB::table($level['parent']['table'])->where($level['parent']['table_kode'],'=',$request->kdparent)->selectRaw($level['parent']['table_name'].' as name')->first())['name'];
			$l=$level['parent']['level'];
		}
		else{
			$nama_pemda='PROVINSI';
			$l='';
		}

		$meta_entity=$meta_entity[$level['count']];
		$meta_entity[]=[['type'=>'table']];
		$datenow=Carbon::now()->format('d F Y');
		
			$id_c='chart_id_'.rand(0,100).'_'.date('Ymdhi');
			$return='<div class="row " id="'.$id_c.'">';
			if(count($meta_entity)==0){
				$return.='<div class="col-md-12"><h4 class="text-center">DATA TIDAK TERSEDIA</h4></div>';
			}
			$return.='<div class="col-md-12 text-center"><h4><b>'.strtoupper($data->name.' '.$l.' '.$nama_pemda).'</b></h4></div>';

			foreach ($meta_entity as $key => $value) {
				foreach($value as $v){
					$return.='<div class="table-responsive ch col-md-'.(12/count($value)).' col-lg-'.(12/count($value)).'">'.view('view_data.'.$v['type'])->with([
						'data_type'=>$data_type,
						'title'=>strtoupper($data->name),
						'subtitle'=>'Capaian Tahun '.($tahun).' - '.$datenow,
						'level'=>$level['count'],
						'level_meta'=>$level,
						'kdparent'=>$level['kode'],
						'pemda'=>$nama_pemda,
						'table_meta'=>$meta_table,
						'tahun_capaian'=>$tahun,
						'dataset'=>true,
						'id_dataset'=>$id
					])->render().'</div>';
					
				}
			}
			$return.='</div>
			';


	return $return;
       


    }
}
