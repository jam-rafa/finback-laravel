<?php

namespace Database\Seeders;

use App\Models\CostCenter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CostCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = [
            ['name' => 'Moradia'],
            ['name' => 'Transporte'],
            ['name' => 'Alimentação'],
            ['name' => 'Saúde'],
            ['name' => 'Educação'],
            ['name' => 'Lazer'],
            ['name' => 'Cuidados Pessoais'],
            ['name' => 'Investimentos'],
            ['name' => 'Impostos'],
            ['name' => 'Dívidas'],
            ['name' => 'Doações'],
        ];

        CostCenter::insert($categories);
    }
}
