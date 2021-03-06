<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Storage;
class DataCtrl extends Controller
{

	public function index($tahun,Request $request){
		$where=[];
		$Orwhere=[];
		if($request->jenis){
			$where[]=['d.delivery_type','=',$request->jenis];
			$Orwhere[]=['d.delivery_type','=',$request->jenis];

		}

		if($request->tema){
			$where[]=['c.type','=',$request->tema];
			$Orwhere[]=['c.type','=',$request->tema];

		}

		if($request->q){
			$where[]=['d.name','ilike','%'.$request->q.'%'];
			$Orwhere[]=['d.description','ilike','%'.$request->q.'%'];
		}

		if($request->kategori){
			$where[]=['gc.id_category','=',$request->kategori];
			$Orwhere[]=['gc.id_category','=',$request->kategori];
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
		->selectRaw("group_concat(c.name) as nama_category,c.type as tema ,d.*")
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
		switch ($jenis) {
			case 'DATASET':
				return view('admin.data.handle.create_data_set')->with(['JENIS'=>'DATASET']);
				# code...
				break;
			
			default:
				# code...
				break;
		}
	}

	public function store($tahun,$jenis,Request $request){
		switch ($jenis) {
			case 'DATASET':
				return static::store_dataset($request);
				# code...
				break;
			
			default:
				# code...
				break;
		}
	}


	static function store_dataset(Request $request){
		$JSON=static::create_json_dataset($request->file);



		$path=Storage::put('public/publication/DATASET/'.date('Y'),$request->file);
		$path=Storage::url($path);
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		$size=filesize($request->file)??0;
		$size=$size / 1048576;


		$data=DB::table('data')
		->insertGetId([
			'name'=>$request->name,
			'delivery_type'=>'DATASET',
			'type'=>'DOKUMEN',
			'extension'=>$ext,
			'description'=>$request->description,
			'organization_id'=>$request->id_instansi??15,
			'year'=>date('Y'),
			'size'=>$size,
			'keywords'=>($request->keywords)?json_encode($request->keywords,true):'[]',
			'document_path'=>$path
		]);

		if($data){
			$JSON=Storage::put('public/publication/DATASET_JSON/'.date('Y').'/'.$data.'.json',json_encode($JSON));
			return back();
		}else{
			return abort(500);
		}
	}

	static function create_json_dataset($data){
		$dataArray=[];
		$start_data=6;
		$start_header=3;
		$end_header=3;	

		$DATA=[

		];

						

		if($data){
			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($data);
			for ($i=0; $i <$spreadsheet->getSheetCount() ; $i++) {
				$PAGE=[
					'title'=>'',
					'sub_title'=>'',
					'updated_at'=>null,
					'header'=>[],
					'DATA_PROVINSI'=>[],
					'DATA_KOTA'=>[],
					'DATA_KECAMATAN'=>[],
					'DATA_DESA'=>[],

				];	 
				# code...
				$sheet=$spreadsheet->setActiveSheetIndex($i);
				$data_sheet=$sheet->toArray();
				$PAGE['title']=$data_sheet[1][0];
				$PAGE['sub_title']=$data_sheet[2][0];

				foreach ($data_sheet as $key => $d) {

					if(($key==$start_header)){
						for($id=1; $id <count($d); $id+=2) {
							if($d[$id]){
								$PAGE['header'][$id]=[
								'text'=>$d[$id],
								'aggregate'=>in_array($data_sheet[$key+1][$id]??null,['SUM','MIN','MAX','AVERAGE','COUNT'])?$data_sheet[$key+1][$id]:NULL,
								'satuan'=>$data_sheet[$key+1][$id-1]??''
							];
							}
						}
					}

					if($key>=$start_data){
						if(!empty($d[0])){
							for($id=1; $id <count($d); $id+=2) {
								if(isset($PAGE['header'][$id]) AND (!empty($PAGE['header'][$id]['aggregate'])) ){
									$head=$PAGE['header'][$id];

									if(!is_numeric($d[$id])){
										$d[$id]=0;
									}

									foreach (['2'=>'DATA_PROVINSI','4'=>'DATA_KOTA','7'=>'DATA_KECAMATAN','100'=>'DATA_DESA'] as  $keyskop=>$skop) {
										if(!isset($PAGE[$skop][static::kdp($d[0],(int)$keyskop)]['data'][$head['text'].'_'.$id])){
											$PAGE[$skop][static::kdp($d[0],(int)$keyskop)]['data'][$head['text'].'_'.$id]=($head['aggregate']=='MIN'?$d[$id]:0);
											switch ($skop) {
												case 'DATA_PROVINSI':
													$PAGE[$skop][static::kdp($d[0],(int)$keyskop)]['meta']=(array)DB::table('provinsi')->where('kdprovinsi',static::kdp($d[0],(int)$keyskop))->selectRaw("kdprovinsi as kodedaerah,nmprovinsi as namadaerah")->first();
													# code...
													break;

												case 'DATA_KOTA':
													$PAGE[$skop][static::kdp($d[0],(int)$keyskop)]['meta']=(array)DB::table('kabkota')->where('kdkabkota',static::kdp($d[0],(int)$keyskop))->selectRaw("kdkabkota as kodedaerah,nmkabkota as namadaerah")->first();
													# code...
													break;
												case 'DATA_KECAMATAN':
													$PAGE[$skop][static::kdp($d[0],(int)$keyskop)]['meta']=(array)DB::table('kecamatan')->where('kdkecamatan',static::kdp($d[0],(int)$keyskop))->selectRaw("kdkecamatan as kodedaerah,nmkecamatan as namadaerah")->first();
													# code...
													break;
												case 'DATA_DESA':
													$PAGE[$skop][static::kdp($d[0],(int)$keyskop)]['meta']=(array)DB::table('master_desa')->where('kode_bps',static::kdp($d[0],(int)$keyskop))->selectRaw("kode_bps as kodedaerah,desa as namadaerah")->first();
													# code...
													break;
												
												default:
													# code...
													break;
											}


										}
										
										$PAGE[$skop][static::kdp($d[0],(int)$keyskop)]['data'][$head['text'].'_'.$id]=static::GETVALAGRE($PAGE[$skop][static::kdp($d[0],(int)$keyskop)]['data'][$head['text'].'_'.$id],$d[$id],$head['aggregate']);
										# code...
									}
								}
							}	
						}
					}
				

			}
			$DATA[]=$PAGE;



			
			
		}

		return($DATA);

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