<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // memodifikasi komponen Blade secara global,
        // melakukannya di sini, misalnya:
        // use Illuminate\Support\Facades\Blade;
        // Blade::component('app.layout', App\View\Components\AppLayout::class);
    }
}