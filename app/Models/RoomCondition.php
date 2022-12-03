<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomCondition extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
