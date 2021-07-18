<?php

namespace App\Http\Controllers\ADMIN;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Storage;
use Alert;
class SettingCtrl extends Controller
{
    //

    public function setData($context,$data){
        $setting=file_get_maps(config_path('pemdeskel.php'));
        switch ($context) {
            case 'pages':
                # code...
                break;
            case 'pages':
                # code...
                break;
            
            default:
                # code...
                break;
        }

        return $setting;

    }

    public function public_tentang($tahun){
    	;
    	return view('admin.setting.public_tentang');
    }

    // public function index($tahun){
    // 	$data=(array)(DB::table('settings')->where('flag','TENTANG')->first()??['value'=>'','flag'=>'TENTANG']);
    // 	return view('admin.setting.tentang')->with('data',$data);
    // }


    public function index($tahun,Request $request){
        $map=[
            'wa'=>[
                    'CHATAPI_TOKEN'=>'input_string',
                    'CHATAPI_URL'=>'input_string'
            ],
            'tentang'=>[
                'description'=>'richtext'
            ],
            'running_text'=>
            [
                'popup_announcement_text'=>'richtext'
            ],
            'header_box'=>[
                'description'=>'richtext'
            ]
        ];

        if($request->menu){
            if(isset($map[$request->menu])){
                $menu=$map[$request->menu];
            }
        }else{
            $menu=$map['tentang'];
            $request['menu']='tentang';
        }

        $data=[];
        foreach ($menu as $key => $m) {
            $flag=$request->menu.'.'.$key;

            $data[$flag]['type_field']=$m;
            $content=DB::table('master_setting')->where('flag',$flag)->first();
            if($content){
            $data[$flag]['content']=$content->value;

            }else{
            $data[$flag]['content']=null;
            }

        }
        static::build_config($data);

        return view('admin.setting.index')->with(['menu'=>$request->menu,'map'=>$map,'data'=>$data]);


    }



    static function build_config($data){
        $def='setting_proepdeskel';
        $config=config($def);

        foreach($data as $flag=>$content){
            config([$def.'.'.$flag=>isset($content['content'])?$content['content']:null]);
        }



        $config_file_content=trim("<"."?php
        return ".(String)var_export(config($def),true).';');

        Storage::disk('config')->put($def.'.php',$config_file_content);

    }

     public function update($tahun,Request $request){
     	foreach ($request->except(['_token']) as $flag => $value) {
     		$flag=str_replace('-----','.',$flag);
            
     		$data=DB::table('master_setting')->updateOrInsert([
     			'flag'=>$flag
     		],
     		[
     			'flag'=>$flag,
     			'value'=>$value
     		]);
     	}

        Alert::success('Berhasil');
        static::build_config($request->except(['_token']));


     	return back();
    	
    }
}
