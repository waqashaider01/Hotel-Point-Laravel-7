<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\HotelSetting;
use App\Models\RateTypeCancellationPolicy;
use App\Models\HotelTaxCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class HotelSettingSeeder extends Seeder
{
    public function run()
    {
        $george_user = User::where('email', 'george@test.com')->first();

        /**
         * @var \App\Models\HotelSetting
         */
        $george_users_hotel = HotelSetting::updateOrCreate(
            [
                'id' => 1,
            ],
            [
            'id' => 1,
            'logo' => asset('images/logo/logo.png'),
            'created_by_id' => $george_user->id,
            'name' => 'Sun Hotel',
            'brand_name' => 'Test Brand',
            'activity' => 'Test Activity',
            'tax_id' => 123455,
            'tax_office' => 'Islamabad',
            'general_commercial_register' => 4321,
            'address' => 'test address',
            'postal_code' => 1234,
            'city' => 'Quetta',
            'phone' => '03041234123',
            'website' => 'test.com',
            'email' => 'test@test.com',
            'notification_receiver_email' => 'test@test.com',
            'city_tax' => 5,
            'cookie_value' => 'none yet',
            'ordered_checkin_hour' => date('H:m:s'),
            'ordered_checkout_hour' => date('H:m:s'),
            'housekeeping' => 1,
            'currency_id' => Currency::where('initials', "EUR")->first()->id,
            'date' => date('Y-m-d'),
            'cashier_pass' => '123456',
            'complimentary_rate' => '5',
            'bank_name' => 'ABC',
            'swift_code' => '32421',
            'iban' => 'aej33r4',
            'bank_status' => 1,
            'overnight_tax_id'=> HotelTaxCategory::first()->id,
            'oxygen_api_key' => "faee7ef0-5bd9-4751-acd2-ebb0699bd832"
        ]);

        $george_users_hotel->generate_document_types();
        $george_users_hotel->generate_payment_modes();
        $george_users_hotel->connected_users()->sync([$george_user->id]);
        $george_users_hotel->generate_rate_type_cancellation_policies();
        $george_users_hotel->generate_hotel_vat();
    }
}
