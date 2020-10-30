<?php

namespace Bendt\Instagram;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class InstagramServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        Schema::defaultStringLength(191);

        $this->publishes([
            __DIR__.'/config/bendt-instagram.php' => config_path('bendt-instagram.php'),
        ], 'config');
        
        //Load Migrations
        $this->loadMigrationsFrom(__DIR__ . '/Database/migrations');

        //Load routes
        require __DIR__ . '/routes/tag.php';
        require __DIR__ . '/helper.php';
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
}
