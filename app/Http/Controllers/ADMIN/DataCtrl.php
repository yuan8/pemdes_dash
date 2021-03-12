<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Storage;
use Carbon\Carbon;
class DataCtrl extends Controller
{

	public function index($tahun,Request $request){
		$where=[
			['d.type','=','FILE']
		];
		$Orwhere=[
			['d.type','=','FILE']
		];
		if($request->jenis){
			$where[]=['d.delivery_type','=',$request->jenis];
			$Orwhere[]=['d.delivery_type','=',$request->jenis];
			$where[]=['d.type','=','FILE'];
			$Orwhere[]=['d.type','=','FILE'];



		}

		if($request->tema){
			$where[]=['c.type','=',$request->tema];
			$where[]=['d.type','=','FILE'];
			$Orwhere[]=['c.type','=',$request->tema];
			$Orwhere[]=['d.type','=','FILE'];


		}

		if($request->q){
			$where[]=['d.name','ilike','%'.$request->q.'%'];
			$Orwhere[]=['d.description','ilike','%'.$request->q.'%'];
			$where[]=['d.type','=','FILE'];
			$Orwhere[]=['d.type','=','FILE'];



		}

		if($request->kategori){
			$where[]=['gc.id_category','=',$request->kategori];
			$Orwhere[]=['gc.id_category','=',$request->kategori];
			$Orwhere[]=['d.type','=','FILE'];
			$where[]=['d.type','=','FILE'];


			$pilih_kategori=(array)DB::table('category')
				->selectRaw("concat(replace(type,'_',' '),' - ',name) as text,id ")
				->where([
					['id','=',$request->kategori],
				])
				->first();

		}

		$data=DB::table('data as d')
		->leftJoin('data_group as gc','gc.id_data','=','d.id')
		->leftJoin('category as c','c.id','=','gc.id_category')
		->selectRaw("group_concat(distinct(c.name)) as nama_category,c.type as tema ,d.*")
		->groupBy('d.id');


		if(count($where)){
			$data=$data->where($where);
		}

		if(count($Orwhere)){
			$data=$data->orWhere($Orwhere);
		}

		$data=$data->paginate(10);
		$data->appends([
			'kategori'=>$request->kategori,
			'q'=>$request->q,
			'jenis'=>$request->jenis,
			'tema'=>$request->tema
		]);

		return view('admin.data.index')->with(['pilih_kategori'=>isset($pilih_kategori)?$pilih_kategori['text']:null,'data'=>$data,'request'=>$request]);

	}

	public function create($tahun,$jenis){
		$view=[];
		 foreach([2=>'PROVINSI',4=>'KOTA/KAB',7=>'KECEMATAN',10=>"DESA/KELURAHAN"] as $kl=>$l){
                $view[$kl]=[
                    'head'=>$l,
                    'map'=>[]
                ];

                foreach([0,1,2,3] as $r){
                    $dr=[];
                    if($dr){
                        $view[$kl]['map'][$r]=$dr;
                    }

                }                
          }

		return view('admin.data.handle.create_data_set')->with(['jenis'=>$jenis,'view'=>$view]);

		// switch ($jenis) {
		// 	case 'TABLE':
		// 		return view('admin.data.handle.create_data_set')->with(['JENIS'=>$jenis]);
		// 		# code...
		// 		break;
			
		// 	default:
		// 		# code...
		// 		break;
		// }
	}

	public function store($tahun,$jenis,Request $request){

		switch ($jenis) {
			case 'VISUALISASI':
				return static::store_visual($tahun,$request);
				# code...
				break;
			case 'INFOGRAFIS':
				return static::store_infografis($tahun,$request);
				# code...
				break;
			
			default:
				# code...
				break;
		}
	}


