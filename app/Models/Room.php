<?php

namespace App\Models;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function room_type()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function room_conditions()
    {
        return $this->hasMany(RoomCondition::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'Enabled');
    }

    /**
     * Get the availabilities associated with the Room
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function availabilities()
    {
        return $this->hasOne(Availability::class);
    }

    /**
     * Get all of the reservations for the Room
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
