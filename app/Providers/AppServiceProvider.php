<?php

namespace App\Providers;
// app/Providers/AppServiceProvider.php
use Carbon\Carbon;

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

    public function boot()
    {
        view()->composer('*', function ($view) {
            $tahunSekarang = Carbon::now()->year;
            $tahunRange = range(2013, $tahunSekarang + 3);

            $view->with(compact('tahunRange', 'tahunSekarang'));
        });
    }
}
