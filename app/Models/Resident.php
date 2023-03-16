<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resident extends StarWarsModel
{
    public function homeworld(): BelongsTo
    {
        return $this->belongsTo(Planet::class);
    }
}
