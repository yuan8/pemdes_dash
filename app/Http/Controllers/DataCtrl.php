<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use YDB;
use Auth;
class DataCtrl extends Controller
{
    //

    public function delivery_type($tahun,$type,Request $request){
        $type=strtoupper($type);
        $req='';
        if($request->q){
            $req=$request->q;
        }

        

        if(in_array($type,['VISUALISASI','INFOGRAFIS','DATASET'])){
            $data=DB::table('data as d')
            ->leftJoin('category as i',[['i.id','=','d.organization_id'],['i.type','=',DB::raw("'INSTANSI'")]])
            ->leftJoin(DB::raw("(select GROUP_CONCAT(concat(c.id,'|',c.name),'||') as names,dg.id_data from category as c left join data_group as dg on dg.id_category where c.type='TEMA_PRIMER' OR c.type='TEMA_SEKUNDER' group by dg.id) as tema"),'tema.id_data','=','d.id')
            ->selectRaw('d.*,i.name as oranization_name,i.image_path as organization_image_path,tema.names as temas,i.name as orgas')
            ->where([
                ['d.name','like',DB::raw("'%".$req."%'")],
                ['d.delivery_type','=',$type],


            ])
            ->orWhere([
                ['d.keywords','like',DB::raw("'%".$req."%'")],
                ['d.delivery_type','=',$type],


            ])
            ->orWhere([
                ['d.tags','like',DB::raw("'%".$req."%'")],
                ['d.delivery_type','=',$type],

            ])
            ->orWhere([
                ['d.description','like',DB::raw("'%".$req."%'")],
                ['d.delivery_type','=',$type],

            ])
            ->orWhere([
                ['i.name','like',DB::raw("'%".$req."%'")],
                ['d.delivery_type','=',$type],

            ])->orderBy('d.updated_at','desc')->paginate(10);

        return view('data.query')->with(['data'=>$data,'request'=>$request,'title'=>$type]);
        }else{
            return abort(404);
        }
    }

    public function instansi($tahun,Request $request){
        $req='';
        if($request->q){
            $req=$request->q;
        }


            $data=DB::table('category as d')
             ->where([
                ['d.name','like',DB::raw("'%".$req."%'")],
                ['d.type','=','INSTANSI'],

            ])
             ->orWhere([
                ['d.description','like',DB::raw("'%".$req."%'")],
                ['d.type','=','INSTANSI'],


            ])
            ->paginate(10);
           
        return view('data.organisasi')->with(['data'=>$data,'request'=>$request,'title'=>'INSTANSI']);
        
    }

    public function tema($tahun,Request $request){
        $req='';
        if($request->q){
            $req=$request->q;
        }


            $data=DB::table('category as d')
             ->where([
                ['d.name','like',DB::raw("'%".$req."%'")],
                ['d.type','!=','INSTANSI'],

            ])
             ->orWhere([
                ['d.description','like',DB::raw("'%".$req."%'")],
                ['d.type','!=','INSTANSI'],


            ])
            ->paginate(10);
           
        return view('data.organisasi')->with(['data'=>$data,'request'=>$request,'title'=>'TEMA']);
        
    }

    public function instansi_data($tahun,$type,$slug,Request $request){
        $type=strtoupper($type);
        $req='';
        if($request->q){
            $req=$request->q;
        }

        $instansi_data=DB::table('category')->where('id',$type)->first();

    
        if(in_array($type,['VISUALISASI','INFOGRAFIS','DATASET'])){
            $data=DB::table('data as d')
            ->leftJoin('category as i',[['i.id','=','d.organization_id'],['i.type','=',DB::raw("'INSTANSI'")]])
            ->leftJoin(DB::raw("(select GROUP_CONCAT(concat(c.id,'|',c.name),'||') as names,dg.id_data from category as c left join data_group as dg on dg.id_category where c.type='TEMA_PRIMER' OR c.type='TEMA_SEKUNDER' group by dg.id) as tema"),'tema.id_data','=','d.id')
            ->selectRaw('d.*,i.name as oranization_name,i.image_path as organization_image_path,tema.names as temas,i.name as orgas')
            ->groupBy('c.id')
            ->where([
                ['d.name','like',DB::raw("'%".$req."%'")],
                ['i.id','=',$type],

            ])
            ->orWhere([
                ['d.tags','like',DB::raw("'%".$req."%'")],
                ['i.id','=',$type],


            ])
             ->orWhere([
                ['d.description','like',DB::raw("'%".$req."%'")],
                ['i.id','=',$type],

            ])
            ->orWhere([
                ['d.keywords','like',DB::raw("'%".$req."%'")],
                ['i.id','=',$type],


            ])->orderBy('d.updated_at','desc')->paginate(10);

        return view('data.query')->with(['instansi'=>$instansi_data,'data'=>$data,'request'=>$request,'title'=>$type]);
        }else{
            return abort(404);
        }
    }

