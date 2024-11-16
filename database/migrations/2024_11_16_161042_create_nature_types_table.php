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
        Schema::create('nature_types', function (Blueprint $table) {
            $table->id(); // Cria a coluna 'id' como chave primária auto-incrementável
            $table->string('name'); // Cria a coluna 'name' (STRING)
            
            // Define a chave estrangeira 'nature_id' referenciando 'id' na tabela 'natures'
            $table->foreignId('nature_id')->constrained('natures')->onDelete('cascade');
            
            $table->timestamps(); // Cria as colunas 'created_at' e 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nature_types');
    }
};
