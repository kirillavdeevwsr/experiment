<?php

namespace App\Models\Assessment;

use Illuminate\Database\Eloquent\Model;

class AssessmentFrequencyOfPayment extends Model
{
    public $timestamps = false;
    protected $table = 'assessment_frequency_of_payment';
    protected $fillable = ['name'];
}
