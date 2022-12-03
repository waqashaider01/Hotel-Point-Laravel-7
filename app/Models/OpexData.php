<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpexData extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function description()
    {
        return $this->belongsTo(Description::class);
    }

    public function category()
    {
        return $this->description()->category->name;
    }

    public function cost_of_sale()
    {
        return $this->description()->category()->cost_of_sale->name;
    }

}
