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
        Schema::create('users', function (Blueprint $table) {
            // Definindo a coluna ID como AUTO_INCREMENT e chave primária
            $table->id(); // Isso cria a coluna 'id' como chave primária auto-incrementável

            // Definindo as colunas do usuário
            $table->string('username');  // Cria a coluna 'username' (STRING)
            $table->string('password');  // Cria a coluna 'password' (STRING)
            $table->string('email');     // Cria a coluna 'email' (STRING)
            $table->string('cpf')->nullable(); // Cria a coluna 'cpf' (STRING), nullable por padrão
            $table->string('cnpj')->nullable(); // Cria a coluna 'cnpj' (STRING), nullable por padrão
            $table->string('role_id')->constrained('roles')->onDelete('cascade');
            // Timestamps (created_at e updated_at)
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove a tabela 'users' se necessário
        Schema::dropIfExists('users');
    }
};
