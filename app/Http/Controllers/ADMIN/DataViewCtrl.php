<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Auth;
use Alert;
use Validator;
class DataViewCtrl extends Controller
{
    //

    static function  buildJson($file_ex,$request){
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_ex);
        $sheet=$spreadsheet->setActiveSheetIndex(0);
        $meta_table=[
            'name'=>'',
            'id'=>0,
            'columns'=>[],
            'view_'=>[
                2=>[],
                4=>[],
                6=>[],
                10=>[]
            ]
        ];
        $version=$sheet->getCell('A1')->getCalculatedValue();

        $meta_table['name']=$request->name;
        $DATA=[];
        $data=$sheet->toArray();

        foreach ($request->view??[] as $key => $v) {
            $meta_table['view_'][$key]=array_values((array)$v);
            
        }



        foreach ($data as $key => $d) {
            if($key==3){
                for($index=2;$index<count($d);$index+=1){
                    if(!empty($data[$key+2][$index])){
                        $meta_table['columns'][$index]=[
                        'name'=>$data[$key+2][$index],
                        'satuan'=>$data[$key+1][$index],
                        'name_column'=>'c_'.$index,
                        'aggregate_type'=>$data[$key][$index],
                        ];
                    }
                }
                

            }

            if($key>=7){
                if(!empty($d[0])){
                    $DX=[
                        'kode_desa'=>$d[0]
                    ];

                    if(!isset($meta_table['level'])){
                        $meta_table['level']=strlen($d[0]);
                    }

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
            'tb_data'=>$DATA,
            'level'=>$meta_table['level']
        ];

        return $MAP_DATA;
    }

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
			$where[]=['d.title','like','%'.$request->q.'%'];
			$Orwhere[]=['d.deskripsi','like','%'.$request->q.'%'];
		}

		if($request->kategori){
			$where[]=['gc.id_category','=',$request->kategori];
			$Orwhere[]=['gc.id_category','=',$request->kategori];
			$pilih_kategori=(array)DB::table('master_category')
				->selectRaw("concat(replace(type,'_',' '),' - ',name) as text,id ")
				->where([
					['id','=',$request->kategori],
				])
				->first();

		}
		$data=DB::table('tb_data as d')
		->leftJoin('tb_data_group as gc','gc.id_data','=','d.id')
        ->leftJoin('tb_data_detail_map as lmp','lmp.id_data','=','d.id')
        ->leftJoin('master_table_map as mp','mp.id','=','lmp.id_map')
		->leftJoin('master_category as c','c.id','=','gc.id_category')
		->leftJoin('tb_data_instansi as di','di.id_data','=','d.id')
        ->leftJoin('master_instansi as i','i.id','=','di.id_instansi')
		->selectRaw("group_concat(distinct(concat(c.name))) as nama_category,
			i.name as instansi,
		group_concat(distinct(c.type)) as tema ,d.*,mp.name as nama_map")
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


    	$data=DB::table('tb_data as d')
        ->join('tb_data_detail_map as map','map.id_data','=','d.id')
		->leftJoin('tb_data_group as gc','gc.id_data','=','d.id')
		->leftJoin('master_category as c','c.id','=','gc.id_category')
        ->leftJoin('tb_data_instansi as di','di.id_data','=','d.id')
		->leftJoin('master_instansi as i','i.id','=','di.id_instansi')
		->selectRaw("group_concat(DISTINCT(concat(c.id,'|||',replace(c.type,'_',' '),'|||',c.name)) SEPARATOR '------') as category,concat(i.id,'|||',i.name) as instansi,  d.*,map.id_map")
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

         $valid=Validator::make($request->all(),[
            'name'=>'string|required',
            'auth'=>'boolean|nullable',
            'description'=>'nullable|string',
            'keywords'=>'array|nullable',
            'id_table'=>'required|numeric'
        ]);

        if($valid->fails()){
            Alert::error('',$valid->errors()->first());
            return back();
        }

    	$data=DB::table('tb_data as d')
		->where([
			['d.id','=',$id],
			['d.type','=','INTEGRASI']
		])->first();



    	if($data){

    		$data_up=DB::table('tb_data as d')->where([
    			['d.id','=',$id],
				['d.type','=','INTEGRASI']
    		])->update([
    			'title'=>$request->name,
    			'deskripsi'=>$request->description,
    			'auth'=>$request->auth,
    			'updated_at'=>Carbon::now(),
                'id_user_update'=>Auth::User()->id,
    			'keywords'=>json_encode($request->keywords),

    		]);


    		if($data_up){



                DB::table('tb_data_detail_map')->updateOrInsert([
                    'id_data'=>$id,
                    'id_map'=>$request->id_table
                ],[
                    'id_data'=>$id,
                    'id_map'=>$request->id_table
                ]);





                DB::table('tb_data_instansi')->insertOrIgnore([
                    'id_data'=>$id,
                    'id_instansi'=>$request->id_instansi
                ]);


                DB::table('tb_data_instansi')->where('id_data',$id)
                ->where('id_instansi','!=',$request->id_instansi)->delete();
               



                foreach ($request->category??[] as $key => $k) {
                        DB::table('tb_data_group')->insertOrIgnore([
                            'id_data'=>$id,
                            'id_category'=>$k
                        ]);

                }



                DB::table('tb_data_group')->where('id_data',$id)
                ->whereNotIn('id_category',$request->category)->delete();

    		}

            Alert::success('Berhasil','Berhasil mengubah dataset');

    		return back();

    	}else{
    		return abort('404');
    	}
    }


