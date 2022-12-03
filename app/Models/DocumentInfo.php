<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentInfo extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function booking_agency()
    {
        return $this->belongsTo(BookingAgency::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }
}
