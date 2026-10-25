<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplySociety extends Model
{
    protected $fillable = [
        'notes',
        'date',
        'society_id',
        'job_vacancy_id',
    ];

    public function casts()
    {
        return ['date' => 'date'];
    }
    public function society()
    {
        return $this->belongsTo(Society::class, 'society_id');
    }
    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id');
    }
    public function appliedPositions()
    {
        return $this->hasMany(JobApplyPosition::class, 'job_apply_society_id');
    }
}
