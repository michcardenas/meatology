<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Pagina extends Model
{
    use SoftDeletes;

    // Por convención, el modelo Pagina usa la tabla 'paginas', no hace falta $table

    protected $fillable = [
        'pagina',
        'slug',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Genera/normaliza el slug automáticamente si no viene en el fill
     * o viene vacío. También lo regenera si cambia 'pagina' y no se
     * envía un slug manualmente.
     */
    protected static function booted(): void
    {
        static::creating(function (Pagina $model) {
            if (blank($model->slug) && filled($model->pagina)) {
                $model->slug = Str::slug($model->pagina);
            }
        });

        static::updating(function (Pagina $model) {
            // Si no te pasan slug al actualizar pero sí cambiaron 'pagina', autogenera
            if ($model->isDirty('pagina') && blank($model->slug)) {
                $model->slug = Str::slug($model->pagina);
            }
        });
    }

    public function seo()
{
    return $this->hasOne(\App\Models\Seo::class);
}
}
