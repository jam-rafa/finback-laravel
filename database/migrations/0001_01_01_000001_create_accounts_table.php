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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id(); // Cria a coluna 'id' como chave primária auto-incrementável
            $table->string('nome')->unique(); // Cria a coluna 'numero_conta' como STRING e único
            $table->string('numero_conta')->unique(); // Cria a coluna 'numero_conta' como STRING e único
            $table->string('agencia'); // Cria a coluna 'agencia' (STRING)
            $table->decimal('saldo', 15, 2)->default(0.00); // Cria a coluna 'saldo' como DECIMAL com precisão e valor padrão de 0.00
            $table->string('account_type'); // Cria a coluna 'account_type' (STRING) para tipo da conta
            $table->string('status')->default('ativa'); // Cria a coluna 'status' com valor padrão de 'ativa'
            $table->timestamps(); // Cria as colunas 'created_at' e 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};

