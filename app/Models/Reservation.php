<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reservation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function booking_agency()
    {
        return $this->belongsTo(BookingAgency::class);
    }
    public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function guest()
    {
        if ($this->checkin_guest_id) {
            return $this->belongsTo(Guest::class, 'checkin_guest_id');
        }
        return $this->belongsTo(Guest::class);
    }

    public function checkin_guest()
    {
        return $this->belongsTo(Guest::class, 'checkin_guest_id');
    }

    public function rate_type()
    {
        return $this->belongsTo(RateType::class);
    }

    public function guest_accommodation_payment()
    {
        return $this->hasMany(GuestAccommodationPayment::class, 'reservation_id');
    }

    public function guest_extras_payments()
    {
        return $this->hasMany(GuestExtrasPayment::class);
    }

    public function guest_overnight_tax_payments()
    {
        return $this->hasMany(GuestOvernightTaxPayment::class);
    }

    public function daily_rates()
    {
        return $this->hasMany(DailyRate::class);
    }

    public function accom_daily_rates()
    {
        $checkIn = $this->actual_checkin ?? $this->arrival_date;
        $checkOut = $this->actual_checkout ?? $this->departure_date;
        return $this->hasMany(DailyRate::class)->where("date", ">=", $checkIn)->where("date", "<", $checkOut);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function payment_mode()
    {
        return $this->belongsTo(PaymentMode::class);
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function reservation_extra_charges()
    {
        return $this->hasMany(ReservationExtraCharge::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function reservation_deposits()
    {
        return $this->hasMany(ReservationDeposit::class);
    }

    
    public function hotel(){
        return $this->belongsTo(HotelSetting::class);
    }

    public function getNextId()
    {
        $statement = DB::select("show table status like 'reservations'");
        return $statement[0]->Auto_increment;
    }
}
