<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model
{
    protected $fillable = [
        'job_category_id',
        'company',
        'address',
        'description',
    ];

    public function jobCategories()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }
    public function availablePositions()
    {
        return $this->hasMany(AvailablePosition::class, 'job_vacancy_id');
    }
    public function applications()
    {
        return $this->hasMany(JobApplySociety::class, 'job_vacancy_id');
    }
    public function appliedPositions()
    {
        return $this->hasMany(JobApplyPosition::class, 'job_vacancy_id');
    }
}
