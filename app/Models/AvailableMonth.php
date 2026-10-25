<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailableMonth extends Model
{
    protected $fillable = [
        'installment_id',
        'month',
        'description',
        'nominal'
    ];

    public function installment()
    {
        return $this->belongsTo(Installment::class, 'installment_id');
    }
}
