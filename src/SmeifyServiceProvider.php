<?php

namespace AdewaleCharles\Smeify;

use Illuminate\Support\ServiceProvider;

class SmeifyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        /**
         * Bootstrap any package services.
         *
         * @return void
         */
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->publishes([
            __DIR__ . '/../config/smeify.php' => config_path('smeify.php'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/smeify.php',
            'smeify'
        );
    }
}
