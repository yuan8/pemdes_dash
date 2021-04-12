<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MENUAPI extends ServiceProvider
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

    static function render_menus(){
        return [

            [
                'text'=>'Services',
                'icon'=>'nav-icon i-Computer-Secure',
                'url'=>''
            ]
        ];
    }
}
