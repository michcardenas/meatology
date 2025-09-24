<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrate data from tax column to shipping column
        DB::table('cities')->whereNotNull('tax')->update([
            'shipping' => DB::raw('tax')
        ]);

        // Drop the tax column
        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn('tax');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate tax column
        Schema::table('cities', function (Blueprint $table) {
            $table->decimal('tax', 5, 2)->nullable();
        });

        // Migrate data back from shipping to tax
        DB::table('cities')->whereNotNull('shipping')->update([
            'tax' => DB::raw('shipping')
        ]);
    }
};
