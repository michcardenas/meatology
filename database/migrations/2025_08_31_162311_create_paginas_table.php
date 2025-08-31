<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('paginas', function (Blueprint $table) {
            $table->id();
            $table->string('pagina');          // Nombre/título de la página
            $table->string('slug')->unique();  // Slug único para URL
            $table->timestamps();              // created_at, updated_at
            $table->softDeletes();             // deleted_at (opcional pero recomendado)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paginas');
    }
};
