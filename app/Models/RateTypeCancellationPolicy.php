<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateTypeCancellationPolicy extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static $policy_types = [
        "Based At Nights" => 1,
        "Based At Percent" => 2,
        "Fixed Amount Per Booking" => 3,
        "Fixed Amount Per Booking Room" => 4,
    ];

    public function getTypeAttribute()
    {
        return RateTypeCancellationPolicy::$policy_types[$this->name];
    }
}
