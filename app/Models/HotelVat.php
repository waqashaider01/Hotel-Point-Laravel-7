<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelVat extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function vat_option()
    {
        return $this->belongsTo(VatOption::class, 'vat_option_id', 'id');
    }

    
}
