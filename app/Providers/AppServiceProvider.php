<?php

namespace App\Providers;

use Fruitcake\TelescopeToolbar\ToolbarServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment("local")) {
            $this->app->register(
                \Laravel\Telescope\TelescopeServiceProvider::class,
            );
            $this->app->register(
                \App\Providers\TelescopeServiceProvider::class,
            );
            $this->app->register(
                \Fruitcake\TelescopeToolbar\ToolbarServiceProvider::class,
            );
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
