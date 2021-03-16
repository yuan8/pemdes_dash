<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Storage;
use Carbon\Carbon;
use App\Http\Controllers\ADMIN\DataViewCtrl;
use Alert;
use Auth;
class DataCtrl extends Controller
{

	public function index($tahun,Request $request){
		$where=[
			['d.type','=','FILE'],
			['d.delivery_type','!=','CONTROLLER'],
			['d.year','=',$tahun],


		];
		$Orwhere=[
			['d.type','=','FILE'],
			['d.delivery_type','!=','CONTROLLER'],
			['d.year','=',$tahun],
			

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
			'id_user'=>Auth::User()->id

		]);

		if($data){
			Alert::success('Berhasil','Data Berhasil Ditambahkan');
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
		$MAP_DATA=DataViewCtrl::buildJson($request->file,$request);

		$path=Storage::put('public/publication/DATASET/'.$tahun,$request->file);
		$path=Storage::url($path);
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		$size=filesize($request->file)??0;
		$size=$size / 1048576;
		$data=null;

		if($MAP_DATA){

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
				'level_start'=>$MAP_DATA['level'],
				'id_user'=>Auth::User()->id


			]);
		}

		if($data){
			Alert::success('Berhasil','Data Berhasil Ditambahkan');

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

	public static function edit($tahun,$id){
			$U=Auth::User();
	$data=DB::table('data as d')
		->leftJoin('data_group as gc','gc.id_data','=','d.id')
		->leftJoin('category as c','c.id','=','gc.id_category')
		->leftJoin('category as i','i.id','=','d.organization_id')

		->selectRaw("group_concat(DISTINCT(concat(c.id,'|||',replace(c.type,'_',' '),'|||',c.name)) SEPARATOR '------') as category,concat(i.id,'|||',i.name) as instansi,  d.*")
		->where(['c.type'=>'FILE',
			'd.id_user'=>$U->id,
			'd.year'=>$tahun,
			'd.id'=>$id])->first();

		if($data){
			$map_view=[];

			if($data->delivery_type=='VISUALISASI'){
				$file=file_get_contents(storage_path('app/public/publication/DATASET_JSON/'.$tahun.'/'.$data->id.'.json'));
				if($file){
					$file=json_decode($file,true);
					$map_view=$file['meta_table']['view_'];
				}else{
					$map_view=null;
				}
			}
			if($map_view){
				return view('admin.data.handle.edit_data_set')->with(['data'=>$data,'jenis'=>$data->delivery_type,'map_view'=>$map_view]);
			}
			

		}else{
			return abort(404);
		}
	}

	static function kdp($kode,$max){
		if($kode){
			return substr($kode,0,($max));
		}
		dd('TERDAPAT KODE DAERAH YANG TIDAK TERISI');

	}

}