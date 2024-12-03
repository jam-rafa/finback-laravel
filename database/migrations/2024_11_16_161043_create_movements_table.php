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
        Schema::create('movements', function (Blueprint $table) {
            $table->id(); // Cria a coluna 'id' como chave primária auto-incrementável
            $table->string('name'); // Cria a coluna 'name' (STRING)
            $table->date('date'); // Cria a coluna 'date' (DATE)
            $table->string('cost_type'); // Cria a coluna 'cost_type' (STRING)
            $table->float('value'); // Cria a coluna 'value' (FLOAT)
            $table->float('installments'); // Cria a coluna 'value' (FLOAT)
            $table->string('moviment_type');
            // Define as chaves estrangeiras
            $table->foreignId('account_id')->constrained('accounts')->onDelete('cascade');
            $table->foreignId('nature_id')->constrained('natures')->onDelete('cascade');
            $table->foreignId('payment_type_id')->constrained('payment_types')->onDelete('cascade');
            $table->foreignId('cost_center_id')->constrained('cost_centers')->onDelete('cascade');
            
            $table->timestamps(); // Cria as colunas 'created_at' e 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movements');
    }
};
