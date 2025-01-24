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
        Schema::create('account_natures', function (Blueprint $table) {
            $table->id(); // Cria a coluna 'id' como chave primária auto-incrementável
            // Define as chaves estrangeiras para 'account_id' e 'cost_center_id'
            $table->foreignId('account_id')->constrained('accounts')->onDelete('cascade');
            $table->foreignId('nature_id')->constrained('natures')->onDelete('cascade');

            $table->timestamps(); // Cria as colunas 'created_at' e 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_natures');
    }
};
