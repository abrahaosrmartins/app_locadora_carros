<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Modelo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'marca_id',
        'imagem',
        'numero_portas',
        'lugares',
        'air_bag',
        'abs'
    ];

    /**
     * Creates relationship with Marca`s model
     *
     * @return BelongsTo
     */
    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }


    /**
     * Creates relationship with Carro`s model
     *
     * @return HasMany
     */
    public function carros()
    {
        return $this->hasMany(Carro::class);
    }
}
