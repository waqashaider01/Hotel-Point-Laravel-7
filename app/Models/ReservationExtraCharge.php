<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationExtraCharge extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function extra_charge() 
    {
        return $this->belongsTo(ExtraCharge::class);
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
