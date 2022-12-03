<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestAccommodationPayment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
    public function deposit_type()
    {
        return $this->hasOne(DepositType::class);
    }
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}