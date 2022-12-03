<?php

namespace Database\Seeders;

use App\Models\DepositType;
use Illuminate\Database\Seeder;

class DepositSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DepositType::create(['name' => 'Prepayment']);
        DepositType::create(['name' => 'First Charge']);
        DepositType::create(['name' => 'Second Charge']);
    }
}
