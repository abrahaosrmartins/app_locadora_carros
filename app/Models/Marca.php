<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Marca extends Model
{
    use HasFactory;

    /**
     * Creates relationship with Modelo`s model
     *
     * @return HasMany
     */
    public function modelos()
    {
        return $this->hasMany(Modelo::class);
    }
}
