<?php

namespace App\Models\Assessment;
use Illuminate\Database\Eloquent\Model;

class AssessmentCriterionPoints extends Model
{
    public $timestamps = false;
    protected $table = 'assessment_criterion_points';
    protected $fillable = ['name', 'point','assessment_id'];

    public function criterions() {
        return $this->belongsTo(AssessmentList::class, 'assessment_id', 'id');
    }
}
