<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Carro extends Model
{
    use HasFactory;

    /**
     * Creates relationship with Modelo`s model
     *
     * @return BelongsTo
     */
    public function modelo()
    {
        return $this->belongsTo(Modelo::class);
    }

    /**
     * Creates relationship with Cliente`s model
     *
     * @return BelongsToMany
     */
    public function clientes()
    {
        return $this->belongsToMany(Cliente::class);
    }
}
