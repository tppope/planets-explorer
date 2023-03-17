<?php

namespace App\Providers;

use App\Enums\MoodEnum;
use App\Enums\WeatherEnum;
use GraphQL\Type\Definition\PhpEnumType;
use Illuminate\Support\ServiceProvider;
use Nuwave\Lighthouse\Schema\TypeRegistry;

class GraphQLServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(TypeRegistry $typeRegistry): void
    {
        $typeRegistry->register(new PhpEnumType(MoodEnum::class));
        $typeRegistry->register(new PhpEnumType(WeatherEnum::class));
    }
}
