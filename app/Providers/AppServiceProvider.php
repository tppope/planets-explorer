<?php

namespace App\Providers;

use App\Synchronizer\PlanetsSynchronizer;
use App\Synchronizer\Synchronizer;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Synchronizer::class, PlanetsSynchronizer::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
