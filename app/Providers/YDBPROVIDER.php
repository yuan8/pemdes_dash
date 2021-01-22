<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
class YDBPROVIDER extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }


    public static function query($q){
        return DB::select( DB::raw($q));
    }
}
