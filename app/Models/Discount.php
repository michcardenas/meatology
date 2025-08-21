<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    // Nombre real de la tabla según tu migración
    protected $table = 'descuentos';

    protected $fillable = [
        'id_producto',
        'id_categoria',
        'nombre',
        'descripcion',
        'porcentaje',
        'numero_descuentos',
        'codigo',
    ];

    protected $casts = [
        'porcentaje'   => 'decimal:2',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
        'numero_descuentos' => 'integer',
    ];

    /* ============================
     | Relaciones
     ============================ */
    public function producto()
    {
        return $this->belongsTo(\App\Models\Product::class, 'id_producto');
    }

    public function categoria()
    {
        return $this->belongsTo(\App\Models\Category::class, 'id_categoria');
    }

    /* ============================
     | Scopes útiles
     ============================ */

    // Buscar por código (insensible a may/min si tu collation lo permite)
    public function scopeCodigo($query, string $code)
    {
        return $query->where('codigo', $code);
    }

    // Filtrar globales (sin producto ni categoría)
    public function scopeGlobal($query)
    {
        return $query->whereNull('id_producto')->whereNull('id_categoria');
    }

    // Por producto específico
    public function scopeParaProducto($query, int $productId)
    {
        return $query->where('id_producto', $productId);
    }

    // Por categoría específica
    public function scopeParaCategoria($query, int $categoryId)
    {
        return $query->where('id_categoria', $categoryId);
    }

    /* ============================
     | Helpers de dominio
     ============================ */

    // ¿Es cupón global?
    public function esGlobal(): bool
    {
        return is_null($this->id_producto) && is_null($this->id_categoria);
    }

    // ¿Aplica a una categoría?
    public function esPorCategoria(): bool
    {
        return !is_null($this->id_categoria) && is_null($this->id_producto);
    }

    // ¿Aplica a un producto?
    public function esPorProducto(): bool
    {
        return !is_null($this->id_producto);
    }

    /**
     * ¿Aplica este descuento a un producto dado?
     * - Global: aplica a todos
     * - Por categoría: coincide con category_id
     * - Por producto: coincide con id_producto
     */
    public function aplicaAProducto(\App\Models\Product $product): bool
    {
        if ($this->esGlobal()) return true;
        if ($this->esPorProducto()) return (int)$this->id_producto === (int)$product->id;
        if ($this->esPorCategoria()) return (int)$this->id_categoria === (int)$product->category_id;
        return false;
    }

    /**
     * ¿Quedan usos disponibles?
     * Si numero_descuentos es null => ilimitado (controla esto según tu negocio).
     * Si pasas $usosActuales (conteo en otra tabla), valida contra el límite.
     */
    public function puedeUsarse(?int $usosActuales = null): bool
    {
        if (is_null($this->numero_descuentos)) return true;
        if (is_null($usosActuales)) return true; // se valida en el servicio con el conteo real
        return $usosActuales < (int)$this->numero_descuentos;
    }

    /**
     * Calcula monto de descuento para un precio base (en dinero).
     * Retorna el valor a restar, NO el precio final.
     */
    public function calcularMonto(float $precioBase): float
    {
        $pct = max(0, min(100, (float)$this->porcentaje));
        return round($precioBase * ($pct / 100), 2);
    }
}
