<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Storage;
class DataCtrl extends Controller
{

	public function index(Request $request){
		$where=[];
		$Orwhere=[];
		if($request->jenis){
			$where[]=['d.delivery_type','=',$request->jenis];
			$Orwhere[]=['d.delivery_type','=',$request->jenis];

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
		]);

		return view('admin.data.index')->with(['pilih_kategori'=>isset($pilih_kategori)?$pilih_kategori['text']:null,'data'=>$data,'request'=>$request]);

	}

	public function create($jenis){
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

	public function store($jenis,Request $request){
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
		$path=Storage::put('public/publication/DATASET/'.date('Y'),$request->file);
		$path=Storage::url($path);
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		$size=filesize($request->file)??0;
		$size=$size / 1048576;
		$data=DB::table('data')

		->insert([
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
			return back();
		}else{
			return abort(500);
		}
	}

}