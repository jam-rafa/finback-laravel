<?php

namespace Database\Seeders;

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
        DB::table('user')->insert([
            [
                'username' => 'Rafael Carvalho',
                'password' => Hash::make('12345'), // Criptografa a senha
                'email' => 'rafa.deandrade35@gmail.com',
                'cpf' => '05456055120',
                'cnpj' => null,
                'role_id' => 1, // Certifique-se de que o role_id corresponde a um ID válido na tabela roles
            ],

        ]);
    }
}
