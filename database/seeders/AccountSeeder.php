<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Account::insert([
            [
                'nome' => 'Arena 61',
                'numero_conta' => '12345-6',
                'agencia' => '0001',
                'saldo' => 5000.00,
                'account_type' => 'corrente',
                'status' => 'ativa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'BB Rafael',
                'numero_conta' => '67890-1',
                'agencia' => '0002',
                'saldo' => 12000.00,
                'account_type' => 'corrente',
                'status' => 'ativa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
