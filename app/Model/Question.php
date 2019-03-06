<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Image;
use App\Helpers\Helper;

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

    public function addAnswer($answers)
    {
        foreach ($answers as $answer) {
            if($answer['correct']==1) {
              $answer_model = $this->answers()->create(['text'=>$answer['ans'],'correct'=>true]);
            }
           else $answer_model = $this->answers()->create(['text'=>$answer['ans'],'correct'=>false]);

            if($answer['file'])
            {
                $name = Helper::filename($answer['file'],'img/answers/');
                $answer_model->addImage($name);
            }

//            $answer->addImage()
        }
    }

    public function images()
    {
        return Image::where('model','question')->where('model_id',$this->id);
    }

    public function addImage($path)
    {

        Image::create(['path'=>$path,'model'=>'question','model_id'=>$this->id]);
    }

}
