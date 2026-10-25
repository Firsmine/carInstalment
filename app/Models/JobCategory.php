<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    protected $fillable = [
        'job_category',
    ];

    public function jobVacancies()
    {
        return $this->hasMany(JobVacancy::class, 'job_category_id');
    }
    public function validations()
    {
        return $this->hasMany(Validation::class, 'job_category_id');
    }
}
