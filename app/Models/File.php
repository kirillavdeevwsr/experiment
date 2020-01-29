<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable= [
        'alt', 'link', 'type'
    ];

//    public function news(){}


//    const TYPE_VIDEO =2;
//    const TYPE_DOCUMENT = 3;
//
//    protected $appends = [
//        'type_text'
//    ];
//
//    public function getTypeTextAttribute() {
//        switch ($this->type) {
//            case self::TYPE_IMAGE:
//                $type = 'Изображение';
//                break;
//            case self::TYPE_VIDEO:
//                $type = 'Видеозапись';
//                break;
//            case self::TYPE_DOCUMENT:
//                $type = 'Документ';
//                break;
//        }
//        return $type;
//    }
}
