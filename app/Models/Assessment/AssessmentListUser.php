<?php

namespace App\Models\Assessment;

use App\Models\Statuses;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class AssessmentListUser extends Model
{
    protected $table = "assessment_list_user";

    public function setStatusColorAttribute($value) {
        $this->attributes['status_color'] = $value;
    }

    public function getCreatedAtAttribute($date) {
        return Date::parse($date)->format('d.m.Y H:i:s');
    }

    public function getUpdatedAtAttribute($date) {
        return Date::parse($date)->format('d.m.Y H:i:s');
    }

    public function assessment() {
        return $this->belongsTo(AssessmentList::class, 'assessment_id', 'id');
    }

    public function users() {
        return $this->belongsTo(User::class,'user_id', 'id');
    }

    public function status() {
        return $this->belongsTo(Statuses::class, 'status_id', 'id');
    }

}
