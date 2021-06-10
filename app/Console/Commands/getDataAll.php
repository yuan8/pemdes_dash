<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
class getDataAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'integrasi:data';

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
        $tb=DB::table('master_table_map')->where('edit_daerah',true)->get()->pluck('table')->toArray();
        $rekap=[];

        $tahun=date('Y');

        foreach ($tb as $key => $table) {
            $rekap[$table]=Artisan::call('get-data:integrasi', [
                    'tahun' => $tahun,'table'=>$table
            ]);
        }

        return $rekap;

    }
}
