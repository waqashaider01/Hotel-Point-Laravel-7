<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function active_rooms()
    {
        return $this->hasMany(Room::class)->where('status', '=', 'Enabled');
    }

    public function restrictions()
    {
        return $this->hasMany(Restriction::class);
    }

    public function rate_types()
    {
        return $this->hasMany(RateType::class);
    }

    public function hotel_setting()
    {
        return $this->belongsTo(HotelSetting::class, 'hotel_settings_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('type_status', '1');
    }
}