	static function store_infografis($tahun,Request $request){
		$path=Storage::put('public/publication/DATASET/'.$tahun,$request->file);
		$path=Storage::url($path);
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		$size=filesize($request->file)??0;
		$size=$size / 1048576;


		$data=DB::table('data')
		->insertGetId([
			'name'=>$request->name,
			'delivery_type'=>'INFOGRAFIS',
			'type'=>'FILE',
			'extension'=>$ext,
			'description'=>$request->description,
			'organization_id'=>$request->id_instansi??15,
			'year'=>$tahun,
			'size'=>$size,
			'dashboard'=>(boolean)(($request->dashboard)),
			'auth'=>(boolean)(($request->dashboard)?$request->auth:0),
			'keywords'=>($request->keywords)?json_encode($request->keywords,true):'[]',
			'document_path'=>$path,
			'created_at'=>Carbon::now(),
			'updated_at'=>Carbon::now(),
			'publish_date'=>Carbon::now(),

		]);

		if($data){
			foreach ($request->category as $key => $k) {
    				# code...
    				DB::table('data_group')->insertOrIgnore([
    					'id_data'=>$data,
    					'id_category'=>$k
    				]);

    			}
			return back();
		}


	}
	static function store_visual($tahun,Request $request){
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file);
		$sheet=$spreadsheet->setActiveSheetIndex(0);
		$meta_table=[
			'name'=>'',
			'id'=>0,
			'columns'=>[],
			'view_'=>[]
		];
		$version=$sheet->getCell('A1')->getCalculatedValue();

		$meta_table['name']=$request->name;
		$DATA=[];
		$data=$sheet->toArray();

		foreach ($request->view as $key => $v) {
			$meta_table['view_'][$key]=array_values((array)$v);
			# code...
		}

		foreach ($data as $key => $d) {
			if($key==3){
				for($index=1;$index<count($d);$index+=2){
					if(!empty($d[$index])){
						$meta_table['columns'][$index]=[
						'name'=>$d[$index],
						'satuan'=>$data[$key+1][$index+1],
						'name_column'=>'c_'.$index,
						'aggregate_type'=>$data[$key+1][$index],
						];
					}
				}
				

			}

			if($key>=6){
				if(!empty($d[0])){
					$DX=[
						'kode_desa'=>$d[0]
					];
					$index=0;
					foreach ($meta_table['columns'] as $key => $v) {
						$DX['data_'.$index]=$d[$key];
						$DX['data_'.$index.'_satuan']=$v['satuan'];
						$index++;
					}

					$DATA[]=$DX;

				}
			}
			# code...
		}

		$meta_table['columns']=array_values($meta_table['columns']);
		$MAP_DATA=[
			'meta_table'=>$meta_table,
			'data'=>$DATA
		];


		$path=Storage::put('public/publication/DATASET/'.$tahun,$request->file);
		$path=Storage::url($path);
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		$size=filesize($request->file)??0;
		$size=$size / 1048576;


		$data=DB::table('data')
		->insertGetId([
			'name'=>$request->name,
			'delivery_type'=>'VISUALISASI',
			'type'=>'FILE',
			'extension'=>$ext,
			'description'=>$request->description,
			'organization_id'=>$request->id_instansi??15,
			'year'=>$tahun,
			'size'=>$size,
			'dashboard'=>(boolean)(($request->dashboard)),
			'auth'=>(boolean)(($request->dashboard)?$request->auth:0),
			'keywords'=>($request->keywords)?json_encode($request->keywords,true):'[]',
			'document_path'=>$path,
			'created_at'=>Carbon::now(),
			'updated_at'=>Carbon::now(),
			'publish_date'=>Carbon::now(),

		]);

		if($data){
			$JSON=Storage::put('public/publication/DATASET_JSON/'.$tahun.'/'.$data.'.json',json_encode($MAP_DATA));

			foreach ($request->category as $key => $k) {
    				# code...
    				DB::table('data_group')->insertOrIgnore([
    					'id_data'=>$data,
    					'id_category'=>$k
    				]);

    			}
			// foreach($request->)

			return back();
		}else{
			return abort(500);
		}
	}


	

	static function GETVALAGRE($old,$new,$tipe){
		$new=(float)($new);
		$old=(float)($old);

		switch ($tipe) {
			case 'COUNT':
				return ($new)?($old+1):$old;
				# code...
				break;
			case 'AVERAGE':
				return (float)$old+(float)$new;
				# code...
				break;
			case 'SUM':
				return (float)$old+(float)$new;
				# code...
				break;
			case 'MAX':
				if($old<=$new){
					return $new;
				}else{
					return $old;
				}
				# code...
				break;
			case 'MIN':
				if($old<=$new){
					return $old;
				}else{
					return $new;
				}
				
				# code...
				break;
			
			default:
			return 0;
				# code...
				break;
		}


	}

	static function kdp($kode,$max){
		if($kode){
			return substr($kode,0,($max));
		}
		dd('TERDAPAT KODE DAERAH YANG TIDAK TERISI');

	}

}