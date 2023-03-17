<?php

namespace App\GraphQL\Validators;

use App\Enums\MoodEnum;
use App\Enums\WeatherEnum;
use Illuminate\Validation\Rules\Enum;
use Nuwave\Lighthouse\Validation\Validator;

final class CreateLogbookInputValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'mood' => [new Enum(MoodEnum::class)],
            'weather' => [new Enum(WeatherEnum::class)],
            'space_location' => ['required', 'max:255'],
            'note' => ['required', 'max:5000'],
        ];
    }
}
