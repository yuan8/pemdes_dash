<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $GLOBALS['chatapi_token']=config('setting_proepdeskel.wa.CHATAPI_TOKEN','');
        $GLOBALS['chatapi_url']=config('setting_proepdeskel.wa.CHATAPI_URL','');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        config(['services.chatapi.token'=>config('setting_proepdeskel.wa.CHATAPI_TOKEN','')]);
        config(['services.chatapi.api_url'=>config('setting_proepdeskel.wa.CHATAPI_URL','')]);


        // $GLOBALS['chatapi_token']=config('setting_proepdeskel.wa.CHATAPI_TOKEN','');
        // $GLOBALS['chatapi_url']=config('setting_proepdeskel.wa.CHATAPI_URL','');

        //
        // env(['CHATAPI_URL'=>config('setting_proepdeskel.wa.CHATAPI_URL')]);
        // env(['CHATAPI_TOKEN'=>config('setting_proepdeskel.wa.CHATAPI_TOKEN')]);

    }
}
