<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailablePosition extends Model
{
    protected $fillable = [
        'job_vacancy_id',
        'position',
        'capacity',
        'apply_capacity',
    ];

    public function jobVacancies()
    {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id');
    }
    public function applications()
    {
        return $this->hasMany(JobApplyPosition::class, 'position_id');
    }
}
