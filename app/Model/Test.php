<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Test extends Model
{
    //

    protected $fillable = ['name','time','quest_number','subject_id','mark_system','status'];


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

    public function isComplete($user_id = '')
    {

        $user_id?true:$user_id=\Auth::user()->id;

            $this->stdanswers()->where('user_id',$user_id);


        $marks = range(0,10);


        if(!$this->stdanswers()->where('user_id',$user_id)->get()->count()) {
            return 1;//'Пройти'; //Пусто
        }

        else if($this->stdanswers()->where('user_id',$user_id)->whereNull('mark')->get()->count()
            && time()-$this->stdanswers()->where('user_id',$user_id)->get()->last()->created_at->timestamp>$this->time*60) {

            return -2;// Не отправил результат
        }

        else if($this->stdanswers()->where('user_id',$user_id)->whereNull('mark')->get()->last()) {
            return 0;//'Продолжить'; //Сдает

        }

        else if($this->stdanswers->whereIn('mark',$marks)->where('user_id',$user_id)->count()){
            return -1;//'Сдан'; //Оценка
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
