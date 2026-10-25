<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory;

    protected $fillable = [
        'cars',
        'brand_id',
        'price',
        'description'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    public funtion availableMonths(){
        return $this->hasMany(AvailableMonth::class, 'installment_id');
    }
}
