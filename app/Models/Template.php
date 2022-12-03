<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $guarded = [];

    const SHORT_CODE_LIST = [
        "Reservation ID" => '[id]',
        "Reservation Status" => '[reservation_status]',
        "Reservation Booking Agency" => '[booking_agency]',
        "Reservation Charge Date" => '[charge_date]',
        "Reservation Checkin Date" => '[checkin_date]',
        "Reservation Checkout Date" => '[checkout_date]',
        "Reservation Arrival Date" => '[arrival_date]',
        "Reservation Departure Date" => '[departure_date]',
        "Reservation Actual Checkin" => '[actual_checkin]',
        "Reservation Actual Checkout" => '[actual_checkout]',
        "Reservation Nights" => '[nights]',
        "Reservation Arrival Hour" => '[arrival_hour]',
        "Guest Country" => '[guest_country]',
        "Adult Occupants" => '[adults]',
        "Kid Occupants" => '[kids]',
        "Infant Occupants" => '[infants]',
        "Booking Date" => '[booking_date]',
        "Reservation Comment" => '[comment]',
        "Guest Id" => '[guest_id]',
        "Guest Name" => '[guest_name]',
        "Guest Phone" => '[guest_phone]',
        "Guest Email" => '[guest_email]',
        "Room Number" => '[room_number]',
        "Room Type" => '[room_type]',
        "Checkin Time" => '[checkin_time]',
        "Checkout Time" => '[checkout_time]',
        "Overnight Tax" => '[overnight_tax]',
        "Daily Rate"=> '[daily_rate]',
        "Total Reservation Amount" => '[total_reservation_amount]',
    ];

    public function scopeCheckIn($q)
    {
        $q->where('type', 'checkin');
    }

    public function scopeEmail($q)
    {
        $q->where('type', 'email');
    }

    public function fillTemplateContentBody($reservation_id)
    {
        $body = $this->template;
        $reservation = Reservation::find($reservation_id);
        $settings = getHotelSettings();
        foreach (Template::SHORT_CODE_LIST as $shortCode) {
            $body = str_replace("$shortCode", sprintf("<b class='text-info'>%s</b>", $this->getInfo($shortCode, $reservation, $settings)), $body);
        }
        return $body;
    }

    public function getInfo($shortCode, $reservation, $settings)
    {
        switch ($shortCode) {
            case '[id]':
                return $reservation->booking_code;
            case '[reservation_status]':
                return $reservation->status;
            case '[booking_agency]':
                return $reservation->booking_agency->name;
            case '[charge_date]':
                return $reservation->charge_date;
            case '[checkin_date]':
                return $reservation->check_in;
            case '[checkout_date]':
                return $reservation->check_out;
            case '[arrival_date]':
                return $reservation->arrival_date;
            case '[departure_date]':
                return $reservation->departure_date;
            case '[actual_checkin]':
                return $reservation->actual_checkin;
            case '[actual_checkout]':
                return $reservation->actual_checkout;
            case '[nights]':
                return $reservation->overnights;
            case '[arrival_hour]':
                return $reservation->arrival_hour;
            case '[guest_country]':
                return optional($reservation->guest->country)->name ?? '';
            case '[adults]':
                return $reservation->adults;
            case '[kids]':
                return $reservation->kids;
            case '[infants]':
                return $reservation->infants;
            case '[booking_date]':
                return $reservation->booking_date;
            case '[comment]':
                return $reservation->comment;
            case '[guest_name]':
                return $reservation->guest->full_name;
            case '[guest_phone]':
                return $reservation->guest->phone;
            case '[guest_email]':
                return $reservation->guest->email;
            case '[room_number]':
                return optional($reservation->room)->number ?? 'N/A';
            case '[room_type]':
                return optional($reservation->room)->room_type->name ?? 'N/A';
            case '[guest_id]':
                return $reservation->guest_id;
            case '[checkin_time]':
                return $settings->ordered_checkin_hour;
            case '[checkout_time]':
                return $settings->ordered_checkout_hour;
            case '[overnight_tax]':
                return optional($settings->overnight_tax)->tax ?? 'N/A';
            case '[daily_rate]':
                return optional( $reservation->daily_rates)->first()->price ?? 'N/A';
            case '[total_reservation_amount]':
                return $reservation->reservation_amount;
            default:
                return '';
        }
    }
}
