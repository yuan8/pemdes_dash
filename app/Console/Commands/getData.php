<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;
class getData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get-data:integrasi {tahun} {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $now_real=Carbon::now();
        $now_last=Carbon::now()->endOfDay();

        $table=$this->argument('table');
        $tahun=$this->argument('tahun');

        $select="select d.kddesa from master_desa as d left join ".$table." as td on ".
            "(td.kode_desa=d.kddesa) where ((td.kode_desa = d.kddesa and td.status_validasi = 0 and td.updated_at < '".Carbon::now()->addHours(-4)."' and td.tahun = ".$tahun.") OR (td.status_validasi is null)) limit 500";
        $ids=collect(DB::select($select
        ))->pluck('kddesa')->toArray();

        if($table="dash_ddk_pekerjaan"){
            // dd($ids);
        }
      


        $count=0;
         $this->info("find data ".count($ids)." from table ".$table);


        if(count($ids)){
            $column=['kode_desa'];
            $col=DB::table('master_column_map as c')
            ->join('master_table_map as m','c.id_ms_table','=','m.id')
            ->where('m.table',$table)
            ->get()->pluck('name_column')->toArray();

            $column=array_merge($column, $col);

            $data=DB::connection('staging')
            ->table($table.' as td')
            ->selectRaw(implode(',', $column))
            ->where('tahun',$tahun)
            ->whereIn('kode_desa',$ids)
            ->get();




            foreach ($data as $key => $v) {
                $v=(array)$v;
                $v['updated_at']=Carbon::now();
                $v['tahun']=$tahun;
                // $v['status_validasi']=5;
                // $v['validasi_date']=Carbon::now();

                $c=DB::table($table)->updateOrInsert(
                    [
                        'kode_desa'=>$v['kode_desa'],
                    ],
                    $v
                );

                if($c){
                    $count++;
                }


            }

            foreach($ids as $id){
                $c=DB::table($table)->where('kode_desa',$id)->updateOrInsert(
                    [
                        'kode_desa'=>$id,
                    ],
                    [

                        'updated_at'=>Carbon::now(),
                        'kode_desa'=>$id,
                        'tahun'=>$tahun,
                        'status_validasi'=>0
                    ]
                
                );

                // if($table=='dash_ddk_pekerjaan'){
                //     $desa=DB::table($table)->where('kode_desa',$id)->first();
                //      dd($c,$table,$id,$desa,
                //         Carbon::now()->addHours(-4)->toDateTimeString());
                // }

            
         }
        }
         $this->info("Building {$count} Data!");
        return $count.'/'.$count($ids).' - kode desa awal '.(count($ids)?$ids[0]:'');
    }
}
