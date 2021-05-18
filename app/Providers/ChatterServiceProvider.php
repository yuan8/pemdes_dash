<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ChatterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../public/assets' => public_path('vendor/devdojo/chatter/assets'),
        ], 'chatter_assets');

        $this->publishes([
            __DIR__.'/../config/chatter.php' => config_path('chatter.php'),
        ], 'chatter_config');

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations'),
        ], 'chatter_migrations');

        $this->publishes([
            __DIR__.'/../database/seeds/' => database_path('seeds'),
        ], 'chatter_seeds');
        // include the routes file
        if(!isset($GLOBALS['tahun_access'])){
            $GLOBALS['tahun_access']=date('Y');
        }
        include (app_path('../routes/ForumRoute/web.php'));

        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->loadViewsFrom(__DIR__.'/Views', 'chatter');
    }
}