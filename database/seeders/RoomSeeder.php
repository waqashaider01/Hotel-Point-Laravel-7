<?php

namespace Database\Seeders;

use App\Models\HotelSetting;
use App\Models\RateType;
use App\Models\RateTypeCategory;
use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hotel = HotelSetting::first();
        $type1 = RoomType::create(['hotel_settings_id' => $hotel->id, 'name' => 'Luxury', 'channex_room_type_id' => 'asdf123', 'reference_code' => 'ADF', 'description' => 'Free', 'type_status' => 1, 'adults_channex' => '3', 'kids_channex' => '2', 'infants_channex' => '2', 'default_occupancy_channex' => '5', 'position' => '1', 'cancellation_charge' => '10']);
        $type2 = RoomType::create(['hotel_settings_id' => $hotel->id, 'name' => 'Double', 'channex_room_type_id' => 'asdf123', 'reference_code' => 'AUG', 'description' => 'Test', 'type_status' => 1, 'adults_channex' => '3', 'kids_channex' => '2', 'infants_channex' => '2', 'default_occupancy_channex' => '6', 'position' => '2', 'cancellation_charge' => '20']);

        $type1->rooms()->create(['number' => 'A1', 'status' => 'Enabled', 'max_capacity' => '4', 'max_adults' => '2', 'max_kids' => 1, 'max_infants' => 1]);
        $type1->rooms()->create(['number' => 'B1', 'status' => 'Enabled', 'max_capacity' => '4', 'max_adults' => '2', 'max_kids' => 1, 'max_infants' => 1]);
        $type1->rooms()->create(['number' => 'C1', 'status' => 'Enabled', 'max_capacity' => '4', 'max_adults' => '2', 'max_kids' => 1, 'max_infants' => 1]);
        $type1->rooms()->create(['number' => 'D1', 'status' => 'Enabled', 'max_capacity' => '4', 'max_adults' => '2', 'max_kids' => 1, 'max_infants' => 1]);
        $type2->rooms()->create(['number' => 'A2', 'status' => 'Enabled', 'max_capacity' => '4', 'max_adults' => '2', 'max_kids' => 1, 'max_infants' => 1]);
        $type2->rooms()->create(['number' => 'B2', 'status' => 'Enabled', 'max_capacity' => '4', 'max_adults' => '2', 'max_kids' => 1, 'max_infants' => 1]);
        $type2->rooms()->create(['number' => 'C2', 'status' => 'Enabled', 'max_capacity' => '4', 'max_adults' => '2', 'max_kids' => 1, 'max_infants' => 1]);

        $cat1 = RateTypeCategory::create(['hotel_settings_id' => $hotel->id, 'name' => 'rateCat1', 'charge_percentage' => '20', 'vat' => '10', 'desc_to_document' => 'test', 'has_breakfast' => 'yes']);
        $cat2 = RateTypeCategory::create(['hotel_settings_id' => $hotel->id, 'name' => 'rateCat2', 'charge_percentage' => '10', 'vat' => '20', 'desc_to_document' => 'test2', 'has_breakfast' => 'yes']);

        $policies = $hotel->rate_type_cancellation_policies;

        $policy1 = $policies[0];
        $policy2 = $policies[1];
        $policy2 = $policies[2];
        $policy2 = $policies[3];

        RateType::create([
            'hotel_settings_id' => $hotel->id,
            'name' => 'test_rate_1',
            'reservation_rate' => 12,
            'charge' => 10,
            'charge_type' => 3,
            'reservation_charge_days' => 2,
            'charge2' => 5,
            'reservation_charge_days_2' => 6,
            'charge_percentage' => 10,
            'no_show_charge_percentage' => 50,
            'early_checkout_charge_percentage' => 20,
            'description_to_document' => 'testDoc',
            'prepayment' => 1,
            'channex_id' => 'asdf123',
            'room_type_id' => $type1->id,
            'rate_type_category_id' => $cat1->id,
            'primary_occupancy' => 2,
            'parent_rate_plan_id' => 2,
            'sell_mode' => 'test_sell',
            'rate_mode' => 'test_rate',
            'cancellation_charge' => 10,
            'cancellation_charge_days' => 2,
            'reference_code' => 1234,
            'rate_type_cancellation_policy_id' => $policy1->id,
            'children_fee' => '10',
            'infant_fee' => '10',
            'auto_rate_increase_type' => 'inc_test_type',
            'auto_rate_increase_vale' => 'inc_test_type',
            'auto_rate_decrease_type' => 'dec_test_type',
            'auto_rate_decrease_vale' => 'dec_test_value',
            'cascade_select_type' => 'cascade_test_type',
            'cascade_select_value' => 'cascade_test_value',
        ]);

        RateType::create([
            'hotel_settings_id' => $hotel->id,
            'name' => 'test_rate_2',
            'reservation_rate' => 12,
            'charge' => 10,
            'charge_type' => 3,
            'reservation_charge_days' => 2,
            'charge2' => 5,
            'reservation_charge_days_2' => 6,
            'charge_percentage' => 10,
            'no_show_charge_percentage' => 50,
            'early_checkout_charge_percentage' => 20,
            'description_to_document' => 'testDoc',
            'prepayment' => 1,
            'channex_id' => 'asdf123',
            'room_type_id' => $type2->id,
            'rate_type_category_id' => $cat2->id,
            'primary_occupancy' => 2,
            'parent_rate_plan_id' => 2,
            'sell_mode' => 'test_sell',
            'rate_mode' => 'test_rate',
            'cancellation_charge' => 10,
            'cancellation_charge_days' => 2,
            'reference_code' => 1234,
            'rate_type_cancellation_policy_id' => $policy2->id,
            'children_fee' => '10',
            'infant_fee' => '10',
            'auto_rate_increase_type' => 'inc_test_type',
            'auto_rate_increase_vale' => 'inc_test_type',
            'auto_rate_decrease_type' => 'dec_test_type',
            'auto_rate_decrease_vale' => 'dec_test_value',
            'cascade_select_type' => 'cascade_test_type',
            'cascade_select_value' => 'cascade_test_value',
        ]);

        RateType::create([
            'hotel_settings_id' => $hotel->id,
            'name' => 'test_rate_3',
            'reservation_rate' => 12,
            'charge' => 10,
            'charge_type' => 3,
            'reservation_charge_days' => 2,
            'charge2' => 5,
            'reservation_charge_days_2' => 6,
            'charge_percentage' => 10,
            'no_show_charge_percentage' => 50,
            'early_checkout_charge_percentage' => 20,
            'description_to_document' => 'testDoc',
            'prepayment' => 1,
            'channex_id' => 'asdf123',
            'room_type_id' => $type1->id,
            'rate_type_category_id' => $cat1->id,
            'primary_occupancy' => 2,
            'parent_rate_plan_id' => 2,
            'sell_mode' => 'test_sell',
            'rate_mode' => 'test_rate',
            'cancellation_charge' => 10,
            'cancellation_charge_days' => 2,
            'reference_code' => 1234,
            'rate_type_cancellation_policy_id' => $policy1->id,
            'children_fee' => '10',
            'infant_fee' => '10',
            'auto_rate_increase_type' => 'inc_test_type',
            'auto_rate_increase_vale' => 'inc_test_type',
            'auto_rate_decrease_type' => 'dec_test_type',
            'auto_rate_decrease_vale' => 'dec_test_value',
            'cascade_select_type' => 'cascade_test_type',
            'cascade_select_value' => 'cascade_test_value',
        ]);
        RateType::create([
            'hotel_settings_id' => $hotel->id,
            'name' => 'test_rate_4',
            'reservation_rate' => 12,
            'charge' => 10,
            'charge_type' => 3,
            'reservation_charge_days' => 2,
            'charge2' => 5,
            'reservation_charge_days_2' => 6,
            'charge_percentage' => 10,
            'no_show_charge_percentage' => 50,
            'early_checkout_charge_percentage' => 20,
            'description_to_document' => 'testDoc',
            'prepayment' => 1,
            'channex_id' => 'asdf123',
            'room_type_id' => $type1->id,
            'rate_type_category_id' => $cat2->id,
            'primary_occupancy' => 2,
            'parent_rate_plan_id' => 2,
            'sell_mode' => 'test_sell',
            'rate_mode' => 'test_rate',
            'cancellation_charge' => 10,
            'cancellation_charge_days' => 2,
            'reference_code' => 1234,
            'rate_type_cancellation_policy_id' => $policy2->id,
            'children_fee' => '10',
            'infant_fee' => '10',
            'auto_rate_increase_type' => 'inc_test_type',
            'auto_rate_increase_vale' => 'inc_test_type',
            'auto_rate_decrease_type' => 'dec_test_type',
            'auto_rate_decrease_vale' => 'dec_test_value',
            'cascade_select_type' => 'cascade_test_type',
            'cascade_select_value' => 'cascade_test_value',
        ]);
        RateType::create([
            'hotel_settings_id' => $hotel->id,
            'name' => 'test_rate_5',
            'reservation_rate' => 12,
            'charge' => 10,
            'charge_type' => 3,
            'reservation_charge_days' => 2,
            'charge2' => 5,
            'reservation_charge_days_2' => 6,
            'charge_percentage' => 10,
            'no_show_charge_percentage' => 50,
            'early_checkout_charge_percentage' => 20,
            'description_to_document' => 'testDoc',
            'prepayment' => 1,
            'channex_id' => 'asdf123',
            'room_type_id' => $type2->id,
            'rate_type_category_id' => $cat1->id,
            'primary_occupancy' => 2,
            'parent_rate_plan_id' => 2,
            'sell_mode' => 'test_sell',
            'rate_mode' => 'test_rate',
            'cancellation_charge' => 10,
            'cancellation_charge_days' => 2,
            'reference_code' => 1234,
            'rate_type_cancellation_policy_id' => $policy2->id,
            'children_fee' => '10',
            'infant_fee' => '10',
            'auto_rate_increase_type' => 'inc_test_type',
            'auto_rate_increase_vale' => 'inc_test_type',
            'auto_rate_decrease_type' => 'dec_test_type',
            'auto_rate_decrease_vale' => 'dec_test_value',
            'cascade_select_type' => 'cascade_test_type',
            'cascade_select_value' => 'cascade_test_value',
        ]);
    }
}