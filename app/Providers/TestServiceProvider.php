<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        dd('register method run - laravel 11');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        dd('boot method run - laravel 11');
    }
}
