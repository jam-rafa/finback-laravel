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
                'nome' => 'Bruno',
                'numero_conta' => '12345-6',
                'agencia' => '0001',
                'saldo' => 5000.00,
                'account_type' => 'corrente',
                'status' => 'ativa',
                'account_group' => 'Bruno',
                'bank' => 'Nubank',
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
                'account_group' => 'Rafael C',
                'bank' => 'Banco do Brasil',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Rafael empresarial',
                'numero_conta' => '0417553315',
                'agencia' => '0001',
                'saldo' => 12000.00,
                'account_type' => 'corrente',
                'status' => 'ativa',
                'account_group' => 'Rafael C',
                'bank' => 'Inter',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
