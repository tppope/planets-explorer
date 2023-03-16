<?php

namespace App\Synchronizer;

use App\Models\Planet;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class PlanetsSynchronizer implements Synchronizer
{
    public function __construct(private readonly Synchronizer $residentSynchronizer)
    {
    }

    public function sync($url): void
    {
        $response = Http::get($url);

        if ($response->failed()) {
            return;
        }

        $response->collect('results')->each(function ($planet) {
            Planet::query()->updateOrCreate(
                ['id' => basename($planet['url'])],
                collect($planet)->only([
                    'name',
                    'rotation_period',
                    'orbital_period',
                    'diameter',
                    'climate',
                    'gravity',
                    'terrain',
                    'surface_water',
                    'population'])->all()
            );
            $this->syncResidents(collect($planet['residents']));
        });
    }

    public function syncResidents(Collection $residents)
    {
        $residents->each(function (string $residentUrl) {
            $this->residentSynchronizer->sync($residentUrl);
        });
    }
}
