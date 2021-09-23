<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \GuzzleHttp\Client as ProviderClient;
use DB;
use HP;
use Carbon\Carbon;
class WAAPICTRL extends Controller
{


    public static function build_content_text($d){
        $d=(Array)$d;

        $mes=['Hasil Rekap Data  "'.ucwords($d['nama_data']).'" Tahun '.$d['tahun'].'
        ','-> '.ucwords(HP::daerah_level($d['kode_daerah'])).'
        ',
        '
        ',
        Carbon::parse($d['updated_at'])->format('d F Y')
        ,
        '
       ******************************
        '
        ,
        '
        '
        ];


        foreach($d as $k=>$v){
            switch($k){
                case 'valid':
                $mes[]="Jumlah Desa Ter-validasi : ".number_format((int)$v,0,'.',',')." Desa
                ";
                break;
                case 'ver_6':
                $mes[]="Jumlah Desa Ter-verifikasi Kecamatan : ".number_format((int)$v,0,'.',',')." Desa
                ";
                break;
                 case 'ver_10':
                $mes[]="Jumlah Desa Ter-verifikasi Desa / Kelurahan : ".number_format((int)$v,0,'.',',')." Desa
                ";
                break;
            }
        }
        $mes[]='
        ';

        $keyd='kddesa';
        if(strlen($d['kode_daerah'])==6){
            $keyd='kdkecamatan';
        }else  if(strlen($d['kode_daerah'])==4){
            $keyd='kdkabkota';
        }else  if(strlen($d['kode_daerah'])==2){
            $keyd='kdprovinsi';
        }

        $mes[]=route('admin.validasi.data',['tahun'=>date('Y'),'data'=>$d['id_data'],$keyd=>$d['kode_daerah']]);

        return array_values($mes);
    }

   public static function init(){

        $data_init=DB::table('tb_notifikasi_wa as n')
        ->leftJoin('master_table_map as mp','mp.id','=','n.id_table_map')
        ->leftJoin('users as p',[
            ['p.kode_daerah','=','n.kode_daerah'],
            ['p.wa_number','=',DB::raw(1)],
            ['p.wa_notif','=',DB::RAW(1)]
        ])
        ->where('n.status',0)
        ->where('n.tahun',date('Y'))
        ->where('n.tahun',date('Y'))

        ->orderBy('n.kode_daerah','asc')
        ->groupBy('n.kode_daerah')
        ->selectRaw("         
                '".date('Y')."' as tahun, 
                n.kode_daerah as kode_daerah, 
                group_concat(distinct(p.nomer_telpon),'||') as list_nomer,     
                n.id_table_map as id_data,
                n.id as id,
                mp.name as nama_data,n.valid,n.ver_6,n.ver_10,n.unhandle,n.desa_terdata,n.desa_tidak_terdata,n.updated_at as updated_at")
        ->get();



        $data=[];
        $message=[];

        foreach($data_init as $d){
            $message_content=implode("\n",array_map('trim',static::build_content_text($d)));
            foreach(explode('||',$d->list_nomer)??[] as $key=>$number){
                if($number){
                    $message[]=[
                        'to'=>$number,
                        'content'=>$message_content,
                        'send_date'=>Carbon::parse(date('d-m-Y ').'07:00:00'),
                    ];
                }
            }
        }       




        $provider=new ProviderClient();


        $response = $provider->request('POST', env('WAAPI_HOST',''),[
            'headers' => [
                'Accept'     => 'application/json',
                'Authorization'  => 'Bearer '.env('WAAPI_TOKEN',''),
            ],
            'json'=>[
                'bulk'=>$message
            ]
        ]);



        $re=[
            'code'=>$response->getStatusCode(),
            'body'=>$response->getBody(),
            'data'=>$message
        ];



        return ($re);



        



   }




    
}
