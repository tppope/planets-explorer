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
        static::saving(function (StarWarsModel $starWarsModel) {
            foreach ($starWarsModel->getAttributes() as $attribute => $value) {
                $notAllowedValues = collect(['unknown', 'none']);
                if ($notAllowedValues->contains($value)) {
                    $starWarsModel->setAttribute($attribute, null);
                }
            }
        });

        static::retrieved(function (StarWarsModel $starWarsModel) {
            foreach ($starWarsModel->getAttributes() as $attribute => $value) {
                if (is_null($value)) {
                    $starWarsModel->setAttribute($attribute, '- - -');
                }
            }
        });
    }
}
