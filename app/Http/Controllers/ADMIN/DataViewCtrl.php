<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
class DataViewCtrl extends Controller
{
    //

    public function index($tahun,Request $request){

    	$where=[
    		['d.type','=','INTEGRASI']
    	];
    	$Orwhere=[];

		if($request->tema){
			$where[]=['c.type','=',$request->tema];

			$Orwhere[]=['c.type','=',$request->tema];

		}

		if($request->q){
			$where[]=['d.name','like','%'.$request->q.'%'];
			$Orwhere[]=['d.description','like','%'.$request->q.'%'];
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
		->leftJoin('category as i','i.id','=','d.organization_id')
		->selectRaw("group_concat(distinct(concat(c.name))) as nama_category,
			i.name as instansi,
		group_concat(distinct(c.type)) as tema ,d.*")
		->groupBy('d.id');

		if(count($where)){
			$data=$data->where($where);
		}

		if(count($Orwhere)>0){
			$Orwhere[]=['d.type','=','INTEGRASI'];
		}

		if(count($Orwhere)){
			$data=$data->orWhere($Orwhere);
		}

		$data=$data->paginate(10);

		$data->appends([
			'kategori'=>$request->kategori,
			'q'=>$request->q,
			'tema'=>$request->tema
		]);

		return view('admin.dataview.index')->with(['pilih_kategori'=>isset($pilih_kategori)?$pilih_kategori['text']:null,'data'=>$data,'request'=>$request]);


    }

    public function edit($tahun,$id){


    	$data=DB::table('data as d')
		->leftJoin('data_group as gc','gc.id_data','=','d.id')
		->leftJoin('category as c','c.id','=','gc.id_category')
		->leftJoin('category as i','i.id','=','d.organization_id')

		->selectRaw("group_concat(DISTINCT(concat(c.id,'|||',replace(c.type,'_',' '),'|||',c.name)) SEPARATOR '------') as category,concat(i.id,'|||',i.name) as instansi,  d.*")
		->groupBy('d.id')
		->where([
			['d.id','=',$id],
			['d.type','=','INTEGRASI']
		])->first();


    	if($data){
    		$tablemap=DB::table('master_table_map')->get();
    		return view('admin.dataview.edit')->with(['data'=>$data,'tablemap'=>$tablemap]);
    	}else{
    		return abort('404');
    	}
    }

     public function update($tahun,$id,Request $request){


    	$data=DB::table('data as d')
		->leftJoin('data_group as gc','gc.id_data','=','d.id')
		->leftJoin('category as c','c.id','=','gc.id_category')
		->selectRaw("group_concat(DISTINCT(concat(c.id,'|||',replace(c.type,'_',' '),'|||',c.name)) SEPARATOR '------') as category, d.*")
		->groupBy('d.id')
		->where([
			['d.id','=',$id],
			['d.type','=','INTEGRASI']
		])->first();


    	if($data){

    		$data_up=DB::table('data as d')->where([
    			['d.id','=',$id],
				['d.type','=','INTEGRASI']
    		])->update([
    			'name'=>$request->name,
    			'description'=>$request->description,
    			'table_view'=>$request->table_view,
    			'auth'=>$request->auth,
    			'updated_at'=>Carbon::now(),
    			'keywords'=>json_encode($request->keywords),
    			'organization_id'=>$request->id_instansi
    		]);

    		if($data_up){
    			foreach ($request->category as $key => $k) {
    				# code...
    				DB::table('data_group')->insertOrIgnore([
    					'id_data'=>$id,
    					'id_category'=>$k
    				]);

    			}
    			DB::table('data_group')->where('id_data',$id)
    			->whereNotIn('id_category',$request->category)->delete();
    			
    		}

    		return back();

    	}else{
    		return abort('404');
    	}
    }
}
