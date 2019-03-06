<?php

namespace App\Helpers;

class Helper
{
    public static function filename($file,$path='')
    {
        $name = time().'_'.uniqid().'_'.$file->getClientOriginalName();
        $file->move(public_path($path), $name);
        return $path.$name;
    }


}