<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\DocumentType;
use App\Models\VatOption;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CountrySeeder::class,
            // PaymentSeeder::class,
            // AgencySeeder::class,
            CurrencySeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            VatOptionSeeder::class,
            HotelTaxCategorySeeder::class,
            HotelSettingSeeder::class,
            // CompanySeeder::class,
            // RoomSeeder::class,
            CosSeeder::class,
            // ReservationSeeder::class,
            // DocumentSeeder::class,
            // TemplateSeeder::class,
            ServiceSeeder::class,
            DepositSeeder::class,
            // PropertySeeder::class,
        ]);
    }
}
