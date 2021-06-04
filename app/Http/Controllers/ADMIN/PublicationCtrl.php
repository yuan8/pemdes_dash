<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use mikehaertl\pdftk\Pdf;
use Validator;
use Alert;
use Auth;
use Storage;

class PublicationCtrl extends Controller
{
    //


    public function index($tahun,Request $request){

    	

    }

    public function create($tahun,$type,Request $request){

    	$category=DB::table('tb_category')->where('type','PUBLIKASI')->get();

    	$instansi=DB::table('master_instansi')->where('type','PUSAT')->get();


    	return view('admin.publikasi.create')->with(
    		[
    			'category'=>$category,
    			'instansi'=>$instansi,
    			'category_select_id'=>$type
    		]
    	);

    }

     public function store($tahun,Request $request){
    	$req=$request->all();



        if($request->file){
            $req['extension']=$request->file->getClientOriginalExtension();
        }
     	$valid=Validator::make($req,[
     		'title'=>'required|string',
     		'file'=>'required|file',
     		'extension'=>'required|string|in:pdf'
     	]);

     	if($valid->fails()){
     		Alert::error('',$valid->errors()->first());

     		return back()->withInputs();
     	}


     	$U=Auth::User();

     	if($U->can('is_only_daerah')){
     		$o='publication/daerah/'.$U->kode_daerah;
     	}else{
     		$valid=Validator::make($req,[
     		'id_instansi'=>'required|string',
     		]);

	     	if($valid->fails()){
	     		Alert::error('',$valid->errors()->first());
	     		return back()->withInputs();
	     	}

     		$o='publication/instansi/'.$request->id_instansi;
     	}

     	$rand=$U->id.'-'.date('Ymdhi').rand(0,100);
     	$path_per_page_def='/publication/'.$o.'/'.$rand.'/per_page';
     	$path_file_def='/publication/'.$o.'/'.$rand.'/';
     	$path=Storage::put('public/'.$path_file_def.'/',$request->file);
     	$pdf = new Pdf(storage_path('app/'.$path));

     	$path_per_page='storage'.$path_per_page_def;
     	$init=$req;
     	unset($init['file']);
     	Storage::put('public/'.$path_per_page_def.'/.init',json_encode($init,JSON_PRETTY_PRINT));
		$result = $pdf->burst(storage_path('app/public/'.$path_per_page_def.'/page_%d.pdf')); 
		$path=null;
		if ($result === false) {
			dd($pdf->getError());
		}else{
     		
     		$path=Storage::url($path);
		}

		if($path){
			dd('success',$result,url($path),url($path_per_page));
		}

    }
}
