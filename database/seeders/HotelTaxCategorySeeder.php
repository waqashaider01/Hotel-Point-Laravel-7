<?php

namespace Database\Seeders;

use App\Models\HotelTaxCategory;
use Illuminate\Database\Seeder;

class HotelTaxCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HotelTaxCategory::updateOrCreate(["category"=>6, "tax"=>0.50, "description"=>"1-2 star Hotels"]);
        HotelTaxCategory::updateOrCreate(["category"=>7, "tax"=>1.50, "description"=>"3 star Hotels"]);
        HotelTaxCategory::updateOrCreate(["category"=>8, "tax"=>3.00, "description"=>"4 star Hotels"]);
        HotelTaxCategory::updateOrCreate(["category"=>9, "tax"=>4.00, "description"=>"5 star Hotels"]);
        HotelTaxCategory::updateOrCreate(["category"=>10, "tax"=>0.50, "description"=>"Apartments- rooms"]);
        
    }
}
