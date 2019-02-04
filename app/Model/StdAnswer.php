<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StdAnswer extends Model
{
    //
    protected $table = 'student_answers';

    protected $fillable = ['test_id','answer','mark'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
