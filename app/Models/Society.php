<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Society extends Model
{
    protected $fillable = [
        'id_card_number',
        'password',
        'name',
        'born_date',
        'gender',
        'address',
        'regional_id',
        'login_tokens',
    ];
    protected $hidden = [
        'password',
        'login_tokens'
    ];

    protected function casts()
    {
        return [
            'born_date' => 'date',
            'password' => 'hashed'
        ];
    }

    public function regional()
    {
        return $this->belongsTo(Regional::class, 'regional_id');
    }
    public function jobApplication()
    {
        return $this->hasMany(JobApplySociety::class, 'society_id');
    }
    public function appliedPositions()
    {
        return $this->hasMany(JobApplyPosition::class, 'society_id');
    }
    public function validations()
    {
        return $this->hasMany(Validation::class, 'society_id');
    }
}
