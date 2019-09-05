<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Model\Subject;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role','group_id','deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function stdanswers()
    {
        return $this->hasMany('App\Model\StdAnswer');
    }

    public function addStdAnswer($test_id,$answ)
    {
       return $this->stdanswers()->create(['test_id'=>$test_id,'answer'=>$answ]);
    }

    public function subjects()
    {
        return $this->belongsToMany('App\Model\Subject','subject_user');
    }

    public function notAttachedSubjects()
    {
        $array = $this->subjects->pluck('id')->toArray();
        return Subject::all()->except($array);
    }

    public function connectSubject($sub_ids)
    {
        if(!empty($sub_ids)) $this->subjects()->syncWithoutDetaching($sub_ids);
    }

    public function disconnectSubject($sub_ids)
    {
        if(!empty($sub_ids)) $this->subjects()->detach($sub_ids);
    }

    public function haveAccess($test)
    {
        if(in_array($test->subject_id,$this->subjects->pluck('id')->toArray()) || $this->role=='admin') {
            return 1;
        }
        return 0;
    }

    public function group()
    {
        return $this->hasOne('App\Model\Group');
    }

    public function retakes()
    {
        return $this->hasMany('App\Model\UserRetake');
    }

    public function addRetake($test_id)
    {
        $this->retakes()->create(['test_id'=>$test_id]);
    }

    public function deleteItem()
    {
        $this->stdanswers()->delete();
        $this->retakes()->delete();
        $this->delete();
    }

}
