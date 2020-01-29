<?php

namespace App\Models;

use App\Events\DeleteBannersEvent;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'url', 'alt', 'sort'
    ];

    protected $appends  = [
        'text_sort'
    ];

    public function getTextSortAttributes(){
        $place_banner=[
            0=>'Центр страницы',
            1=>'Низ страницы'
        ];
        return $place_banner[$this->sort];
    }

}
