<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollegeDepartment extends Model
{
    public $timestamps = false;
    protected $table = "college_departments";
    protected $fillable = ['ref_key','name'];
}
