<?php

namespace App\GraphQL\Queries;

use App\Models\Planet;
use Illuminate\Support\Str;

final class TerrainDistribution
{
    /**
     * @param  null  $_
     * @param array{} $args
     */
    public function __invoke($_, array $args)
    {
        $planetsTerrain = Planet::all('terrain')->pluck('terrain');
        $planetCount = $planetsTerrain->count();

        return $planetsTerrain
            ->map(fn ($terrain) => Str::of($terrain)->split('/,\s/'))
            ->flatten()
            ->countBy()
            ->map(fn (int $terrainCount, string $terrainName) => [
                'name' => $terrainName,
                'percentage' => $terrainCount / $planetCount * 100,
            ])->values()->toArray();
    }
}
