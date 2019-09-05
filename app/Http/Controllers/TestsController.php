<?php

namespace App\Http\Controllers;

use App\Model\Answer;
use App\Model\Question;
use Illuminate\Http\Request;
use App\Model\Test;
use App\Model\Subject;
use Illuminate\Support\Facades\Auth;

class TestsController extends Controller
{
    //

    public function index()
    {
        if(Auth::user()->role=='admin') {
            $tests = Test::all();
            $subjects = Subject::all();
        }
        else {
            $subjects = Auth::user()->subjects;
            $ids = $subjects->pluck('id')->toArray();
            $tests= Test::whereIn('subject_id',$ids)->get();
        }
        return view('tests.all',['tests'=>$tests,'subjects'=>$subjects]);
    }

    public function store(Request $request)
    {
        $test = new Test($request->all());
        $test->save();
        return redirect(route('question_add',$test->id));
    }

    public function edit($id)
    {
        $test = Test::find($id);
        $subjects = Subject::all();
        //$questions = $test->questions()->leftJoin('answers','questions.id','=','answers.question_id')->get();
        $questions = $test->questions;
        $answers = Answer::whereIn('question_id',$questions->pluck('id')->toArray())->get();
        //dump($answers);
       // dump($answers->where('question_id',30)[0]);
        //dump($questions->pluck('cost')->toArray());
        //

        $quest_count = [];
        if($test->mark_system == 'difficult') {
            $quest_count = array_count_values($questions->pluck('cost')->toArray());
            ksort($quest_count);
        }


        $mark_system = $test->mark_system()->first();
        $maximum = 0;

        if(!empty($mark_system)) {
            $question_info = unserialize($mark_system->question_info);
            $mark_info = unserialize($mark_system->mark_info);
            foreach ($question_info as $cost=>$count) {
                $maximum += $cost*$count;
            }
        }
        else $question_info = $mark_info = null;


        //    dump($test->mark_system);

        return view('tests.edit',
         [
            'test'=>$test,
            'subjects'=>$subjects,
            'user'=>Auth::user(),
            'questions'=>$questions,
            'quest_count'=>$quest_count,
            'question_info'=>$question_info,
            'mark_info'=>$mark_info,
            'maximum'=>$maximum,
            'answers'=>$answers
        ]
        );
    }

    public function update(Request $request,$id)
    {

        $errors = [];
        $test = Test::find($id);
        if(Auth::user()->haveAccess($test)) {
            $test->update($request->all());
            if($test->questions->count()==0){
                $test->status='build';
                $errors[] = 'В тесте нет вопросов, он сохранен со статусом "Создание"';
            }

            elseif($test->questions->count()<$test->quest_number && $request->status=='ready'){
                $test->status='changing';
                $errors[] = 'Количество вопросов в тесте ('.$test->questions->count().') меньше заявленного ('.$test->quest_number.'), 
               не обходимо столько же или больше. Тест сохранен со статусом "Изменение"';
            }
            $test->save();

        }
        else $errors[] = 'Произошла ошибка. Материал не изменен';


        return back()->withErrors($errors);
    }

    public function update_mark_system(Request $request,$id)
    {
        $test = Test::find($id);
        if(Auth::user()->haveAccess($test)) {
            $test->add_mark_system(serialize($request->question_info),serialize($request->mark_info));
            return back();
        }
        else {
            $error = 'Произошла ошибка. Материал не изменен';
            return back()->withErrors([$error]);
        }

    }

    public function destroy($id)
    {
        $test = Test::find($id);
        if(Auth::user()->haveAccess($test)) {
            $test->deleteItem();
            return redirect(route('tests'));
        }
        else $error = 'Произошла ошибка. Материал не удален';
        return back()->withErrors([$error]);
    }
    
}
