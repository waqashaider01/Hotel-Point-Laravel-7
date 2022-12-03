<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
        'hotel_settings_id' => 1,
        'name' => 'company_1',
        'activity' => 'test_activity',
        'vat_number' => 23,
        'tax_office' => 'Pakistan',
        'address' => 'Islamabad',
        'category' => 'test',
        'headquarters' => 'IDK',
        'branch' => 'none',
        'postal_code' => '44000',
        'phone_number' => '123345412',
        'country' => 'Pakistan',
    ]);
    Company::create([
        'hotel_settings_id' => 1,
        'name' => 'company_2',
        'activity' => 'test_activity',
        'vat_number' => 23,
        'tax_office' => 'Pakistan',
        'address' => 'Islamabad',
        'category' => 'test',
        'headquarters' => 'IDK',
        'branch' => 'none',
        'postal_code' => '44000',
        'phone_number' => '123345412',
        'country' => 'Pakistan',
    ]);
    Company::create([
        'hotel_settings_id' => 1,
        'name' => 'company_3',
        'activity' => 'test_activity',
        'vat_number' => 23,
        'tax_office' => 'Pakistan',
        'address' => 'Islamabad',
        'category' => 'test',
        'headquarters' => 'IDK',
        'branch' => 'none',
        'postal_code' => '44000',
        'phone_number' => '123345412',
        'country' => 'Pakistan',
    ]);
    }
}
