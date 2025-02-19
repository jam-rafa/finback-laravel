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
        Schema::create('entities', function (Blueprint $table) {
            $table->id(); // Cria um campo 'id' como chave primária
            $table->string('name'); // Campo 'nome' como string
            $table->string('cnpj')->nullable(); // Campo 'cnpj' como string e opcional
            $table->string('cpf')->nullable(); // Campo 'cpf' como string e opcional
            $table->string('account')->nullable(); // Campo 'conta' como string
            $table->string('agency')->nullable(); // Campo 'agencia' como string
            $table->timestamps(); // Cria os campos 'created_at' e 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entities'); // Remove a tabela caso a migration seja revertida
    }
};
