<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $with = ['country_model'];

    public function getCountryCodeAttribute()
    {
        return $this->country_model->alpha_two_code;
    }

    public function country_model()
    {
        return $this->belongsTo(Country::class, 'country', 'name');
    }

    public function country(){
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
