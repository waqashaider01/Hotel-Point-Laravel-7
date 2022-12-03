<?php

namespace Database\Seeders;

use App\Models\HotelSetting;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $george_user = User::where('email', 'george@test.com')->first();

        $george_users_hotel = HotelSetting::where('created_by_id', $george_user->id)->first();

        Property::updateOrCreate(
            [
                'hotel_id' =>  $george_users_hotel->id,
                'property_id' => '1a149ef7-d852-4328-9cab-d6c37880e19a',
            ],
            [
                'id' => 1,
                'name' =>  'Test',
                'hotel_id' =>  $george_users_hotel->id,
                'property_id' => '1a149ef7-d852-4328-9cab-d6c37880e19a',
                'status' => 1,
            ]
        );
    }
}
