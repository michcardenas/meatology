<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'image',
        'description'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación: Una certificación pertenece a un producto
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}