<?php

namespace Tests\Feature;

use App\Models\Planet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanetTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_largest_planets(): void
    {
        Planet::query()->create([
            'name' => 'Planet 1',
            'diameter' => 3,
        ]);

        Planet::query()->create([
            'name' => 'Planet 2',
            'diameter' => 1,
        ]);

        Planet::query()->create([
            'name' => 'Planet 3',
            'diameter' => 2,
        ]);

        $names = $this->graphQL(/** @lang GraphQL */ '
        {
            largestPlanets(limit: 2) {
                name
            }
        }
        ')->json('data.*.*.name');

        $this->assertSame([
            'Planet 1',
            'Planet 3',
        ], $names);
    }

    public function test_get_terrain_distribution(): void
    {
        Planet::query()->create([
            'terrain' => 'mountains, volcanoes, rocky deserts',
        ]);

        Planet::query()->create([
            'terrain' => 'rocky deserts',
        ]);

        Planet::query()->create([
            'terrain' => null,
        ]);

        $this->graphQL(/** @lang GraphQL */ '
        {
            terrainDistribution {
                name
                percentage
            }
        }
        ')->assertJsonFragment([
            'name' => 'rocky deserts',
            'percentage' => 2 / 3,
        ]);
    }
}
