<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale('id'); // 'id' adalah kode bahasa untuk Bahasa Indonesia
    }
}
