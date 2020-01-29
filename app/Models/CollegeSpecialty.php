<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollegeSpecialty extends Model
{
    public $timestamps = false;
    protected $table = "college_specialties";
    protected $fillable = ['ref_key', 'code', 'name'];
}
