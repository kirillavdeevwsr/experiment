<?php

namespace App\Service;


class FileStorage
{

    public function imageSave($image, $entity)
    {
        $type = $image->getClientMimeType();
        if ($this->checkTitleImage($type)) {
            $path =$image->store($entity);
            return ('/storage/'. $path);
        }else{
            return 0;
        }
    }

    public function checkTitleImage($image)
    {
        $search = preg_match('/^image\/[a-z]{3,}/', $image);
        return $search;
    }
}
