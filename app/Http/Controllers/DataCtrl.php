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
          $tema_accept=[
            'TEMA_DATA_UTAMA',
            'TEMA_DATA_PENDUKUNG',
        ];

        

        if(in_array($type,['VISUALISASI','INFOGRAFIS','DATASET'])){
            $data=DB::connection('real')->table('data as d')
        ->leftJoin('category as i',[['i.id','=','d.organization_id'],['i.type','=',DB::raw("'INSTANSI'")]])
        ->leftJoin(DB::raw("(select cc.name as names,g.id_data from category as cc join data_group as g on ( cc.id=g.id_category and cc.type in ('".implode("','",$tema_accept)."')) ) as tema"),'tema.id_data','=','d.id')->groupBy('d.id')
        ->selectRaw('d.*,i.name as oranization_name,i.image_path as organization_image_path,GROUP_CONCAT(distinct(tema.names)) as temas,i.name as orgas');
        if(Auth::check()){
           $data=$data ->where([
                ['d.name','like',DB::raw("'%".$req."%'")],
                ['d.dashboard','=',true],
                ['d.delivery_type','=',$type],

                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],

            ])
            ->orWhere([
                ['d.keywords','like',DB::raw("'%".$req."%'")],
                ['d.dashboard','=',true],
                ['d.delivery_type','=',$type],
                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],

            ])
            ->orWhere([
                ['d.tags','like',DB::raw("'%".$req."%'")],
                ['d.dashboard','=',true],
                ['d.delivery_type','=',$type],
                [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],

            ])
            ->orWhere([
                ['d.description','like',DB::raw("'%".$req."%'")],
                ['d.dashboard','=',true],
                ['d.delivery_type','=',$type],
                [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],

            ])
             ->orWhere([
                ['tema.names','like',DB::raw("'%".$req."%'")],
                ['d.dashboard','=',true],
                ['d.delivery_type','=',$type],
                [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],

            ])
            ->orWhere([
                ['i.name','like',DB::raw("'%".$req."%'")],
                ['d.dashboard','=',true],
                ['d.delivery_type','=',$type],

                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],


            ])->orderBy('d.updated_at','desc')->paginate(10);
        }else{

            $data=$data ->where([
                ['d.name','like',DB::raw("'%".$req."%'")],
                ['d.auth','=',false],
                ['d.dashboard','=',true],
                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],

            ])
            ->orWhere([
                ['d.keywords','like',DB::raw("'%".$req."%'")],
                ['d.auth','=',false],
                ['d.dashboard','=',true],
                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],


            ])
            ->orWhere([
                ['d.tags','like',DB::raw("'%".$req."%'")],
                ['d.auth','=',false],
                ['d.dashboard','=',true],
                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],


            ])
            ->orWhere([
                ['d.description','like',DB::raw("'%".$req."%'")],
                ['d.auth','=',false],
                ['d.dashboard','=',true],
                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],


            ])
             ->orWhere([
                ['tema.names','like',DB::raw("'%".$req."%'")],
                ['d.auth','=',false],
                ['d.dashboard','=',true],
                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],


            ])
            ->orWhere([
                ['i.name','like',DB::raw("'%".$req."%'")],
                ['d.auth','=',false],
                ['d.dashboard','=',true],
                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],

            ])->orderBy('d.updated_at','desc')->paginate(10);

        }
        

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


            $data=DB::connection('real')->table('category as d')
             ->where([
                ['d.name','like',DB::raw("'%".$req."%'")],
                ['d.type','=','INSTANSI'],


            ])
             ->orWhere([
                ['d.description','like',DB::raw("'%".$req."%'")],
                ['d.type','=','INSTANSI'],



            ])
            ->paginate(10);

           
        return view('data.organisasi')->with(['data'=>$data,'request'=>$request,'title'=>'INSTANSI','hm'=>true]);
        
    }

    public function tema($tahun,Request $request){
        $req='';
        if($request->q){
            $req=$request->q;
        }
          $tema_accept=[
            'TEMA_DATA_UTAMA',
            'TEMA_DATA_PENDUKUNG',
        ];


            $data=DB::connection('real')->table('category as d')
           
            ->whereRaw("d.type in ('TEMA_DATA_PENDUKUNG','TEMA_DATA_UTAMA') and d.name like '%".$req."%'")
         
            ->OrwhereRaw("d.type in ('TEMA_DATA_UTAMA','TEMA_DATA_PENDUKUNG') and d.description like '%".$req."%'")

             ->selectRaw("concat(d.name,' - ',replace(d.type,'_',' ')) as name,d.id,d.type,d.route,d.image_path")
            ->paginate(10);
           
        return view('data.organisasi')->with(['data'=>$data,'request'=>$request,'title'=>'TEMA','hm'=>true]);
        
    }

    public function instansi_data($tahun,$type,$slug,Request $request){
        $type=strtoupper($type);
        $req='';
        if($request->q){
            $req=$request->q;
        }

        $instansi_data=DB::connection('real')->table('category')->where('id',$type)->first();
          $tema_accept=[
            'TEMA_DATA_UTAMA',
            'TEMA_DATA_PENDUKUNG',
        ];
    
        if(in_array($type,['VISUALISASI','INFOGRAFIS','DATASET'])){
            $data=DB::connection('real')->table('data as d')
            ->leftJoin('category as i',[['i.id','=','d.organization_id'],['i.type','=',DB::raw("'INSTANSI'")]])
           ->leftJoin(DB::raw("(select cc.name as names,g.id_data from category as cc join data_group as g on ( cc.id=g.id_category and cc.type in ('".implode("','",$tema_accept)."')) ) as tema"),'tema.id_data','=','d.id')->groupBy('d.id')
            ->selectRaw('d.*, i.name as oranization_name,i.image_path as organization_image_path,distinct(tema.names) as temas,i.name as orgas')
            ->groupBy('c.id')
            ->where([
                ['d.name','like',DB::raw("'%".$req."%'")],
                ['i.id','=',$type],
                ['d.dashboard','=',true],
                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],
                 $II


            ])
            ->orWhere([
                ['d.tags','like',DB::raw("'%".$req."%'")],
                ['i.id','=',$type],
                ['d.dashboard','=',true],
                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],
                 $II



            ])
             ->orWhere([
                ['d.description','like',DB::raw("'%".$req."%'")],
                ['i.id','=',$type],
                ['d.dashboard','=',true],
                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],
                 $II


            ])
            ->orWhere([
                ['d.keywords','like',DB::raw("'%".$req."%'")],
                ['i.id','=',$type],
                ['d.dashboard','=',true],
                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],
                 $II



            ])->orderBy('d.updated_at','desc')->paginate(10);

        return view('data.query')->with(['instansi'=>$instansi_data,'data'=>$data,'request'=>$request,'title'=>$type,'hm'=>true]);
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

    	$data=DB::connection('real')->table('data as d')
    	->leftJoin('category as i',[['i.id','=','d.organization_id'],['i.type','=',DB::raw("'INSTANSI'")]])
    	->leftJoin(DB::raw("(select cc.name as names,g.id_data from category as cc join data_group as g on ( cc.id=g.id_category and cc.type in ('".implode("','",$tema_accept)."')) ) as tema"),'tema.id_data','=','d.id')->groupBy('d.id')
    	->selectRaw('d.*,i.name as oranization_name,i.image_path as organization_image_path,GROUP_CONCAT(distinct(tema.names)) as temas,i.name as orgas');
    	if(Auth::check()){
           $data=$data ->where([
                ['d.name','like',DB::raw("'%".$req."%'")],
                ['d.dashboard','=',true],
                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],


            ])
            ->orWhere([
                ['d.keywords','like',DB::raw("'%".$req."%'")],
                ['d.dashboard','=',true],
                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],

            ])
            ->orWhere([
                ['d.tags','like',DB::raw("'%".$req."%'")],
                ['d.dashboard','=',true],
                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],

            ])
            ->orWhere([
                ['d.description','like',DB::raw("'%".$req."%'")],
                ['d.dashboard','=',true],
                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],

            ])
             ->orWhere([
                ['tema.names','like',DB::raw("'%".$req."%'")],
                ['d.dashboard','=',true],
                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],

            ])
            ->orWhere([
                ['i.name','like',DB::raw("'%".$req."%'")],
                ['d.dashboard','=',true],
                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],


            ])->orderBy('d.updated_at','desc')->paginate(10);
        }else{

            $data=$data ->where([
                ['d.name','like',DB::raw("'%".$req."%'")],
                ['d.auth','=',false],
                ['d.dashboard','=',true],
                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],

            ])
            ->orWhere([
                ['d.keywords','like',DB::raw("'%".$req."%'")],
                ['d.auth','=',false],
                ['d.dashboard','=',true],
                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],


            ])
            ->orWhere([
                ['d.tags','like',DB::raw("'%".$req."%'")],
                ['d.auth','=',false],
                ['d.dashboard','=',true],
                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],


            ])
            ->orWhere([
                ['d.description','like',DB::raw("'%".$req."%'")],
                ['d.auth','=',false],
                ['d.dashboard','=',true],
                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],


            ])
             ->orWhere([
                ['tema.names','like',DB::raw("'%".$req."%'")],
                ['d.auth','=',false],
                ['d.dashboard','=',true],
                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],


            ])
            ->orWhere([
                ['i.name','like',DB::raw("'%".$req."%'")],
                ['d.auth','=',false],
                ['d.dashboard','=',true],
                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],

            ])->orderBy('d.updated_at','desc')->paginate(10);

        }
        
        

    	return view('data.query')->with(['data'=>$data,'hm'=>false,'req'=>$request]);


    }


    public function categorical($tahun,$instansi,$slug=null,Request $request){
    	$req='';
    	if($request->q){
    		$req=$request->q;
    	}

    	$instansi_data=DB::connection('real')->table('category')->where('id',$instansi)->first();

    	if(!$instansi_data){
    		return abort('404');
    	}
        $tema_accept=[
            'TEMA_DATA_UTAMA',
            'TEMA_DATA_PENDUKUNG',
        ];
        if($instansi_data->type!='INSTANSI'){
                    $II=['tema.id_tema','=',$instansi_data->id];
        }else{
                    $II=['d.organization_id','=',$instansi_data->id];

        }


    	$data=DB::connection('real')->table('data as d')
    	->leftJoin('category as i',[['i.id','=','d.organization_id'],['i.type','=',DB::raw("'INSTANSI'")]])
    	 ->leftJoin(DB::raw("(select cc.name as names,g.id_data, cc.id as id_tema from category as cc join data_group as g on ( cc.id=g.id_category and cc.type in ('".implode("','",$tema_accept)."')) ) as tema"),'tema.id_data','=','d.id')->groupBy('d.id')
    	->selectRaw('d.*, i.name as oranization_name,i.image_path as organization_image_path,GROUP_CONCAT(distinct(tema.names)) as temas,i.name as orgas');

    	if(in_array($instansi_data->type,$tema_accept)){
    		if(Auth::check()){
                $data=$data
                ->orWhere([
                    ['d.keywords','like',DB::raw("'%".$req."%'")],
                ['d.dashboard','=',true],
                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],
                 $II


                ])
                ->orWhere([
                    ['d.tags','like',DB::raw("'%".$req."%'")],
                ['d.dashboard','=',true],
                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],
                 $II


                ])
                ->orWhere([
                    ['d.description','like',DB::raw("'%".$req."%'")],
                ['d.dashboard','=',true],
                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],
                 $II


                ])
                ->orWhere([
                    ['i.name','like',DB::raw("'%".$req."%'")],
                    ['d.dashboard','=',true],
                 [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],
                 $II


                ])->orderBy('d.updated_at','desc')->paginate(10);
            }else {

                $data=$data
                ->orWhere([
                    ['d.keywords','like',DB::raw("'%".$req."%'")],
                    ['d.auth','=',false],
                    ['d.dashboard','=',true],
                     [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],
                     $II


                ])
                ->orWhere([
                    ['d.tags','like',DB::raw("'%".$req."%'")],
                    ['d.auth','=',false],
                    ['d.dashboard','=',true],
                     [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],
                     $II


                ])
                ->orWhere([
                    ['d.description','like',DB::raw("'%".$req."%'")],
                    ['d.auth','=',false],
                    ['d.dashboard','=',true],
                     [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],
                     $II


                ])
                ->orWhere([
                    ['i.name','like',DB::raw("'%".$req."%'")],
                    ['d.auth','=',false],
                    ['d.dashboard','=',true],
                     [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],
                     $II


                ])->orderBy('d.updated_at','desc')->paginate(10);
            }

    	}else if($instansi_data->type=='INSTANSI'){
                $instansi=$instansi_data->id;

    		if(Auth::check()){
                $data=$data
                ->where([
                    ['d.name','like',DB::raw("'%".$req."%'")],
                    ['i.id','=',DB::raw($instansi)],
                    ['d.dashboard','=',true],
                     [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],
                     $II


                ])
               
                ->orWhere([
                    ['d.keywords','like',DB::raw("'%".$req."%'")],
                    ['i.id','=',DB::raw($instansi)],
                    ['d.dashboard','=',true],
                     [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],
                     $II

                ])
                 ->orWhere([
                    ['d.description','like',DB::raw("'%".$req."%'")],
                    ['i.id','=',DB::raw($instansi)],
                    ['d.dashboard','=',true],
                     [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],
                     $II


                ])
                ->orWhere([
                    ['d.tags','like',DB::raw("'%".$req."%'")],
                    ['i.id','=',DB::raw($instansi)],
                    ['d.dashboard','=',true],
                     [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],
                     $II


                ])
                ->orWhere([
                    ['i.name','like',DB::raw("'%".$req."%'")],
                    ['i.id','=',DB::raw($instansi)],
                    ['d.dashboard','=',true],
                     [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],
                     $II

                ])->orderBy('d.updated_at','desc')->paginate(10);

            }else{
                $data=$data
                ->where([
                    ['d.name','like',DB::raw("'%".$req."%'")],
                    ['i.id','=',DB::raw($instansi)],
                    ['d.auth','=',false],
                    ['d.dashboard','=',true],
                     [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],
                     $II


                ])
              
                ->orWhere([
                    ['d.keywords','like',DB::raw("'%".$req."%'")],
                    ['i.id','=',DB::raw($instansi)],
                    ['d.auth','=',false],
                    ['d.dashboard','=',true],
                     [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],
                     $II
                ])
                 ->orWhere([
                    ['d.description','like',DB::raw("'%".$req."%'")],
                    ['i.id','=',DB::raw($instansi)],
                    ['d.auth','=',false],
                    ['d.dashboard','=',true],
                     [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],
                     $II


                ])
                ->orWhere([
                    ['d.tags','like',DB::raw("'%".$req."%'")],
                    ['i.id','=',DB::raw($instansi)],
                    ['d.auth','=',false],
                    ['d.dashboard','=',true],
                     [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],
                     $II
                ])
                ->orWhere([
                    ['i.name','like',DB::raw("'%".$req."%'")],
                    ['i.id','=',DB::raw($instansi)],
                    ['d.auth','=',false],
                    ['d.dashboard','=',true],
                     [DB::RAW("(case when d.type='FILE' then (d.year=".($tahun).") else true end)"),'=',true],
                     $II


                ])->orderBy('d.updated_at','desc')->paginate(10);
            }

    	}else{
            $data=$data->where('d.id',0)->paginate(10);
        }


    	return view('data.query')->with(['data'=>$data,'request'=>$request,'instansi'=>$instansi_data,'hm'=>true]);


    }


    public function detail($tahun,$id,$slug=null){
        dd('s');
        $instansi=null;
        $data=DB::connection('real')->table('data as d')
        ->where('d.year',($tahun))
        ->where('d.id',$id)
        ->leftJoin('master_table_map as m','m.key_view','=','d.table_view')
        ->selectRaw("d.*,m.id as id_map_table")
        ->first();
        if($data){
            if($data->type=='FILE'){
                 $instansi=$instansi_data=DB::connection('real')->table('category')->where('id',$data->organization_id)->first();
                return view('data.data-set')->with(['data'=>$data,'instansi'=>$instansi,'hm'=>true]);
                switch ($data->delivery_type) {
                    case 'VISUALISASI':

                        return view('data.data-set')->with(['data'=>$data,'instansi'=>$instansi,'hm'=>true]);
                        break;

                    default:
                        # code...
                        break;
                }  
            }
            
        }else{
            return abort(404);
        }


    }
}
