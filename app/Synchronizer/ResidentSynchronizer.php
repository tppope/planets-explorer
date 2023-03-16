<?php

namespace App\Synchronizer;

use App\Models\Resident;
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
                'homeworld_id' => basename($resident['homeworld']),
            ]
        );
    }
}
