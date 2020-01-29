<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'history';

    protected $appends =[
        'raw_date',
    ];

    public function getRawDateAttribute(){

        return date('d.m.Y', $this->datetime);
    }

    protected $types=[
        'news' => 'App\Models\News',
        'pages' => 'App\Models\Page',
        'banners' => 'App\Models\Banner',
        'courses' => 'App\Models\Course',
        'events' => 'App\Models\Events',
    ];

    public function object(){
        return $this->belongsTo($this->types[$this->object_type], 'object_id');
    }

    public function getUser(){
        return $this->belongsTo("App\User", 'user');
    }

//    public function object(){
//        if($this->object_type == 'news'){
//            return $this->news();
//        }
//        elseif ($this->object_type == 'pages'){
//            return $this->page();
//        }
//        elseif($this->object_type == 'banners'){
//            return $this->banner();
//        }
//    }
//
//    public function news(){
//        return $this->belongsTo('App\Models\News', 'object_id', 'id');
//    }
//
//    protected function banner(){
//        return $this->belongsTo('App\Models\Banner', 'object_id');
//    }
//
//    protected function page(){
//        return $this->belongsTo('App\Models\Page', 'object_id');
//    }
}

