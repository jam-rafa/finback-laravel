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
        Schema::create('users_accounts', function (Blueprint $table) {
            $table->id(); // Cria a coluna 'id' como chave primária auto-incrementável

            // Define a chave estrangeira 'user_id' referenciando 'id' na tabela 'users'
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Define a chave estrangeira 'account_id' referenciando 'id' na tabela 'accounts'
            $table->foreignId('account_id')->constrained('accounts')->onDelete('cascade');

            $table->timestamps(); // Cria as colunas 'created_at' e 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_accounts');
    }
};
