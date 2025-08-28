<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Modificar la columna status para incluir todos los valores necesarios
            $table->enum('status', [
                'pending',
                'confirmed',
                'processing', 
                'shipped',
                'delivered',
                'completed',
                'cancelled'
            ])->default('pending')->change();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Revertir a los valores originales si es necesario
            $table->enum('status', [
                'pending',
                'completed',
                'cancelled'
            ])->default('pending')->change();
        });
    }
};