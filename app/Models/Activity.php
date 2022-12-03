<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
