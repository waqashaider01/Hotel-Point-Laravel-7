<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Guest;
use App\Models\HotelSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Set "TRUNCATE_ON_SEED" in .env file to delete previous data
        if (env("TRUNCATE_ON_SEED", false)) {
            Schema::disableForeignKeyConstraints();
            User::truncate();
            Guest::truncate();
            Schema::enableForeignKeyConstraints();
        }

        $permissions = Permission::pluck('name');
        $countries = Country::all();

        $users = [
            [
                "modal_data" => [
                    'first_name' => 'Super',
                    'last_name' => 'Admin',
                    'role' => "Super Administrator",
                    'email' => 'super_admin@test.com',
                    'email_verified_at' => now(),
                    'password' => bcrypt("12341234"),
                    'country_id' => $countries->random()->id,
                    'address' => 'abc',
                    'phone' => 12341234
                ],
                "permissions" => $permissions->toArray(),
            ],
            [
                "modal_data" => [
                    'first_name' => 'George',
                    'last_name' => 'KA',
                    'role' => "Administrator",
                    'email' => 'george@test.com',
                    'email_verified_at' => now(),
                    'password' => bcrypt("12341234"),
                    'country_id' => $countries->random()->id,
                    'address' => 'abc',
                    'phone' => 12341234
                ],
                "permissions" => $permissions->toArray(),
            ],
        ];

        foreach ($users as $user) {
            $created_user = User::updateOrCreate($user['modal_data']);
            $created_user->syncPermissions($user['permissions']);
            if($created_user->email === 'super_admin@test.com'){
                $created_user->assignRole('Super Admin');
            }
        }
    }
}
