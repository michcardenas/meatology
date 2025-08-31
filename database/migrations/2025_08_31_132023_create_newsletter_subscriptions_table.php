<?php

// database/migrations/XXXX_XX_XX_XXXXXX_create_newsletter_subscriptions_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('newsletter_subscriptions', function (Blueprint $table) {
            $table->id();

            // Relación opcional al usuario (si está logueado o si luego se vincula)
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Email único para evitar duplicados (un email = una suscripción)
            $table->string('email')->unique();

            // Estados básicos
            $table->boolean('confirmed')->default(false);      // doble opt-in (si lo usas)
            $table->timestamp('subscribed_at')->nullable();     // cuándo se suscribió
            $table->timestamp('unsubscribed_at')->nullable();   // cuándo se dio de baja

            // Tokens para confirmar/baja
            $table->string('confirm_token', 64)->nullable()->unique();
            $table->string('unsubscribe_token', 64)->nullable()->unique();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newsletter_subscriptions');
    }
};
