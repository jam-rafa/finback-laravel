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
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // Cria a coluna 'id' como chave primária auto-incrementável
            $table->string('status'); // Cria a coluna 'status' (STRING)
            $table->integer('installment'); // Cria a coluna 'installment' (INTEGER)
            $table->float('installment_value'); // Cria a coluna 'installment_value' (FLOAT)
            $table->date('expiration_date'); // Cria a coluna 'expiration_date' (DATE)
            
            // Define a chave estrangeira para 'movements_id'
            $table->foreignId('movements_id')->constrained('movements')->onDelete('cascade');
            
            $table->timestamps(); // Cria as colunas 'created_at' e 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
