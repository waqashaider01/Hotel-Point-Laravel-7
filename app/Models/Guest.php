<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
