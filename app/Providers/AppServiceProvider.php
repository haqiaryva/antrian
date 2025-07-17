<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Staff;
use Illuminate\Support\Facades\View;

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
        // Untuk Mendapat Semua Data dari Tabel Staff ke Tampilan View
        View::composer('*', function ($view) {
            $view->with('staffs', Staff::all());
        });
    }
}
