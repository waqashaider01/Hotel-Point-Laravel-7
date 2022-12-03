<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestExtrasPayment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
