<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //
    protected $fillable = ['name'];

    public function headmanUser()
    {
       return $this->hasOne('App\User','id','headman');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

}
