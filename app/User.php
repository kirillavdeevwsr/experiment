<?php

namespace App;

use App\Models\AdditionalInformationTeacher;
use App\Models\Assessment\AssessmentList;
use App\Models\Assessment\AssessmentListUser;
use App\Models\College\AdditionalStudent;
use App\Models\Role;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','surname', 'patronymic', 'group', 'specialty', 'email', 'phone', 'image', ''
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

//    protected $appends = ['specialty', 'group', 'phone', 'email', 'address', 'student_ref_key', 'isStudent', 'image'];

    public function setSpecialtyAttribute($value) {
        $this->attributes['specialty'] = $value;
    }

    public function setGroupAttribute($value) {
        $this->attributes['group'] = $value;
    }

    public function setPhoneAttribute($value) {
        $this->attributes['phone'] = $value;
    }

    public function setEmailAttribute($value) {
        $this->attributes['email'] = $value;
    }

    public function setAddressAttribute($value){
        $this->attributes['address'] = $value;
    }

    public function news(){
        return $this->hasMany('App\Models\News', 'autor');
    }

    public function roles() {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id');
    }

    public function additional() {
        return $this->hasOne(AdditionalInformationTeacher::class, 'id', 'additional_information');
    }

    public function assessments() {
        return $this->hasMany(AssessmentListUser::class,'user_id', 'id');
    }

    public function additionalStudent() {
        return $this->hasOne(AdditionalStudent::class, 'id', 'additional_student');
    }
}