    public function index($tahun,Request $request){
    	$req='';
    	if($request->q){
    		$req=$request->q;
    	}
         $tema_accept=[
            'TEMA_DATA_UTAMA',
            'TEMA_DATA_PENDUKUNG',
        ];

    	$data=DB::table('data as d')
    	->leftJoin('category as i',[['i.id','=','d.organization_id'],['i.type','=',DB::raw("'INSTANSI'")]])
    	->leftJoin(DB::raw("(select GROUP_CONCAT(concat(c.id,'|',c.name),'||') as names,dg.id_data from category as c left join data_group as dg on dg.id_category where c.type in ('".implode("','",$tema_accept)."') group by dg.id) as tema"),'tema.id_data','=','d.id')
    	->selectRaw('d.*,i.name as oranization_name,i.image_path as organization_image_path,tema.names as temas,i.name as orgas');
    	if(Auth::check()){
           $data=$data ->where([
                ['d.name','like',DB::raw("'%".$req."%'")],
            ])
            ->orWhere([
                ['d.keywords','like',DB::raw("'%".$req."%'")],
            ])
            ->orWhere([
                ['d.tags','like',DB::raw("'%".$req."%'")],
            ])
            ->orWhere([
                ['d.description','like',DB::raw("'%".$req."%'")],
            ])
             ->orWhere([
                ['tema.names','like',DB::raw("'%".$req."%'")],
            ])
            ->orWhere([
                ['i.name','like',DB::raw("'%".$req."%'")],

            ])->orderBy('d.updated_at','desc')->paginate(10);
        }else{

            $data=$data ->where([
                ['d.name','like',DB::raw("'%".$req."%'")],
                ['d.auth','=',false]
            ])
            ->orWhere([
                ['d.keywords','like',DB::raw("'%".$req."%'")],
                ['d.auth','=',false]

            ])
            ->orWhere([
                ['d.tags','like',DB::raw("'%".$req."%'")],
                ['d.auth','=',false]

            ])
            ->orWhere([
                ['d.description','like',DB::raw("'%".$req."%'")],
                ['d.auth','=',false]

            ])
             ->orWhere([
                ['tema.names','like',DB::raw("'%".$req."%'")],
                ['d.auth','=',false]

            ])
            ->orWhere([
                ['i.name','like',DB::raw("'%".$req."%'")],
                ['d.auth','=',false]
            ])->orderBy('d.updated_at','desc')->paginate(10);

        }

    	return view('data.query')->with(['data'=>$data,'hm'=>false,'req'=>$request]);


    }


