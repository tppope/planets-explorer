<?php

namespace App\GraphQL\Queries;

use App\Models\Planet;
use Illuminate\Support\Str;

final class SpeciesDistribution
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        return Planet::with('residents')->get(['id', 'name'])
            ->map(function ($planet) {
                $residentsCount = $planet->residents->count();
                $speciesDistribution = $planet->residents
                    ->pluck('species')
                    ->map(fn ($specie) => Str::of($specie)->split('/,\s/'))
                    ->flatten()
                    ->countBy()
                    ->map(fn (int $specieCount, string $specieName) => [
                        'specie' => $specieName,
                        'percentage' => $specieCount / $residentsCount * 100,
                    ])->values()->toArray();

                return [
                    'planet_name' => $planet->name,
                    'species_distribution' => $speciesDistribution,
                ];
            });
    }
}
