<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraCharge extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function extra_charge_category(){
        return $this->belongsTo(ExtraChargesCategory::class);
    }
    public function extra_charge_type(){
        return $this->belongsTo(ExtraChargesType::class);
    }
}
