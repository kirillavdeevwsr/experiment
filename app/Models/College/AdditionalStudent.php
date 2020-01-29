<?php

namespace App\Models\College;

use App\Models\CollegeDepartment;
use App\Models\CollegeGroup;
use App\Models\CollegeSpecialty;
use Illuminate\Database\Eloquent\Model;

class AdditionalStudent extends Model
{
    protected $table = "additional_student";

    protected $fillable = [
      'ref_key_profile', 'ref_key_student', 'ref_key_department', 'ref_key_specialty', 'ref_key_group', 'birthday'
    ];

    public function department() {
        return $this->hasOne(CollegeDepartment::class, 'ref_key', 'ref_key_department');
    }

    public function specialty() {
        return $this->hasOne(CollegeSpecialty::class, 'ref_key', 'ref_key_specialty');
    }

    public function group() {
        return $this->hasOne(CollegeGroup::class, 'ref_key', 'ref_key_group');
    }
}
