<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Notification;
use NotificationChannels\ChatAPI\ChatAPIMessage;
use NotificationChannels\ChatAPI\ChatAPIChannel;
use App\Notifications\WaBlash;



class NotifChangeDataCtrl extends Controller
{
    //

   
    public static function change($kode_daerah,$tahun,$id_table,$id_user){
    	$len=strlen($kode_daerah);

    	$tmap=DB::table('master_table_map')->find($id_table);
    	if($tmap){
    		$table=$tmap->table;
    		$ch_kode=$kode_daerah;
            $acc=[];
    		foreach ([2,4,6,10] as $key => $level) {

    			if(strlen($ch_kode)>=$level){
                    
    				$daer=substr($ch_kode,0,$level);
                    $acc[]=$daer;

    				$data=(array)DB::table($table.' as td')
		    		->selectRaw("
                        ".$daer." as kode_daerah,
                        '".$id_table."' as id_table_map,
                        ".$tahun." as tahun,
		    			count(distinct(case when td.status_validasi=5 then td.kode_desa else null end)) as valid,
		    			count(distinct(case when td.status_validasi=2 then td.kode_desa else null end)) as ver_10,
		    			count(distinct(case when td.status_validasi=3 then td.kode_desa else null end)) as ver_6,
		    			count(distinct(case when td.status_validasi=4 then td.kode_desa else null end)) as ver_4,
		    			count(distinct(case when (td.status_validasi=0 OR td.status_validasi=1) then td.kode_desa else null end)) as unhandle,
                        count(distinct(td.kode_desa)) as desa_terdata

		    		")
                    ->where('td.kode_desa','like',$daer.'%')
                    ->where('td.tahun',$tahun)
                    ->first();

                    if($data){
                        $jumlah_desa_total=DB::table('master_desa')->where('kddesa','like',$daer.'%')->count();

                        $data['desa_tidak_terdata']=((int)$jumlah_desa_total) - ((int)$data['desa_terdata']);
                        $data_up=$data;
                        $data_up['updated_at']=Carbon::now();
                        $data_up['id_user']=$id_user;
                        $data_up['tahun']=$tahun;
                        $data_up['kode_daerah_trigger']=$kode_daerah;
                        $data_up['status']=0;
                        $data_up['created_at']=Carbon::parse($tahun.'-12-30')->endOfMonth();
                        $acc[]=$data_up;
                        DB::table('tb_notifikasi_wa')->updateOrInsert([
                            'id_table_map'=>$data_up['id_table_map'],
                            'kode_daerah'=>$data_up['kode_daerah'],
                            'tahun'=>$data_up['tahun'],
                        ],$data_up);
                    }
    			}
    		}


    	}


    }


  

    static function mes_them($key,$value,$desa=0){
        $mes='';
       
        if($value){
            switch ($key) {
                case 'unhandle':
                    $mes='Data Belum Terverifikasi '.($desa?'':':').number_format($value).' Desa';
                    break;
                 case 'ver_10':
                    $mes='Data Verifikasi Desa/Kel '.($desa?'':':').number_format($value).' Desa';
                    break;
                 case 'ver_6':
                    $mes='Data Verifikasi Kecamatan '.($desa?'':':').number_format($value).' Desa';
                    break;
                // case 'ver_4':
                //     $mes='DATA DIVERIFIKASI KOTA/KAB '.$desa?'':':'.number_format($value).' DESA';
                //     break;
                  case 'valid':
                    $mes='Data Valid '.($desa?'':':').number_format($value).' Desa';
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

    public function testing(){
        $user=(object)['nomer_telpon'=>'6287836155136'];
        $message=['content'=>'ss'];

        Notification::route('chatapi', $user->nomer_telpon)
            ->notify(new WaBlash($message));


       

    }


    public static function notifWa(){
            $p=[];

        DB::table('tb_notifikasi_wa')
            ->where('status',1)
            ->where('updated_at','<',Carbon::now()->addDays(-2))->delete();
            
        set_time_limit(-1);
        ini_set('memory_limit', '3048M');

        $waktu=Carbon::now()->addDays(-1)->startOfDay();
        $waktu_end=Carbon::now()->addDays(-1)->endOfDay();

        $data=DB::table('tb_notifikasi_wa')
        // ->where('updated_at','>=',$waktu)
        // ->where('updated_at','<=',$waktu_end)
        // ->where('tahun',date('Y'))
        ->where('status',0)
        ->get();


        foreach ($data as $keyi => $value) {
            $dmeta=static::level(strlen($value->kode_daerah));
            $daerah=DB::table($dmeta[0])
            ->selectRaw("CONCAT('(',".$dmeta[1].",') ',".$dmeta[2].  ")".' as name')
            ->where($dmeta[1],'=',$value->kode_daerah)
            ->pluck('name')->first();


            $table=DB::table('master_table_map')->where('id',$value->id_table_map)->pluck('name')->first();

$message='
Rekap Data '.strtoupper($waktu->format('d F Y')).'
'.ucfirst(strtolower($table)).' Tahun '.$value->tahun.' Daerah '.ucfirst(strtolower($daerah)).' 

';
$nom=0;
foreach ($value as $key => $v) {
    
        $stat=static::mes_them($key,$v);
        if($stat){
            $nom++;

            $message.='
            '.($nom).'. '.static::mes_them($key,$v).'';


            }
    
}

dd($message);





    $user=DB::table('users')->where([
        ['kode_daerah','=',$value->kode_daerah],
        ['role','=',4],
        ['wa_number','=',true],
        ['wa_notif','=',true],
        ['is_active','=',true],
        [DB::raw("CHAR_LENGTH(nomer_telpon)"),'>',10]
    ])->get();

            // dd(urlencode($message));


            foreach ($user as $key => $u) {

                $p[]=[$u->nomer_telpon,$table];
                $m='HALLO '.strtoupper($u->name).' :-)
'.$message;
                $not=Notification::route('chatapi', $u->nomer_telpon)
                 ->notify(new WaBlash(['content'=>($m)]));
            }

            DB::table('tb_notifikasi_wa')->where('id',$value->id)->update([
                'status'=>1,
                'updated_at'=>Carbon::now()
            ]);



        }
            return $p;

    }

}
