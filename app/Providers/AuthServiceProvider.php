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

        Gate::define('is_super', function ($user) {
        
        return $user->role==1;

        });


        //
    }
}
