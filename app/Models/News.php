<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Events\DeleteNewsEvent;
use Carbon\Carbon;
use Jenssegers\Date\Date;
use Cviebrock\EloquentSluggable\Sluggable;


class News extends Model
{
    use Sluggable;

    public function sluggable() {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected $fillable = [
         'title', 'preview', 'text'
    ];

    protected $appends = [
         'raw_date',
    ];

    public function user(){
        return $this->belongsTo('App\User',  'autor' );
    }

    public function getRawDateAttribute()
    {
        $d=date('d.m.Y', $this->datetime);
        $date=Date::parse($d)->format('d F Y');
        return $date;
    }

    public function logs(){
        return $this->hasMany('App\Models\History', 'object_id');
    }
    public function files(){
        return $this->hasMany('App\Models\File');
    }

}
