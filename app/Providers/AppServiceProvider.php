<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

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
    public function boot()
    {
        // Daftarkan middleware 'role' yang akan digunakan dalam rute
        Route::middleware('role', \App\Http\Middleware\CheckRole::class);
    }
}
