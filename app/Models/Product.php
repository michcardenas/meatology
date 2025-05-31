<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /* 1️⃣  habilita asignación masiva  */
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
    ];

    // Si prefieres permitir TODO:
    // protected $guarded = [];   // <— alternativa
}
