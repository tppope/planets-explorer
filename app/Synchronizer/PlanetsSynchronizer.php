<?php

namespace App\Synchronizer;

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
            $this->syncResidents(collect($planet['residents']));
            return false;
        });
    }

    public function syncResidents(Collection $residents)
    {
        $residents->each(function (string $residentUrl) {
            $this->residentSynchronizer->sync($residentUrl);
            return false;
        });
    }
}
