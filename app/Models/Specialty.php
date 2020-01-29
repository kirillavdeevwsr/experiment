<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    protected $fillable =[
        'ref_key', 'speciality_key', 'name', 'financing', 'checkbox'
    ];
    public function getSpecialityData(){
        return [
            'ref_key'=>$this->ref_key,
            'speciality_key'=>$this->speciality_key,
            'name'=>$this->name,
            'financing'=>$this->financing
        ];
    }
}
