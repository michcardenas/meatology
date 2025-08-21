<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('descuentos', function (Blueprint $table) {
            $table->id();

            // Alcance del descuento (global / por producto / por categoría)
            // Global = ambos null
            $table->foreignId('id_producto')
                ->nullable()
                ->constrained('products')
                ->nullOnDelete();

            $table->foreignId('id_categoria')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete();

            // Datos del descuento
            $table->string('nombre');
            $table->text('descripcion')->nullable();

            // Porcentaje (0.00 a 100.00)
            $table->decimal('porcentaje', 5, 2); 

            // Límite de usos totales para el mismo código
            $table->unsignedInteger('numero_descuentos')->nullable();

            // Código que ingresa el cliente
            $table->string('codigo')->unique();

            $table->timestamps();

            // Índices útiles para búsquedas
            $table->index(['id_producto']);
            $table->index(['id_categoria']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('descuentos');
    }
};
