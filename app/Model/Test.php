<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Test extends Model
{
    //

    protected $fillable = ['name','time','quest_number','subject_id','mark_system'];


    public function questions()
    {
        return $this->hasMany('App\Model\Question');
    }

    public function addQuestion($text,$cost)
    {
        $quest = $this->questions()->create(['text'=>$text,'cost'=>$cost]);
        return $quest->id;
    }

    public function stdanswers()
    {
        return $this->hasMany('App\Model\StdAnswer');
    }

    public function isComplete(User $user)
    {
        //dump($this->stdanswers->where('mark','')->where('user_id',$user->id));
        if(!$this->stdanswers->where('user_id',$user->id)->count()) {
            return 1;//'Пройти';
        }

        else if($this->stdanswers->where('mark','')->where('user_id',$user->id)->count()) {

            return 0;//'Продолжить';

        }

        else if(!$this->stdanswers->where('mark','')->where('user_id',$user->id)->count()){
            return -1;//'Сдан';
        }
    }


    public function subject()
    {
        return $this->belongsTo('App\Model\Subject');
    }

    public function mark_system()
    {
        return $this->hasOne('App\Model\Mark_system');
    }

    public function add_mark_system($question_info,$mark_info)
    {
        $relation = $this->mark_system();
        if($relation->exists())
            $relation->update(['question_info'=>$question_info,'mark_info'=>$mark_info]);
        else $relation->create(['question_info'=>$question_info,'mark_info'=>$mark_info]);
    }
}
