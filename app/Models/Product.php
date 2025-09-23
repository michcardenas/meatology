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
        'avg_weight',
        'stock',
        'image',
        'category_id',
        'interest',
        'pais',
        'descuento',
        'certification', // Nueva columna para certificaciones
    ];

    // Cast para manejar JSON automáticamente
    protected $casts = [
        'certification' => 'array',
    ];

public function category()
{
    return $this->belongsTo(\App\Models\Category::class);
}

public function images()
{
    return $this->hasMany(ProductImage::class);
}
public function prices()
{
    return $this->hasMany(Price::class);
}
 public function certifications()
    {
        return $this->hasMany(Certification::class);
    }

}
