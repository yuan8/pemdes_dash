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
            'side_left'=>[
               
            ],
            'top'=>[
                 [
                    'text'=>('Data'),
                    'href'=>route('query.data',['tahun'=>$GLOBALS['tahun_access']]),
                    'top_nav_class'=>'',
                    'icon'=>'fa fa-file',

                ],

                 [
                    'text'=>('Index Desa'),
                    'href'=>route('organisasi',['tahun'=>$GLOBALS['tahun_access']]),
                    'top_nav_class'=>'',
                    'icon'=>'fa fa-tag',

                ],
                 [
                    'text'=>('Instansi'),
                    'href'=>route('organisasi',['tahun'=>$GLOBALS['tahun_access']]),
                    'top_nav_class'=>'',
                    'icon'=>'fa fa-users',

                ],
                 [
                    'text'=>('Tema'),
                    'href'=>route('tema',['tahun'=>$GLOBALS['tahun_access']]),
                    'top_nav_class'=>'',
                    'icon'=>'fa fa-hashtag',

                ],
                 [
                    'text'=>('Publikasi'),
                    'href'=>route('query.data.delivery',['tahun'=>$GLOBALS['tahun_access'],'type'=>'publikasi']),
                    'top_nav_class'=>'',
                    'icon'=>'fa fa-eye',

                ],
                 [
                    'text'=>('Infografis'),
                    'href'=>route('query.data.delivery',['tahun'=>$GLOBALS['tahun_access'],'type'=>'infografis']),
                    'top_nav_class'=>'',
                    'icon'=>'fa fa-image',

                ],
                //  [
                //     'text'=>('Tentang Kami'),
                //     'href'=>'#',
                //     'top_nav_class'=>'',
                //     'icon'=>'fa fa-question',

                // ],
            ],
            'side_right'=>[]
        ];
        $GLOBALS['MENU_TOP']=$menu['top'];
        return $menu;
    }


    public static function admin(){

        $menu=[
            'top'=>[],
            'side_left'=>[
                 [
                    'text'=>('KATEGORI'),
                    'href'=>route('admin.kategori.index',['tahun'=>$GLOBALS['tahun_access']]),
                    'class'=>'',
                    'icon'=>'fa fa-circle',

                ],
                 [
                    'text'=>('TABLE MAP'),
                    'href'=>route('admin.validasi.index',['tahun'=>$GLOBALS['tahun_access']]),
                    'class'=>'',
                    'icon'=>'fa fa-code',
                ],

                [
                    'text'=>('DATASET'),
                    'href'=>route('admin.data.index',['tahun'=>$GLOBALS['tahun_access']]),
                    'class'=>'',
                    'icon'=>'fa fa-file',
                ],
                [
                    'text'=>('VALIDASI DATA'),
                    'href'=>route('admin.validasi.index',['tahun'=>$GLOBALS['tahun_access']]),
                    'class'=>'',
                    'icon'=>'fa fa-check',
                ],
               
                [
                    'text'=>('DATA VIEW'),
                    'href'=>route('admin.dataview.index',['tahun'=>$GLOBALS['tahun_access']]),
                    'class'=>'',
                    'icon'=>'fa fa-file',
                ],
                 
                 [
                    'text'=>('USERS'),
                    'href'=>'#',
                    'class'=>'',
                    'icon'=>'fa fa-users',

                ],
                 
            ],
            'side_right'=>[]
        ];
        return $menu;
    }

    public static function login(){
        return [
            'top'=>[],
            'side_left'=>[],
            'side_right'=>[]

        ];
    }
}
