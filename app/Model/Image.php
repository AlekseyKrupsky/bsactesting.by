<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //
    protected $fillable = ['path'];
    protected $table = 'question_images';
    public function question()
    {
        return $this->belongsTo('App\Model\Question');
    }
}
