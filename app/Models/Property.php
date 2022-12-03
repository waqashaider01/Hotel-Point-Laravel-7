<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    public $guarded = [];

    /**
     * Get the hotel_setting associated with the Property
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hotel_setting()
    {
        return $this->belongsTo(HotelSetting::class, 'hotel_id', 'id');
    }
}
