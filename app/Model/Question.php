<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $fillable = ['text','cost'];

    public function answers()
    {
        return $this->hasMany('App\Model\Answer');
    }

    public function correct()
    {
        return $this->answers->where('correct',1);
    }

    public function isNotCorrect($ids)
    {
       if($this->answers->where('correct',0)->whereIn('id',$ids)->count())  return true;
           return false;
    }

    public function test()
    {
        return $this->belongsTo('App\Model\Test');
    }

    public function addAnswer($answers,$right)
    {
        foreach ($answers as $key => $value) {
            if(in_array($key,$right)) {
                $this->answers()->create(['text'=>$value,'correct'=>true]);
            }
           else $this->answers()->create(['text'=>$value,'correct'=>false]);

        }
    }

    public function images()
    {
        return $this->hasMany('App\Model\Image');
    }

    public function addImage($path)
    {
        $this->images()->create(['path'=>$path]);
    }

}
