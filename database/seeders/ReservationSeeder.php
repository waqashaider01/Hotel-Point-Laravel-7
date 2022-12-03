<?php

namespace Database\Seeders;

use App\Models\BookingAgency;
use App\Models\Company;
use App\Models\Country;
use App\Models\Guest;
use App\Models\HotelSetting;
use App\Models\PaymentMethod;
use App\Models\PaymentMode;
use App\Models\RateType;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hotel = HotelSetting::first();
        Reservation::create([
            'hotel_settings_id' => $hotel->id,
            'booking_agency_id' => BookingAgency::inRandomOrder()->first()->id,
            'booking_code' => 'asdf123',
            'booking_date' => '2022-02-22',
            'check_in' => today()->subDays(15),
            'check_out' => today()->subDays(13),
            'arrival_hour' => '08:00',
            'discount' => '0',
            'country_id' => Country::inRandomOrder()->first()->id,
            'company_id' => Company::inRandomOrder()->first()->id,
            'channex_status' => 'new',
            'adults' => '2',
            'kids' => '2',
            'infants' => '2',
            'room_id' => Room::inRandomOrder()->first()->id,
            'rate_type_id' => RateType::inRandomOrder()->first()->id,
            'charge_date' => '2022-02-24',
            'payment_method_id' => PaymentMethod::inRandomOrder()->first()->id,
            'payment_mode_id' => PaymentMode::inRandomOrder()->first()->id,
            'guest_id' => Guest::inRandomOrder()->first()->id,
            'arrival_date' => today()->subDays(15),
            'departure_date' => today()->subDays(13),
            'status' => 'Confirm',
            'comment' => 'asdfg',
            'overnights' => 1
        ]);
        Reservation::create([
            'hotel_settings_id' => $hotel->id,
            'booking_agency_id' => BookingAgency::inRandomOrder()->first()->id,
            'booking_code' => 'asdf123',
            'booking_date' => '2022-02-18',
            'check_in' => today()->subDays(13),
            'check_out' => today()->subDays(10),
            'arrival_hour' => '08:00',
            'discount' => '0',
            'country_id' => Country::inRandomOrder()->first()->id,
            'company_id' => Company::inRandomOrder()->first()->id,
            'channex_status' => 'cancelled',
            'adults' => '2',
            'kids' => '2',
            'infants' => '2',
            'room_id' => Room::inRandomOrder()->first()->id,
            'rate_type_id' => RateType::inRandomOrder()->first()->id,
            'charge_date' => '2022-02-18',
            'payment_method_id' => PaymentMethod::inRandomOrder()->first()->id,
            'payment_mode_id' => PaymentMode::inRandomOrder()->first()->id,
            'guest_id' => Guest::inRandomOrder()->first()->id,
            'arrival_date' => today()->subDays(13),
            'departure_date' => today()->subDays(10),
            'status' => 'Cancelled',
            'comment' => 'asdfg',
            'overnights' => 4

        ]);
        Reservation::create([
            'hotel_settings_id' => $hotel->id,
            'booking_agency_id' => BookingAgency::inRandomOrder()->first()->id,
            'booking_code' => 'asdf123',
            'booking_date' => '2022-02-25',
            'check_in' => today()->subDays(10),
            'check_out' => today()->subDays(8),
            'arrival_hour' => '08:00',
            'discount' => '0',
            'country_id' => Country::inRandomOrder()->first()->id,
            'company_id' => Company::inRandomOrder()->first()->id,
            'channex_status' => 'modified',
            'adults' => '2',
            'kids' => '2',
            'infants' => '2',
            'room_id' => Room::inRandomOrder()->first()->id,
            'rate_type_id' => RateType::inRandomOrder()->first()->id,
            'charge_date' => '2022-02-25',
            'payment_method_id' => PaymentMethod::inRandomOrder()->first()->id,
            'payment_mode_id' => PaymentMode::inRandomOrder()->first()->id,
            'guest_id' => Guest::inRandomOrder()->first()->id,
            'arrival_date' => today()->subDays(10),
            'departure_date' => today()->subDays(8),
            'status' => 'Arrived',
            'comment' => 'asdfg',
            'overnights' => 2

        ]);
        Reservation::create([
            'hotel_settings_id' => $hotel->id,
            'booking_agency_id' => BookingAgency::inRandomOrder()->first()->id,
            'booking_code' => 'asdf123',
            'booking_date' => '2022-03-02',
            'check_in' => today()->subDays(7),
            'check_out' => today()->subDays(4),
            'arrival_hour' => '08:00',
            'discount' => '0',
            'country_id' => Country::inRandomOrder()->first()->id,
            'company_id' => Company::inRandomOrder()->first()->id,
            'channex_status' => 'new',
            'adults' => '2',
            'kids' => '2',
            'infants' => '2',
            'room_id' => Room::inRandomOrder()->first()->id,
            'rate_type_id' => RateType::inRandomOrder()->first()->id,
            'charge_date' => '2022-03-02',
            'payment_method_id' => PaymentMethod::inRandomOrder()->first()->id,
            'payment_mode_id' => PaymentMode::inRandomOrder()->first()->id,
            'guest_id' => Guest::inRandomOrder()->first()->id,
            'arrival_date' => today()->subDays(7),
            'departure_date' => today()->subDays(4),
            'status' => 'Offer',
            'comment' => 'asdfg',
            'overnights' => 3

        ]);
    }
}
