<?php

namespace App\Models\Assessment;

use Illuminate\Database\Eloquent\Model;

class AssessmentPeriodicity extends Model
{
    public $timestamps = false;
    protected $table = 'assessment_periodicity';
    protected $fillable = ['name'];
}
