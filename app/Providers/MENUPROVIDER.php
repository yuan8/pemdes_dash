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
                    'class'=>'',
                    'icon'=>'fa fa-file',

                ],

                 [
                    'text'=>('Index Desa'),
                    'href'=>route('organisasi',['tahun'=>$GLOBALS['tahun_access']]),
                    'class'=>'',
                    'top_nav_class'=>'',

                    'icon'=>'fa fa-tag',

                ],
                 [
                    'text'=>('Instansi'),
                    'href'=>route('organisasi',['tahun'=>$GLOBALS['tahun_access']]),
                    'top_nav_class'=>'',
                    'class'=>'',

                    'icon'=>'fa fa-users',

                ],
                 [
                    'text'=>('Tema'),
                    'href'=>route('tema',['tahun'=>$GLOBALS['tahun_access']]),
                    'top_nav_class'=>'',
                    'class'=>'',

                    'icon'=>'fa fa-hashtag',

                ],
                 [
                    'text'=>('Publikasi'),
                    'href'=>route('query.data.delivery',['tahun'=>$GLOBALS['tahun_access'],'type'=>'publikasi']),
                    'top_nav_class'=>'',
                    'class'=>'',

                    'icon'=>'fa fa-eye',

                ],
                 [
                    'text'=>('Infografis'),
                    'href'=>route('query.data.delivery',['tahun'=>$GLOBALS['tahun_access'],'type'=>'infografis']),
                    'top_nav_class'=>'',
                    'class'=>'',
                    
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
                    'can'=>['is_super']


                ],
                 [
                    'text'=>('TABLE MAP'),
                    'href'=>route('admin.tablemap.index',['tahun'=>$GLOBALS['tahun_access']]),
                    'class'=>'',
                    'icon'=>'fa fa-code',
                    'can'=>['is_super']

                ],

                [
                    'text'=>('DATASET'),
                    'href'=>route('admin.data.index',['tahun'=>$GLOBALS['tahun_access']]),
                    'class'=>'',
                    'icon'=>'fa fa-file',
                    'can'=>['is_super']

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
                    'can'=>['is_super']

                ],
                 
                 [
                    'text'=>('USERS'),
                    'href'=>route('admin.users.index',['tahun'=>$GLOBALS['tahun_access']]),
                    'class'=>'',
                    'icon'=>'fa fa-users',
                    'can'=>['is_super']
                    

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
