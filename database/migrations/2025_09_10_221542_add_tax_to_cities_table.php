<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->decimal('tax', 5, 2)->nullable()->after('country_id');
            // decimal(5,2) permite valores como 999.99
            // nullable() permite valores nulos
            // after('country_id') coloca la columna después de country_id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn('tax');
        });
    }
};