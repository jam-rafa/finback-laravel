<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insere os tipos de pagamento na tabela payment_types
        DB::table('payment_types')->insert([
            ['name' => 'Dinheiro', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cartão de Crédito', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cartão de Débito', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pix', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Boleto Bancário', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Transferência Bancária', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Aplicação Poupança', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
