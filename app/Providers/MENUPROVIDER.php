<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MENUPROVIDER extends ServiceProvider
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


    static function dashboard(){
        $menu=[
            'side_left'=>[],
            'top'=>[
                 [
                    'text'=>('Data'),
                    'href'=>route('query.data' ),
                    'top_nav_class'=>'',
                    'icon'=>'fa fa-file',

                ],
                 [
                    'text'=>('Organisasi'),
                    'href'=>'#',
                    'top_nav_class'=>'',
                    'icon'=>'fa fa-users',

                ],
                 [
                    'text'=>('Topik'),
                    'href'=>'#',
                    'top_nav_class'=>'',
                    'icon'=>'fa fa-hashtag',

                ],
                 [
                    'text'=>('Visualisasi'),
                    'href'=>'#',
                    'top_nav_class'=>'',
                    'icon'=>'fa fa-eye',

                ],
                 [
                    'text'=>('Infografis'),
                    'href'=>'#',
                    'top_nav_class'=>'',
                    'icon'=>'fa fa-image',

                ],
                 [
                    'text'=>('Tentang Kami'),
                    'href'=>'#',
                    'top_nav_class'=>'',
                    'icon'=>'fa fa-question',

                ],
            ],
            'side_right'=>[]
        ];

        return $menu;
    }
}
