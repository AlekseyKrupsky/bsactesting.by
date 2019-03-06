<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //
    protected $fillable = ['path','model','model_id'];
    protected $table = 'question_images';
}
