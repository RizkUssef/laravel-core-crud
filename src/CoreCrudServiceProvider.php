<?php

namespace Rizkussef\LaravelCoreCrud;

use Illuminate\Support\ServiceProvider;

class CoreCrudServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/core-crud.php' => config_path('core-crud.php'),
        ], 'config');
    }
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/core-crud.php',
            'core-crud'
        );
        $this->app->bind('CoreCrudService', function ($app) {
            return new CoreCrudService();
        });
    }
}