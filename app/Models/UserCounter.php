<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class UserCounter extends Model
{

  protected $table = 'users_hit_counter';

 public $timestamps = false;


    public function rules()
    {
        return [
            [['ip', 'timestamp'], 'required'],
           
        ];
    }




}