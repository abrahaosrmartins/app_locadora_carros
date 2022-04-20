<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cliente extends Model
{
    use HasFactory;

    /**
     * Creates relationship with Carro`s model
     *
     * @return BelongsToMany
     */
    public function carros()
    {
        return $this->belongsToMany(Carro::class);
    }
}
