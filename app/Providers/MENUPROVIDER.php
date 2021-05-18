<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth;
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

        $tahun=isset($GLOBALS['tahun_access'])?$GLOBALS['tahun_access']:date('Y');
        $GLOBALS['tahun_access']=$tahun;
        
        $menu=[
            'side_left'=>[
               
            ],
            'top'=>[
                 [
                    'text'=>('Data'),
                    'href'=>route('query.data',['tahun'=>$tahun]),
                    'top_nav_class'=>'',
                    'class'=>'',
                    'icon'=>'fa fa-file',

                ],

                 [
                    'text'=>('Index Desa'),
                    'href'=>route('organisasi',['tahun'=>$tahun]),
                    'class'=>'',
                    'top_nav_class'=>'',

                    'icon'=>'fa fa-tag',

                ],
                 [
                    'text'=>('Instansi'),
                    'href'=>route('organisasi',['tahun'=>$tahun]),
                    'top_nav_class'=>'',
                    'class'=>'',

                    'icon'=>'fa fa-users',

                ],
                 [
                    'text'=>('Tema'),
                    'href'=>route('tema',['tahun'=>$tahun]),
                    'top_nav_class'=>'',
                    'class'=>'',

                    'icon'=>'fa fa-hashtag',

                ],
                //  [
                //     'text'=>('Publikasi'),
                //     'href'=>route('query.data.delivery',['tahun'=>$tahun,'type'=>'publikasi']),
                //     'top_nav_class'=>'',
                //     'class'=>'',

                //     'icon'=>'fa fa-eye',

                // ],
                 [
                    'text'=>('Infografis'),
                    'href'=>route('data.type',['tahun'=>$tahun,'type'=>'INFOGRAFIS']),
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
        $tahun=isset($GLOBALS['tahun_access'])?$GLOBALS['tahun_access']:date('Y');
        $GLOBALS['tahun_access']=$tahun;
        $menu=[
            'top'=>[],
            'side_left'=>[


                'Tahun Data '.$GLOBALS['tahun_access'],
                 [
                    'text'=>('USER DASHBOARD'),
                    'href'=>route('admin.session.index',['tahun'=>$tahun]),
                    'class'=>'',
                    'icon'=>'fa fa-circle',
                    'can'=>['is_super']


                ],
                 [
                    'text'=>('KATEGORI'),
                    'href'=>route('admin.kategori.index',['tahun'=>$tahun]),
                    'class'=>'',
                    'icon'=>'fa fa-circle',
                    'can'=>['is_super']


                ],
                
                 [
                    'text'=>('TABLE MAP'),
                    'href'=>route('admin.tablemap.index',['tahun'=>$tahun]),
                    'class'=>'',
                    'icon'=>'fa fa-code',
                    'can'=>['is_super']

                ],

               
                [
                    'text'=>('VALIDASI DATA'),
                    'href'=>route('admin.validasi.index',['tahun'=>$tahun]),
                    'class'=>'',
                    'icon'=>'fa fa-check',
                ],
               
                [
                    'text'=>('DATASET'),
                    'href'=>route('admin.dataview.index',['tahun'=>$tahun]),
                    'class'=>'',
                    'icon'=>'fa fa-file',
                    'can'=>['is_super']

                ],
                 [
                    'text'=>('DATASET MANUAL'),
                    'href'=>route('admin.data.index',['tahun'=>$tahun]),
                    'class'=>'',
                    'icon'=>'fa fa-file',
                    'can'=>['is_daerah']

                ],
                [
                    'text'=>('MANAJEMEN INSTANSI'),
                    'href'=>route('admin.instansi.index',['tahun'=>$tahun]),
                    'class'=>'',
                    'icon'=>'fa fa-user',
                    'can'=>['is_super']
                    

                ],
                 [
                    'text'=>('MANAJEMEN REGIONAL'),
                    'href'=>route('admin.region.index',['tahun'=>$tahun]),
                    'class'=>'',
                    'icon'=>'fa fa-map',
                    'can'=>['is_super']
                    

                ],
                 
                 [
                    'text'=>('MANAJEMEN USER'),
                    'href'=>route('admin.users.index',['tahun'=>$tahun]),
                    'class'=>'',
                    'icon'=>'fa fa-users',
                    'can'=>['is_super']
                    

                ],

                //  [
                //     'text'=>('SETTING'),
                //     'class'=>'',
                //     'submenu_class'=>'',
                //     'can'=>['is_super'],
                //     'href'=>'#',
                //     'submenu'=>[
                //         [
                //             'text'=>'TENTANG',
                //             'href'=>route('admin.set.index',['tahun'=>$tahun]),
                //             'class'=>'',
                //             'submenu_class'=>'',
                //             'icon'=>'fa fa-users',
                //             'can'=>['is_super']
                //         ]
                //     ]
                    

                // ],
                 
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
