<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Storage;
class SettingWebProvider extends ServiceProvider
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

    static function setVal($key,$val){

        config(['proepdeskel.'.$key=>$val]);
        $set=config('proepdeskel');
        $set='<?php
        
return '.(var_export($set,true));
        $set=(trim($set)).';';
        
        $myfile = fopen(app_path('../config/proepdeskel.php'), "w") or die("Unable to open file!");
        fwrite($myfile, $set);
        fclose($myfile);
       

    }
}
