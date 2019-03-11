<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Image;
use App\Helpers\Helper;
use File;

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
              $answer_model = $this->answers()->create(['text'=>$answer['text'],'correct'=>true]);
            }
           else $answer_model = $this->answers()->create(['text'=>$answer['text'],'correct'=>false]);

            if($answer['file'])
            {
                $name = Helper::filename($answer['file'],'img/answers/');
                $answer_model->addImage($name);
            }

        }
    }

    public function updateAnswers($answers)
    {
        $keys = array_keys($answers);

        $answer_delete_images = [];
        $old_keys = $this->answers()->whereNotIn('id',$keys)->pluck('id')->toArray();
        $answer_delete_images = array_merge($answer_delete_images,$old_keys);
        Answer::destroy($old_keys);


        foreach ($answers as $key=>$answer) {
            $answer_model = Answer::find($key);
            $answer_model->update([
                'text'=>$answer['text'],
                'correct'=>$answer['correct']
            ]);
            if(!$answer['path'] || ($answer['path'] && !empty($answer['file']))) {
                $answer_delete_images[] = $key;
            }
        }


        $images_a = Image::where('model','answer')
            ->whereIn('model_id',$answer_delete_images)->get();
        $paths = $images_a->pluck('path')->toArray();
        $paths_id = $images_a->pluck('id')->toArray();

        Image::destroy($paths_id);
        File::delete($paths);


        foreach ($answers as $key=>$answer) {

            if($answer['path'] && !empty($answer['file'])) {
                $name = Helper::filename($answer['file'],'img/answers/');

                Answer::find($key)->addImage($name);
            }

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
