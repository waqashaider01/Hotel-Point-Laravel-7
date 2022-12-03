<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function document_type()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function document_info()
    {
        return $this->hasOne(DocumentInfo::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
