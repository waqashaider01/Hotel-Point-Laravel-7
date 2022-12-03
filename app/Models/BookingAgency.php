<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingAgency extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function scopeIndividual($q)
    {
        $q->where('channel_code','CBE');
    }

    public function scopeOSA($q)
    {
        $q->where('channel_code','OSA');
    }

    public function hotel_setting()
    {
        return $this->belongsTo(HotelSetting::class, 'hotel_settings_id', 'id');
    }

    public function reservations(){
        return $this->hasMany(Reservation::class);
    }
}
