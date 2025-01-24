<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'username' => 'Rafael Carvalho',
                'password' => Hash::make('12345'), // Criptografa a senha
                'email' => 'rafa.deandrade35@gmail.com',
                'cpf' => '05456055120',
                'cnpj' => null,
                'role_id' => 1, // Certifique-se de que o role_id corresponde a um ID válido na tabela roles
            ],
            [
                'username' => 'yohana',
                'password' => Hash::make('12345'), // Criptografa a senha
                'email' => 'yohanasporto@gmail.com',
                'cpf' => '000000000',
                'cnpj' => null,
                'role_id' => 1, // Certifique-se de que o role_id corresponde a um ID válido na tabela roles
            ],

        ]);
    }
}
