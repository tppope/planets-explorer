<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Planet extends StarWarsModel
{
    public function residents(): HasMany
    {
        return $this->hasMany(Resident::class);
    }
}
