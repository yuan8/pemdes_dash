<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
class TableMapCtrl extends Controller
{

    public function create($tahun){
        return view('admin.tablemap.create');
    }

     public function store($tahun,Request $request){
          $data=DB::table('master_table_map')
        ->insert([
            'name'=>$request->name,
            'table'=>$request->table,
            'key_view'=>$request->key_view,
            'id_user'=>Auth::User()->id,
            'edit_daerah'=>(int)$request->format_validasi
        ]);

        return back();
    }

    public function edit($tahun,$id){
          $data=DB::table('master_table_map')->where('id',$id)
        ->first();
        if($data){
            return view('admin.tablemap.edit')->with(['data'=>$data]);
        }
    }

    //
    public function editView($tahun,$id){
         $data=DB::table('master_table_map')->where('id',$id)
        ->first();
        if($data){
            $view=[];
            foreach([2=>'PROVINSI',4=>'KOTA/KAB',7=>'KECEMATAN',10=>"DESA/KELURAHAN"] as $kl=>$l){
                $view[$kl]=[
                    'head'=>$l,
                    'map'=>[]
                ];

                foreach([0,1,2,3] as $r){
                    $dr=DB::table('master_view_method')->where([
                        'id_ms_table'=>$id,
                        'level'=>$kl,
                        'row'=>$r
                    ])->get();

                    if($dr){
                        $view[$kl]['map'][$r]=$dr;
                    }

                }                
            }


            return view('admin.tablemap.view.edit')->with(['data'=>$data,'view'=>$view]);
        }
    }

    public function editColumns($tahun,$id){
        $data=DB::table('master_table_map')->where('id',$id)
        ->first();
        if($data){
            $m=DB::select(DB::raw("DESCRIBE ".$data->table));
            $master_c=[];
            foreach ($m as $key => $value) {
                # code...
                if(!in_array($value->Field, ['kode_desa','tahun'])){
                    $master_c[$value->Field]=$value;
                }

            }

            $columns=DB::table('master_column_map')->where('id_ms_table',$id)->get();


            return view('admin.tablemap.column.edit')->with(['data'=>$data,'columns'=>$columns,'master_c'=>$master_c]);
        }
    }

    public function update($tahun,$id,Request $request){
          $data=DB::table('master_table_map')->where('id',$id)
        ->first();

        if($data){
             $data=DB::table('master_table_map')->where('id',$id)
        ->update([
            'name'=>$request->name,
            'table'=>$request->table,
            'key_view'=>$request->key_view,
            'edit_daerah'=>(int)$request->format_validasi
            
        ]);
        }

        return back();
    }

    public function index($tahun,Request $request){
            $data=DB::table('master_table_map as m')
            ->selectRaw("m.*,(select count(t.id) from master_column_map as t where t.id_ms_table=m.id) as count_column");

        if($request->q){
            $data=$data->where([['table','like','%'.$request->q.'%']])
            ->oRwhere([['key_view','like','%'.$request->q.'%']]);

        }
        $data=$data->paginate(15);

        return view('admin.tablemap.index')->with(['data'=>$data,'request'=>$request]);
    }

   

   

    public function updateColumn($tahun,$id,Request $request){
         $data=DB::table('master_table_map')->where('id',$id)
        ->first();

        if($data){

             foreach ($request->columns as $key => $c) {
                    $c=(array)$c;
                    $c['auth']=(int)$c['auth'];
                    $c['dashboard']=(int)$c['dashboard'];
                    $c['validate']=(int)$c['validate'];
                    $c['id_user']=Auth::user()->id;


                if(strpos( (string)$key,'ID_')!==FALSE){
                    $id_c=(int)str_replace('ID_', '', $key);
                    DB::table('master_column_map')->where('id',$id_c)->update(
                        $c
                    );
                    
                }else if(strpos((string)$key,'NEW_')!==false) {

                    $c['id_ms_table']=$id;
                    DB::table('master_column_map')->insert(
                        $c
                    );

                }
            } 

             foreach ($request->remove??[] as $r){
                 $id_c=(int)str_replace('ID_', '', $r);
                    DB::table('master_column_map')->where('id',$id_c)->delete();

             }    

        }

        return back();

              
    	
    }
    public function updateView($tahun,$id,Request $request){
    	   $data=DB::table('master_table_map')->where('id',$id)
        ->first();

        if($data){

            DB::table('master_view_method')->where('id_ms_table',$id)->delete();
            $dddd=[];
             foreach ($request->view??[] as $l => $datal) {
                $datal=array_values($datal);
                foreach ($datal as $r => $d) {
                    foreach ($d as $key => $dd) {

                       DB::table('master_view_method')->insert([
                            'id_ms_table'=>$id,
                            'type'=>$dd['type'],
                            'level'=>$l,
                            'row'=>$r,
                            'id_user'=>Auth::User()->id
                        ]);
                        # code...
                    }
                   

                    # code...
                }
             }
         }

         return back();
    }


    public function form_delete($tahun,$id){
          $data=DB::table('master_table_map')->where('id',$id)
        ->first();

        if($data){
            return view('admin.tablemap.delete')->with('data',$data);
        }
    }

      public function delete($tahun,$id){
          $data=DB::table('master_table_map')->where('id',$id)
        ->first();

        if($data){
             $data=DB::table('master_table_map')->where('id',$id)->delete();
        }

        return back();
    }
}
