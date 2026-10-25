<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Validation extends Model
{
    protected $fillable = [
        'user_id',
        'role',
        'name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function validations(){
        return $this->hasMany{Validation::class, 'validator_id'};
    }
}
