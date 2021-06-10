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
        $now=Carbon::now()->endOfDay();
        $table=$this->argument('table');
        $tahun=$this->argument('tahun');


        $ids=DB::table('master_desa as d')
        ->leftJoin($table.' as td','td.kode_desa','=','d.kddesa')
        ->whereRaw("(td.status_validasi=0 and td.updated_at<'".$now."' and td.tahun=".$tahun.") OR (td.status_validasi is null)")
        ->limit(200)
        ->get()
        ->pluck('kddesa')
        ->toArray();
        $count=0;

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
                $v['updated_at']=$now;
                $v['tahun']=$tahun;

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
        }

        return $count;
    }
}
