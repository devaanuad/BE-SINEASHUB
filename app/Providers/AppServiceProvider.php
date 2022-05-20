<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        \App\Models\Film::observe(\App\Observers\FilmObserver::class);
        \App\Models\LikedFilm::observe(\App\Observers\LikedFilmObserver::class);
        \App\Models\Transaction::observe(\App\Observers\TransactionObserver::class);
    }
}
