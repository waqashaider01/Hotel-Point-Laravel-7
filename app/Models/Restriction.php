<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restriction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function room_type()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function rate_type()
    {
        return $this->belongsTo(RateType::class);
    }
}
