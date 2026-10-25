<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplyPosition extends Model
{
    protected $fillable = [
        'date',
        'society_id',
        'job_vacancy_id',
        'position_id',
        'job_apply_society_id',
        'status',
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
    public function position()
    {
        return $this->belongsTo(Society::class, 'position_id');
    }
    public function jobApplication()
    {
        return $this->belongsTo(JobApplySociety::class, 'job_apply_society_id');
    }
}
