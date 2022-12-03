<?php

namespace Database\Seeders;

use App\Models\BookingAgency;
use App\Models\PaymentMethod;
use App\Models\PaymentMode;
use Illuminate\Database\Seeder;

class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BookingAgency::create([
            'name' => 'Individual',
            'bg' => asset('images/logo/logo.png'),
            'activity' => 'test_activity',
            'vat_number' => 1234,
            'tax_office' => 'test_office',
            'address' => 'test_address',
            'category' => 'test_cat',
            'headquarters' => 'test_headq',
            'branch' => 'test_branch',
            'postal_code' => 'test_code',
            'phone_number' => '1234123',
            'country' => 'test_country',
            'channex_channel_id' => 'afe2262e-27e3-4fa0-9544-3c3f60de0407',
            'default_payment_mode_id' => PaymentMode::all()->random()->id,
            'supports_virtual_card' => 'yes',
            'virtual_card_payment_mode_id' => PaymentMode::all()->random()->id,
            'default_payment_method_id' => PaymentMethod::all()->random()->id,
            'charge_date_days' => '12',
            'channel_code' => 'OSA',
            'charge_mode' => '3',
        ]);
    }
}
