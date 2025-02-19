<?php

// Migration: database/migrations/xxxx_xx_xx_create_movements_events_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('movements_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movement_id')->constrained('movements')->onDelete('cascade');
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->float('ent_value'); // Valor associado ao movimento/evento
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movements_events');
    }
};
