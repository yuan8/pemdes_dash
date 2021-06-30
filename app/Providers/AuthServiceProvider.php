<?php

namespace App\Providers;
use App\Policies\UserPlicy;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // User::class => UserPlicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('is_active', function ($user) {
            return $user->is_active;
        });

        Gate::define('all_daerah_data',function($user){
            return $user->role==3 OR $user->role<=2;
        });
        Gate::define('is_super', function ($user) {
            return $user->role==1;
        });

        Gate::define('is_wali_daerah_kab', function ($user) {
            return (($user->role==4 and $user->walidata and ($user->main_daerah!=true) and strlen($user->kode_daerah)==4)) OR ($user->role<=2);
        });
        
        Gate::define('is_admin', function ($user) {
            return $user->role<=2;
        });

        Gate::define('is_regional', function ($user) {
            return $user->role<=3;
        });

         Gate::define('is_only_regional', function ($user) {
            return $user->role==3;
        });

        Gate::define('is_daerah', function ($user) {
            return $user->role<=4;
        });

        Gate::define('is_daerah_provinsi', function ($user) {
            return strlen($user->kode_daerah)==2;
        });

        Gate::define('is_daerah_kabkota', function ($user) {
            return strlen($user->kode_daerah)==4;
        });

        Gate::define('is_daerah_kabkota_n_admin', function ($user) {
            return strlen($user->kode_daerah)==4 OR $user->can('is_admin');
        });

        Gate::define('is_daerah_kecamatan', function ($user) {
            return strlen($user->kode_daerah)==6;
        });

        Gate::define('is_daerah_desa', function ($user) {
            return strlen($user->kode_daerah)==10;
        });

        Gate::define('is_only_daerah', function ($user) {
            return $user->role==4;
        });

         Gate::define('is_daerah_admin', function ($user) {
            return (($user->role==4 and  (!empty($user->kode_daerah)) and $user->main_daerah==true) or ($user->role<=2));
        });

         Gate::define('is_only_daerah_verifikasi', function ($user) {
            return $user->role==4 and strlen($user->kode_daerah)>4;
        });

         Gate::define('is_only_daerah_validasi', function ($user) {
            return $user->role==4 and strlen($user->kode_daerah)==4;
        });

        Gate::define('can_validasi', function ($user) {
            return $user->role<=2;
        });

        Gate::define('can_verifikasi', function ($user) {
            return $user->role==4 and $user->walidata and strlen($user->kode_daerah)>0;
        });

        Gate::define('can_edit_data', function ($user) {
            return $user->role==4 and strlen($user->kode_daerah)>0;
        });


        Gate::define('can_create_user_child', function ($user) {
            return $user->role==4 and $user->main_daerah and strlen($user->kode_daerah)>0;
        });




    }
}
