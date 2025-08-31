<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seo', function (Blueprint $table) {
            $table->id();

            // Relación 1:1 con paginas
            $table->foreignId('pagina_id')
                  ->constrained('paginas')
                  ->cascadeOnDelete();
            $table->unique('pagina_id'); // una fila de SEO por página

            // META básicos
            $table->string('meta_title', 70)->nullable();        // recomendado <= 60-70
            $table->string('meta_description', 160)->nullable(); // recomendado <= 155-160
            $table->string('meta_keywords')->nullable();         // opcional (cada vez menos usado)
            $table->string('canonical_url')->nullable();
            $table->string('robots', 50)->default('index,follow'); // ej: "noindex,nofollow"

            // Open Graph
            $table->string('og_title', 95)->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();              // URL o path
            $table->string('og_type', 50)->default('website');
            $table->string('og_locale', 10)->default('en_US');

            // Twitter Cards
            $table->string('twitter_card', 20)->default('summary_large_image');
            $table->string('twitter_title', 70)->nullable();
            $table->string('twitter_description', 200)->nullable();
            $table->string('twitter_image')->nullable();

            // Estructurados
            $table->json('json_ld')->nullable();                 // schema.org en JSON-LD

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo');
    }
};
