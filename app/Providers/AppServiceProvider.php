<?php

namespace App\Providers;

use App\Console\Commands\SyncPlanets;
use App\Jobs\Synchronize;
use App\Synchronizer\PlanetsSynchronizer;
use App\Synchronizer\ResidentSynchronizer;
use App\Synchronizer\Synchronizer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->when(SyncPlanets::class)
            ->needs(Synchronizer::class)
            ->give(PlanetsSynchronizer::class);

        $this->app->when(PlanetsSynchronizer::class)
            ->needs(Synchronizer::class)
            ->give(ResidentSynchronizer::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bindMethod([Synchronize::class, 'handle'], function (Synchronize $job, Application $app) {
            $job->handle($app->make(PlanetsSynchronizer::class));
        });
    }
}
