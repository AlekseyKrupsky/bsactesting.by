<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    //

    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function tests()
    {
        return $this->hasMany('App\Model\Test');
    }

}
