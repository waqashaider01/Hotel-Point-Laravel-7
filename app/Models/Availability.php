<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function room_type()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
