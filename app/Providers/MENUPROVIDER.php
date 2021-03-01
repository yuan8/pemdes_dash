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
                    'text'=>('DATA'),
                    'href'=>route('admin.data.index',['tahun'=>$GLOBALS['tahun_access']]),
                    'class'=>'',
                    'icon'=>'fa fa-file',
                ],
                [
                    'text'=>('VERIFIKASI DAN VALIDASI DATA'),
                    'href'=>route('admin.validasi.index',['tahun'=>$GLOBALS['tahun_access']]),
                    'class'=>'',
                    'icon'=>'fa fa-check',
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
