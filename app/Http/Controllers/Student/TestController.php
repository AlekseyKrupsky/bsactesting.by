<?php

namespace App\Http\Controllers\Student;

use App\Model\Question;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Test;
use App\Model\StdAnswer;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    //

    public function index()
    {
        $tests = Test::all();
        return view('student.tests',['tests'=>$tests]);
    }
    
    public function show($id)
    {

            //если тесты пройдены но попали на страницу тест ??

        $test = Test::find($id);

        $std_ans = Auth::user()->stdanswers->where('mark','')->where('test_id',$id);

        if(!$std_ans->count()) {
          // echo 1;
            if($test->mark_system=='simple') {
                $questions = $test->questions->random($test->quest_number);
//            dump($questions);
//            echo serialize($questions);
//            dump(unserialize(serialize($questions)));

            }
            else {
                $cost_info = unserialize($test->mark_system()->first()->question_info);
                $all_questions = $test->questions;
                $questions = collect();
                foreach ($cost_info as $cost=>$count) {
                    $questions= $questions->concat($all_questions->where('cost',$cost)->random($count));

                }

            }

            $std_ans = Auth::user()->addStdAnswer($id,serialize($questions));
            //dump($questions);

          // dump($std_ans->id);
            return view('student.test',['test'=>$test,'questions'=>$questions,'stdans_id'=>$std_ans->id,'time'=>$test->time*60]);
        }

        else {
            $std_ans = Auth::user()->stdanswers->where('mark','')->where('test_id',$id)->last();
           // dump($std_ans);
            $questions = unserialize($std_ans->answer);
            //dump($std_ans->id);
            $time = $test->time*60 - time() + $std_ans->created_at->timestamp;
            return view('student.test',['test'=>$test,'questions'=>$questions,'stdans_id'=>$std_ans->id,'time'=>$time]);
        }
        //dump(Auth::user()->stdanswers->where('mark','')->where('test_id',$id)->count());
        //return view('student.test',['test'=>$test,'questions'=>$questions]);
    }

    public function check(Request $request)
    {
       // dump($request->all());
        $test = Test::find($request->test);
        $qus = unserialize(StdAnswer::find(base64_decode($request->stdans))->answer);
        $total_mark = 0;
        $stdAns = [];
        foreach ($qus as $question) {
            //dump($item->id);
            $myans = $request->all()[md5($question->id)];
            //dump($myans);
            $uncorrect = $question->isNotCorrect($myans);
           // dump($uncorrect);
            $mark = 0;

            $stdAns[$question->id] = $myans;

            if(!$uncorrect) {
                $correctArray = $question->correct()->pluck('id')->toArray();
                $count = count($correctArray);
                $inter_count = count(array_intersect($myans,$correctArray));
                if($test->mark_system=='difficult')
                $mark = $inter_count/$count*$question->cost;
                else $mark = $inter_count/$count;
            }
            $total_mark+=$mark;
        }

        if($test->mark_system=='difficult') {
            $total_mark=round($total_mark);
            $mark_info = unserialize($test->mark_system()->first()->mark_info);
            $mark_end =0;
            foreach ($mark_info as $mark=>$cost) {
                if($total_mark>$cost) $mark_end=$mark+1;
            }
        }



        $stdAns = Auth::user()->stdanswers->where('mark','')->where('test_id',$request->test)->last();
        if($test->mark_system=='difficult')
            $stdAns->mark = $mark_end;
            else
        $stdAns->mark = round($total_mark/(Test::find($request->test)->quest_number)*10);
        $stdAns->answer=serialize($stdAns);
        $stdAns->save();
        return redirect(route('test_result',$request->test));
    }


    public function result($id)
    {
        $mark = Auth::user()->stdanswers->where('test_id',$id)->last()->mark;
        return view('student.result',['mark'=>$mark]);
    }


}
