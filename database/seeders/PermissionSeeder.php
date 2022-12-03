<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Set "TRUNCATE_ON_SEED" in .env file to delete previous data
        // Make sure the rerun the UserSeeder after this seeder is completed.
        if (env("TRUNCATE_ON_SEED", false)) {
            Schema::disableForeignKeyConstraints();
            Permission::truncate();
            Schema::enableForeignKeyConstraints();
        }

        $permissions = [
            ['name' => "Account Report", 'guard_name' => 'web'],
            ['name' => "Actual Budget", 'guard_name' => 'web'],
            ['name' => "Add Supplier", 'guard_name' => 'web'],
            ['name' => "B2B Report", 'guard_name' => 'web'],
            ['name' => "Booking Channels", 'guard_name' => 'web'],
            ['name' => "Booking Engine", 'guard_name' => 'web'],
            ['name' => "Calendar", 'guard_name' => 'web'],
            ['name' => "Cancel Reservation", 'guard_name' => 'web'],
            ['name' => "Cancellation Fee", 'guard_name' => 'web'],
            ['name' => "Channel", 'guard_name' => 'web'],
            ['name' => "Channel Manager", 'guard_name' => 'web'],
            ['name' => "Commission", 'guard_name' => 'web'],
            ['name' => "Commission List", 'guard_name' => 'web'],
            ['name' => "Companies", 'guard_name' => 'web'],
            ['name' => "Credit Card List", 'guard_name' => 'web'],
            ['name' => "Credit Note", 'guard_name' => 'web'],
            ['name' => "Daily Cashier", 'guard_name' => 'web'],
            ['name' => "Debtor Ledger", 'guard_name' => 'web'],
            ['name' => "Ex Reservation", 'guard_name' => 'web'],
            ['name' => "Extra Charge", 'guard_name' => 'web'],
            ['name' => "Finance", 'guard_name' => 'web'],
            ['name' => "Guest Profile", 'guard_name' => 'web'],
            ['name' => "Hotel Budget", 'guard_name' => 'web'],
            ['name' => "Hotel Setting", 'guard_name' => 'web'],
            ['name' => "Housekeeping", 'guard_name' => 'web'],
            ['name' => "Inventory", 'guard_name' => 'web'],
            ['name' => "Invoice List", 'guard_name' => 'web'],
            ['name' => "KPI Report", 'guard_name' => 'web'],
            ['name' => "Meal Categories", 'guard_name' => 'web'],
            ['name' => "Modified Reservation", 'guard_name' => 'web'],
            ['name' => "No Show List", 'guard_name' => 'web'],
            ['name' => "Opex", 'guard_name' => 'web'],
            ['name' => "Opex Form", 'guard_name' => 'web'],
            ['name' => "Opex List", 'guard_name' => 'web'],
            ['name' => "Opex Report", 'guard_name' => 'web'],
            ['name' => "Overnight Tax", 'guard_name' => 'web'],
            ['name' => "Payment Tracker", 'guard_name' => 'web'],
            ['name' => "Rate Plan", 'guard_name' => 'web'],
            ['name' => "Receipt List", 'guard_name' => 'web'],
            ['name' => "Reporting", 'guard_name' => 'web'],
            ['name' => "Reservation List", 'guard_name' => 'web'],
            ['name' => "Reservations", 'guard_name' => 'web'],
            ['name' => "Revenue Report", 'guard_name' => 'web'],
            ['name' => "Room and Rates", 'guard_name' => 'web'],
            ['name' => "Room Division Report", 'guard_name' => 'web'],
            ['name' => "Room Type and Rooms", 'guard_name' => 'web'],
            ['name' => "Settings", 'guard_name' => 'web'],
            ['name' => "Special Annual Doc", 'guard_name' => 'web'],
            ['name' => "Tax Document", 'guard_name' => 'web'],
            ['name' => "User Setting", 'guard_name' => 'web'],
        ];

        Permission::insert($permissions);
    }
}