    public function categorical($tahun,$instansi,$slug=null,Request $request){
    	$req='';
    	if($request->q){
    		$req=$request->q;
    	}

    	$instansi_data=DB::table('category')->where('id',$instansi)->first();

    	if(!$instansi_data){
    		return abort('404');
    	}
        $tema_accept=[
            'TEMA_DATA_UTAMA',
            'TEMA_DATA_PENDUKUNG',
        ];

    	$data=DB::table('data as d')
    	->leftJoin('category as i',[['i.id','=','d.organization_id'],['i.type','=',DB::raw("'INSTANSI'")]])
    	->leftJoin(DB::raw("(select GROUP_CONCAT(concat(c.id,'|',c.name),'||') as names,dg.id_data from category as c join data_group as dg on dg.id_category=c.id where c.type in ('".implode("','",$tema_accept)."') group by dg.id) as tema"),'tema.id_data','=','d.id')
    	->selectRaw('d.*,i.name as oranization_name,i.image_path as organization_image_path,tema.names as temas,i.name as orgas');

    	if(in_array($instansi_data->type,$tema_accept)){
    		if(Auth::check()){
                $data=$data
                ->orWhere([
                    ['d.keywords','like',DB::raw("'%".$req."%'")],

                ])
                ->orWhere([
                    ['d.tags','like',DB::raw("'%".$req."%'")],

                ])
                ->orWhere([
                    ['d.description','like',DB::raw("'%".$req."%'")],

                ])
                ->orWhere([
                    ['i.name','like',DB::raw("'%".$req."%'")],

                ])->orderBy('d.updated_at','desc')->paginate(10);
            }else {

                $data=$data
                ->orWhere([
                    ['d.keywords','like',DB::raw("'%".$req."%'")],
                    ['d.auth','=',false]

                ])
                ->orWhere([
                    ['d.tags','like',DB::raw("'%".$req."%'")],
                    ['d.auth','=',false]

                ])
                ->orWhere([
                    ['d.description','like',DB::raw("'%".$req."%'")],
                    ['d.auth','=',false]

                ])
                ->orWhere([
                    ['i.name','like',DB::raw("'%".$req."%'")],
                    ['d.auth','=',false]

                ])->orderBy('d.updated_at','desc')->paginate(10);
            }

    	}else if($instansi_data->type=='INSTANSI'){
                $instansi=$instansi_data->id;

    		if(Auth::check()){
                $data=$data
                ->where([
                    ['d.name','like',DB::raw("'%".$req."%'")],
                    ['i.id','=',DB::raw($instansi)],
                ])
               
                ->orWhere([
                    ['d.keywords','like',DB::raw("'%".$req."%'")],
                    ['i.id','=',DB::raw($instansi)],
                ])
                 ->orWhere([
                    ['d.description','like',DB::raw("'%".$req."%'")],
                    ['i.id','=',DB::raw($instansi)],

                ])
                ->orWhere([
                    ['d.tags','like',DB::raw("'%".$req."%'")],
                    ['i.id','=',DB::raw($instansi)],

                ])
                ->orWhere([
                    ['i.name','like',DB::raw("'%".$req."%'")],
                    ['i.id','=',DB::raw($instansi)],
                ])->orderBy('d.updated_at','desc')->paginate(10);

            }else{
                $data=$data
                ->where([
                    ['d.name','like',DB::raw("'%".$req."%'")],
                    ['i.id','=',DB::raw($instansi)],
                    ['d.auth','=',false]

                ])
              
                ->orWhere([
                    ['d.keywords','like',DB::raw("'%".$req."%'")],
                    ['i.id','=',DB::raw($instansi)],
                    ['d.auth','=',false]


                ])
                 ->orWhere([
                    ['d.description','like',DB::raw("'%".$req."%'")],
                    ['i.id','=',DB::raw($instansi)],
                    ['d.auth','=',false]

                ])
                ->orWhere([
                    ['d.tags','like',DB::raw("'%".$req."%'")],
                    ['i.id','=',DB::raw($instansi)],
                    ['d.auth','=',false]


                ])
                ->orWhere([
                    ['i.name','like',DB::raw("'%".$req."%'")],
                    ['i.id','=',DB::raw($instansi)],
                    ['d.auth','=',false]

                ])->orderBy('d.updated_at','desc')->paginate(10);
            }

    	}else{
            $data=$data->where('d.id',0)->paginate(10);
        }


    	return view('data.query')->with(['data'=>$data,'request'=>$request,'instansi'=>$instansi_data]);


    }


    public function detail($tahun,$id,$slug=null){
        $instansi=null;
        $data=DB::table('data as d')
        ->where('id',$id)->first();

        // dd($data);

        if($data){
            $instansi=$instansi_data=DB::table('category')->where('id',$data->organization_id)->first();
            switch ($data->delivery_type) {
                case 'DATASET':
                    return view('data.data-set')->with(['data'=>$data,'instansi'=>$instansi]);
                    break;

                default:
                    # code...
                    break;
            }
        }else{
            return abort(404);
        }


    }
}
