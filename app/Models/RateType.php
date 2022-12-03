<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateType extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'occupancy_logic' => 'array',
    ];

    protected $with = [
        'room_type',
        'restrictions',
        'rate_type_category',
        'rate_type_cancellation_policy',
    ];

    public function room_type()
    {
        return $this->belongsTo(RoomType::class);
    }
    public function restrictions()
    {
        return $this->hasMany(Restriction::class);
    }

    public function rate_type_category()
    {
        return $this->belongsTo(RateTypeCategory::class);
    }

    public function rate_type_cancellation_policy()
    {
        return $this->belongsTo(RateTypeCancellationPolicy::class, "rate_type_cancellation_policy_id", 'id');
    }
}
