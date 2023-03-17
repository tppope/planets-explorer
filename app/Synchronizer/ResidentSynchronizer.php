<?php

namespace App\Synchronizer;

use App\Models\Resident;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class ResidentSynchronizer implements Synchronizer
{
    public function sync($url): void
    {
        $response = Http::get($url);

        if ($response->failed()) {
            return;
        }

        $resident = $response->collect();

        $species = $this->getSpecies(collect($resident['species']));

        Resident::query()->updateOrCreate(
            ['id' => basename($resident['url'])],
            [
                ...$resident->only([
                    'name',
                    'height',
                    'mass',
                    'hair_color',
                    'skin_color',
                    'eye_color',
                    'birth_year',
                    'gender'])->all(),
                'species' => $species ?: null,
                'homeworld_id' => basename($resident['homeworld']),
            ]
        );
    }

    private function getSpecies(Collection $urls): string
    {
        return $urls->map(function ($url) {
            $response = Http::get($url);

            if ($response->failed()) {
                return '';
            }

            return $response['name'];
        })->implode(', ');
    }
}
