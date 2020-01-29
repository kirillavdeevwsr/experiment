<?php

namespace App\Models\Assessment;

use App\User;
use Illuminate\Database\Eloquent\Model;

class AssessmentList extends Model
{
    public $timestamps = false;
    protected $table = 'assessment_list';
    protected $fillable = ['criterion', 'unit_of_measure', 'criterion_assessment', 'data_source', 'summary_periodicity', 'frequency_of_payment', 'responsible_id', 'multiple_select', 'multi_add'];

    public function user() {
        return $this->belongsTo(User::class, 'responsible_id', 'id');
    }

    public function assessment() {
        return $this->hasOne(AssessmentListUser::class, 'assessment_id', 'id');
    }

    public function assessments() {
        return $this->hasMany(AssessmentListUser::class, 'assessment_id', 'id');
    }

    public function responsible() {
        return $this->hasOne(User::class, 'id', 'responsible_id');
    }

    public function periodicity() {
        return $this->hasOne(AssessmentPeriodicity::class, 'id', 'summary_periodicity');
    }

    public function frequencyPayment() {
        return $this->hasOne(AssessmentFrequencyOfPayment::class, 'id', 'frequency_of_payment');
    }

    public function criterions() {
        return $this->hasMany(AssessmentCriterionPoints::class, 'assessment_id', 'id');
    }
}