    public function create($tahun){
    		$tablemap=DB::table('master_table_map')->get();

    	return view('admin.dataview.create')->with('tablemap',$tablemap);
    }


    public function form_delete($tahun,$id){

    	$data=DB::table('tb_data as d')
		->where([
			['d.id','=',$id],
		])->first();


		if($data){
			return view('admin.dataview.delete')->with('data',$data);
		}

    }

    public function store($tahun,Request $request){

        $valid=Validator::make($request->all(),[
            'name'=>'string|required',
            'auth'=>'boolean|nullable',
            'description'=>'nullable|string',
            'keywords'=>'array|nullable'
        ]);

        if($valid->fails()){
            Alert::error('',$valid->errors()->first());
            return back();
        }


    	$data=DB::table('tb_data')->insertGetId([
    		      'title'=>$request->name,
                 'auth'=>$request->auth,
    			 'deskripsi'=>$request->description,
    			 'type'=>'INTEGRASI',
                 'status'=>1,
                 'tahun'=>$tahun,
                 'id_user'=>Auth::User()->id,
                 'publish_date'=>Carbon::now(),
                 'created_at'=>Carbon::now(),
    			 'keywords'=>json_encode($request->keywords),

    	]);

        

    	if($data){
            if(Auth::User()->can('is_only_daerah')){
                
            }

            DB::table('tb_data_detail_map')->insertOrIgnore([
                'id_data'=>$data,
                'id_map'=>$request->id_table

            ]);
            DB::table('tb_data_instansi')->insertOrIgnore([
                'id_data'=>$data,
                'id_instansi'=>$request->id_instansi
            ]);

    		foreach ($request->category??[] as $key => $k) {
    				# code...
    				DB::table('tb_data_group')->updateOrinsert([
    					'id_data'=>$data,
    					'id_category'=>$k
    				],
                    [
                        'id_data'=>$data,
                        'id_category'=>$k
                    ],

                );

    		}
    		DB::table('tb_data_group')->where('id_data',$data)
    			->whereNotIn('id_category',$request->category??[])->delete();

    	}

    	return redirect()->route('admin.dataview.index',['tahun'=>$GLOBALS['tahun_access']]);
    }


    public function delete($tahun,$id){

    	$data=DB::table('tb_data')
		->where([
			['id','=',$id],
		])->delete();

		if($data){
			
		}

		return back();

    }
}
