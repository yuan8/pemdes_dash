<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Alert;
use Validator;

class FaqCtrl extends Controller
{
    //

    public function c_index($tahun,Request $request){
        
        $category=DB::table('faq_category');
        if($request->q){
            $category=$category->where('nama','like','%'.$request->q.'%');
        }
        $category=$category->get();

        return view('admin.faq_category.index')->with(
            ['req'=>$request->all(),
            'data'=>$category]);

    }
    public function c_edit($tahun,$id,Request $request){
        
        $category=DB::table('faq_category')->find($id);
        if($category){
            return view('admin.faq_category.edit')->with(
            ['data'=>$category]);
        }
        

    }

    public function c_add($tahun,Request $request){
        
          
     return view('admin.faq_category.add');
           
        

    }

     public function c_delete($tahun,$id,Request $request){
        
          
       $category=DB::table('faq_category')->find($id);
        if($category){
             $up=DB::table('faq_category')->where('id',$id)->delete();
            if($up){
                Alert::success('Berhasil');

            }
        }
           
        return back();

    }


    public function c_store($tahun,Request $request){
         $valid=Validator::make($request->all(),[
            'nama'=>'required|min:3|string',
            'deskripsi'=>'nullable|string',
        ]);

        if($valid->fails()){
            Alert::error('Gagal',$valid->errors()->first());
            return back()->withInput();
        }
         $up=DB::table('faq_category')->insert([
                'nama'=>$request->nama,
                'deskripsi'=>$request->deskripsi,


        ]);

         if($up){
                Alert::success('Berhasil');

                return redirect()->route('admin.faq.c.index',['tahun'=>$tahun]);
        }

        return back()->withInput();
    }

     public function c_update($tahun,$id,Request $request){

        $valid=Validator::make($request->all(),[
            'nama'=>'required|min:3|string',
            'deskripsi'=>'nullable|string',
        ]);

        if($valid->fails()){
            Alert::error('Gagal',$valid->errors()->first());
            return back()->withInput();
        }

        $category=DB::table('faq_category')->find($id);
        if($category){
            $up=DB::table('faq_category')->where('id',$id)->update([
                'nama'=>$request->nama,
                'deskripsi'=>$request->deskripsi,


            ]);

            if($up){
                Alert::success('Berhasil');
            }
        }


        return back();

        

    }


    public function delete($tahun,$id){
        $data=DB::table('faq_question')->find($id);

        if($data){
            $data=DB::table('faq_question')->where('id',$id)->delete();
            if($data){
                Alert::success('Berhasil','Berhasil Menghapus FAQ');
            }


        }


        return back();



    }

    public function store($tahun,Request $request){
        $valid=Validator::make($request->all(),[
            'answer'=>'required|min:20|string',
            'question'=>'required|min:20|string',
            'category'=>'required|exists:faq_category,id',
        ]);

        if($valid->fails()){
            Alert::error('Gagal',$valid->errors()->first());
            return back()->withInput();
        }

        $data=DB::table('faq_question')->insertOrIgnore([
            'question'=>$request->question,
            'answer'=>$request->answer,
            'id_category'=>$request->category,
        ]);

        if($data){
            Alert::success('Berhasil','Berhasil Menambahkan FAQ');
        }

        return redirect()->route('admin.faq.index',['tahun'=>$tahun]);
    }

    public function add($tahun){
        $category=DB::table('faq_category')->get();

        return view('admin.faq.add')->with(['category'=>$category]);
    }

	public function update($tahun,$id,Request $request){
		$data=DB::table('faq_question')->find($id);

        $valid=Validator::make($request->all(),[
            'answer'=>'required|min:20|string',
            'question'=>'required|min:20|string',
            'category'=>'required|exists:faq_category,id',
        ]);

        if($valid->fails()){
            Alert::error('Gagal',$valid->errors()->first());
            return back()->withInput();
        }

    	if($data){
    		DB::table('faq_question')->where('id',$id)->update([
    			'question'=>$request->question,
    			'answer'=>$request->answer,
                'id_category'=>$request->category

    		]);

    		Alert::success('Berhasil');
    	}

    	return back();


	}
    public function edit($tahun,$id){
    	$data=DB::table('faq_question')->find($id);

    	if($data){
    		$category=DB::table('faq_category')->get();

    		return view('admin.faq.edit')->with([
    			'data'=>$data,
    			'category'=>$category,

    		]);
    	}


    }

	public function get_question($tahun,Request $request){
		
    	$data=DB::table('faq_question as quest')
	    	->join('faq_category as cat','cat.id','=','quest.id_category')
	    	->groupBy('quest.id');
	    	if($request->q){
	    		$data=$data->where('quest.question','like','%'.$request->q.'%');
	    	}
	    	if($request->category){
	    		$data=$data->where('cat.id','=',$request->category);
	    	}

	    	$data=$data->selectRaw("quest.*,cat.id as id_cat,cat.nama as cat_nama,cat.deskripsi as cat_deskripsi,concat(cat.id,'|',cat.nama) pluck_con ")
	    	->get();

	    $category=[];
    	$cat=array_unique($data->pluck('pluck_con')->toArray());
    	foreach ($cat as $key => $c) {
    		$d=explode('|', $c);
    		$category[$d[0]]=[
    			'id'=>$d[0],
    			'nama'=>$d[1],
    			'questions'=>[]

    		];
    		# code...
    	}

    	$category_list=DB::table('faq_category')->get();

    	foreach ($data as $key => $d) {
    		$category[$d->id_cat]['questions'][]=$d;
    		$category[$d->id_cat]['deskripsi']=$d->cat_deskripsi;
    	}

    	

    	
    	return	[
    			'category'=>array_values($category),
    			'req'=>$request->all(),
    			'cat_list'=>$category_list
    		];
    	


	}


    public function index_dash($tahun,Request $request){
    	$category=DB::table('faq_category')->get();

    	return view('faq.index')->with(
    		[
    			'req'=>$request->all(),
    			'category'=>$category
    	]);
    }

    public function index($tahun,Request $request){
    	$data=DB::table('faq_question as quest')
    	->join('faq_category as cat','cat.id','=','quest.id_category')
    	->groupBy('quest.id');
    	if($request->q){
    		$data=$data->where('quest.question','like','%'.$request->q.'%');
    	}
    	if($request->category){
    		$data=$data->where('cat.id','=',$request->category);
    	}

    	$data=$data->selectRaw("quest.*,cat.nama as cat_nama,cat.deskripsi as cat_deskripsi")
    	->paginate(10);

    	$data->appends($request->all());
    	$category=DB::table('faq_category')->get();

    	return view('admin.faq.index')->with(
    		['data'=>$data,'req'=>$request->all(),'category'=>$category]);
    }
}
