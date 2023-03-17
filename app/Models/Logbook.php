<?php

namespace App\Models;

use App\Enums\MoodEnum;
use App\Enums\WeatherEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Logbook extends Model
{
    protected $casts = [
        'mood' => MoodEnum::class,
        'weather' => WeatherEnum::class,
    ];

    protected function note(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Crypt::decryptString($value),
            set: fn (string $value) => Crypt::encryptString($value),
        );
    }
}
