<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VatOption;
use App\Models\HotelSetting;

class VatOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VatOption::updateOrCreate(["id"=>1, "value"=>24,]);
        VatOption::updateOrCreate(["id"=>2, "value"=>13,]);
        VatOption::updateOrCreate(["id"=>3, "value"=>6,]);
        VatOption::updateOrCreate(["id"=>4, "value"=>17,]);
        VatOption::updateOrCreate(["id"=>5, "value"=>9,]);
        VatOption::updateOrCreate(["id"=>6, "value"=>4,]);
        VatOption::updateOrCreate(["id"=>8, "value"=>0,]);
        
    }
}
