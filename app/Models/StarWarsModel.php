<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class StarWarsModel extends Model
{
    protected $guarded = [];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::saving(function (StarWarsModel $planet) {
            foreach ($planet->getAttributes() as $attribute => $value) {
                $notAllowedValues = collect(['unknown', 'none']);
                if ($notAllowedValues->contains($value)) {
                    $planet->setAttribute($attribute, null);
                }
            }
        });
    }
}
