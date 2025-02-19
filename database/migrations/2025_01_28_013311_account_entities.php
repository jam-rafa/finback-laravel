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
        Schema::create('account_entities', function (Blueprint $table) {
            $table->id(); // Cria um campo 'id' como chave primária
            $table->foreignId('account_id')->constrained('accounts')->onDelete('cascade');
            $table->foreignId('entities_id')->constrained('entities')->onDelete('cascade');

            $table->timestamps(); // Cria os campos 'created_at' e 'updated_at'


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_entities'); // Remove a tabela caso a migration seja revertida
    }
};
