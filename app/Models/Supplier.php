<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    public function opex(){
        return $this->hasMany(OpexData::class, 'supplier_id', 'id');
    }
}
