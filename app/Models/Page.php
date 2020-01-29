<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Page extends Model
{
    use Sluggable;

    public function sluggable() {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected $fillable=[
        'title', 'text', 'status', 'parent', 'sort'
    ];

    public function getParent(){
        return $this->belongsTo('App\Models\Page', 'parent','id');
    }

    public function children(){
        return $this->hasMany('App\Models\Page', 'parent' );
    }

    public function getStatus(){
        return $this->belongsTo('App\Models\Status','status' );
    }
}
