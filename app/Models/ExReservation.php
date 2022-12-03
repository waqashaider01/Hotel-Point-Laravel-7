<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExReservation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function booking_agency()
    {
        return $this->belongsTo(BookingAgency::class);
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function room_type()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function rate_type()
    {
        return $this->belongsTo(RateType::class);
    }
}
