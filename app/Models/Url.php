<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\CarbonInterval;
use Carbon\Carbon;
use Jenssegers\Date\Date;

class Url extends Model
{
    public $table = "url";


    protected $fillable = [
        'title', 'url'
    ];


}
