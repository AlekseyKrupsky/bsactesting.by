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

    public static function marks($user,$test_id)
    {
        $marks_array = $user->stdanswers->where('test_id',$test_id)->pluck('mark')->toArray();

        for($i=0; $i< count($marks_array);$i++) {
            if(!$marks_array[$i]) $marks_array[$i] = 'результат не отправлен';
        }

        $result = implode(', ',$marks_array);
        return $result;
    }

}