<?php

namespace Database\Seeders;

use App\Models\ExtraCharge;
use App\Models\ExtraChargesCategory;
use App\Models\ExtraChargesType;
use App\Models\HotelSetting;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $hotel = HotelSetting::first();

        ExtraChargesCategory::create([
            'hotel_settings_id' => $hotel->id,
            'name' => 'Room Service'
        ]);
        ExtraChargesCategory::create([
            'hotel_settings_id' => $hotel->id,
            'name' => 'Restaurant'
        ]);
        ExtraChargesCategory::create([
            'hotel_settings_id' => $hotel->id,
            'name' => 'Bar'
        ]);

        ExtraChargesType::create([
            'hotel_settings_id' => $hotel->id,
            'name' => 'Food'
        ]);
        ExtraChargesType::create([
            'hotel_settings_id' => $hotel->id,
            'name' => 'Beverage'
        ]);
        ExtraChargesType::create([
            'hotel_settings_id' => $hotel->id,
            'name' => 'Spa'
        ]);
        ExtraChargesType::create([
            'hotel_settings_id' => $hotel->id,
            'name' => 'Other Income'
        ]);
        ExtraChargesType::create([
            'hotel_settings_id' => $hotel->id,
            'name' => 'Miscellaneous'
        ]);

        ExtraCharge::create([
            'hotel_settings_id' => $hotel->id,
            'product' => 'Burger Black Angus',
            'status' => 'Enabled',
            'vat' => '13',
            'unit_price' => '30',
            'extra_charge_category_id' => 2,
            'extra_charge_type_id' => 1
        ]);
        ExtraCharge::create([
            'hotel_settings_id' => $hotel->id,
            'product' => 'Pizza Margarita ',
            'status' => 'Enabled',
            'vat' => '13',
            'unit_price' => '20',
            'extra_charge_category_id' => 2,
            'extra_charge_type_id' => 1
        ]);
        ExtraCharge::create([
            'hotel_settings_id' => $hotel->id,
            'product' => 'Coca Cola 250 ml',
            'status' => 'Enabled',
            'vat' => '13',
            'unit_price' => '8',
            'extra_charge_category_id' => 2,
            'extra_charge_type_id' => 2
        ]);
    }
}
