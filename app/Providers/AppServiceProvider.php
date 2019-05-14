<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Peminjaman;

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
         Schema::defaultStringLength(191);
        view()->composer('base.header', function($view)
        {
          $count = Peminjaman::where('status','Belum Dikonfirmasi')->get();
          $count = count($count);
          $view->with('jumlah', $count);
        });
     }
}
