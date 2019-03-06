<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //
    protected $fillable = ['text','correct'];

    public function images()
    {
        return Image::where('model','answer')->where('model_id',$this->id);
    }

    public function addImage($path)
    {
        Image::create(['path'=>$path,'model'=>'answer','model_id'=>$this->id]);
    }

}
