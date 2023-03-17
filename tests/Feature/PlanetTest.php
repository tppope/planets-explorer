<?php

namespace Tests\Feature;

use App\Models\Planet;
use App\Models\Resident;
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
            'percentage' => 2 / 3 * 100,
        ]);
    }

    public function test_get_species_distribution(): void
    {
        $planet1 = Planet::query()->create([
            'name' => 'Planet 1',
        ]);

        Resident::query()->create([
            'name' => 'Resident 1',
            'species' => 'Specie 1',
            'homeworld_id' => $planet1->id,
        ]);

        Resident::query()->create([
            'name' => 'Resident 2',
            'species' => 'Specie 2',
            'homeworld_id' => $planet1->id,
        ]);

        $planet2 = Planet::query()->create([
            'name' => 'Planet 2',
        ]);

        Resident::query()->create([
            'name' => 'Resident 3',
            'species' => 'Specie 1',
            'homeworld_id' => $planet2->id,
        ]);

        $this->graphQL(/** @lang GraphQL */ '
        {
            speciesDistribution {
                planet_name
                species_distribution {
                    specie
                    percentage
                }
            }
        }
        ')->assertJsonFragment([
            'planet_name' => 'Planet 1',
            'species_distribution' => [
                [
                    'specie' => 'Specie 1',
                    'percentage' => 50.0,
                ],
                [
                    'specie' => 'Specie 2',
                    'percentage' => 50.0,
                ],
            ],
        ]);
    }
}
