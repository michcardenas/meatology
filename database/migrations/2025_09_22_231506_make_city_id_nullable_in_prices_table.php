<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('prices', function (Blueprint $table) {
            // Quita FK actual (nombre usual; si difiere, ajusta)
            $table->dropForeign(['city_id']);
        });

        Schema::table('prices', function (Blueprint $table) {
            // Vuelve city_id nullable
            $table->unsignedBigInteger('city_id')->nullable()->change();
        });

        Schema::table('prices', function (Blueprint $table) {
            // Re-crea la FK permitiendo NULL y con borrado a NULL
            $table->foreign('city_id')
                  ->references('id')->on('cities')
                  ->nullOnDelete(); // ON DELETE SET NULL
        });
    }

    public function down(): void
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
        });

        Schema::table('prices', function (Blueprint $table) {
            $table->unsignedBigInteger('city_id')->nullable(false)->change();
        });

        Schema::table('prices', function (Blueprint $table) {
            $table->foreign('city_id')
                  ->references('id')->on('cities')
                  ->restrictOnDelete();
        });
    }
};
