<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
class NotifChangeDataCtrl extends Controller
{
    //


    public static function change($kode_daerah,$tahun,$id_table,$id_user){
    	$len=strlen($kode_daerah);

    	$tmap=DB::table('master_table_map')->find($id_table);
    	if($tmap){
    		$table=$tmap->table;
    		$ch_kode=$kode_daerah;
    		foreach ([10,6,4,2] as $key => $level) {
    			if(strlen($ch_kode)<$level){
    				$ch_kode=substr($ch_kode,0,$level)
    				$data=(array)DB::table($table.' as td')
		    		->selectRaw("
                        ".$ch_kode." as kode_daerah,
                        '".$id_table."' as id_table_map,
                        ".$tahun." as tahun,
		    			count(distinct(case when td.status_validasi=5 then td.kode_desa else null end)) as valid,
		    			count(distinct(case when td.status_validasi=2 then td.kode_desa else null end)) as ver_10,
		    			count(distinct(case when td.status_validasi=3 then td.kode_desa else null end)) as ver_6,
		    			count(distinct(case when td.status_validasi=4 then td.kode_desa else null end)) as ver_4,
		    			count(distinct(case when (td.status_validasi=0 OR td.status_validasi=1) then td.kode_desa else null end)) as unhandle,
                        count(distinct(td.kode_desa)) as desa_terdata

		    		")
                    ->where('td.kode_desa','like',$ch_kode.'%')
                    ->where('td.tahun',$tahun)
                    ->first();

                    if($data){
                        $jumlah_desa_total=DB::table('master_desa')->where('kddesa','like',$ch_kode.'%')->count();
                        $data['desa_tidak_terdata']=(int)$jumlah_desa_total- (int)['desa_terdata'];
                        $data_up=$data;
                        $data_up['updated_at']=Carbon::now(),
                        $data_up['id_user']=$id_user,
                        $data_up['kode_daerah_trigger']=$kode_daerah,

                        DB::table('tb_notifikasi_wa')->updateOrInsert($data,$data_up);
                    }
    			}
    		}


    	}
    }


  

    static function mes_them($key,$value){
        $mes='';
        if($value){
            switch ($key) {
                case 'unhandle':
                    $mes='DATA BELUM DI VERIFIKASI : '.number_format($value).' DESA \n';
                    break;
                 case 'ver_10':
                    $mes='DATA DIVERIFIKASI DESA : '.number_format($value).' DESA \n';
                    break;
                 case 'ver_6':
                    $mes='DATA DIVERIFIKASI KECAMATAN : '.number_format($value).' DESA \n';
                    break;
                case 'ver_4':
                    $mes='DATA DIVERIFIKASI KOTA/KAB : '.number_format($value).' DESA \n';
                    break;
                  case 'valid':
                    $mes='DATA VALID : '.number_format($value).' DESA \n';
                    break;
                
                default:
                    # code...
                    break;
            }

        }
        return $mes;
    }

    static function level($level){
        switch ($level) {
            case 2:
            return ['master_provinsi','kdprovinsi','nmprovinsi'];
                # code...
                break;
            case 4:
            return ['master_kabkota','kdkabkota','nmkabkota'];
                # code...
                break;
            case 6:
            return ['master_kecamatan','kdkecamatan','nmkecamatan'];
                # code...
                break;
            case 10:
            return ['master_desa','kddesa','nmdesa'];
                # code...
                break;
            
            default:
                # code...
                break;
        }
    }


    public function notifWa(){

        $waktu=Carbon::now()->addDays(-1)->startOfDay();
        $data=DB::table('tb_notifikasi_wa')
        ->where('updated_at','>',$waktu)
        ->where('tahun',date('Y'))
        ->where('status',0)
        ->limit(10)->get();

        foreach ($data as $keyi => $value) {
            $dmeta=static::level(strlen($value->kode_daerah));
            $daerah=DB::table($dmeta[0])->selectRaw($dmeta[1].' as name')->where($dmeta[1],'=',$value->kode_daerah)->pluck('name')->first();

            $message='KONDISI DATA '.''.' DAERAH '.$daerah.'\n';
            foreach ($value as $key => $v) {
                $message.=static::mes_them($key,$v);
            }

            $user=DB::table('users')->where([
                ['kode_daerah','=',$value->kode_daerah],
                ['role','=',4],
                ['is_active','=',true],
                [DB::raw("CHAR_LENGTH(nomer_telpon)"),'>',10]
            ])->get()->pluck('nomer_telpon');

            foreach ($user as $key => $value) {
                
            }

        }
    }

}
