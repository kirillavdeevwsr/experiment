<?php

namespace App\Models;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Jenssegers\Date\Date;
use Cviebrock\EloquentSluggable\Sluggable;

class Course extends Model
{

    use Sluggable;
    protected $fillable = [
        'title', 'start', 'finish', 'description', 'info'
    ];

    protected $appends = [
        'duration', 'raw_date', 'month'
    ];

    public function sluggable() {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function getDurationAttribute(){
        $start=Carbon::parse($this->start);
        $finish=Carbon::parse($this->finish);
        $interval= $finish->diffInDays($start);
//        Carbon::setLocale('ru');
        $duration = CarbonInterval::day($interval);
        return $duration;
    }

    public function getRawDateAttribute(){

        Date::setLocale('ru');
        $date= Date::parse($this->start);
        return $date;
    }



    public function getMonthAttribute(){
        Date::setLocale('ru');
        $date=Date::parse($this->start)->format('j F');
        $res= preg_replace('/[^a-zA-Zа-яА-Я]/ui','', $date);
        return $res;
    }
}
