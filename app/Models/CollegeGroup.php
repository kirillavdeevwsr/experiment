<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollegeGroup extends Model
{
    public $timestamps = false;
    protected $table = "college_groups";
    protected $fillable = [
        'ref_key', 'department_ref_key','specialty_ref_key', 'name', 'status', 'form_training'
    ];

    public function specialty() {
        return $this->hasOne(CollegeSpecialty::class, 'ref_key' ,'specialty_ref_key');
    }

    public function department() {
        return $this->hasOne(CollegeDepartment::class, 'ref_key' ,'department_ref_key');
    }
}
