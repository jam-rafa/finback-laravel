<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1Accounts = [1, 2]; // As contas específicas que o user 1 terá
        foreach ($user1Accounts as $accountId) {
            DB::table('account_user')->insert([
                'user_id' => 1,
                'account_id' => $accountId,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
