<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Test;
use App\Model\Question;


class QuestionController extends Controller
{
    //
    public function create($id)
    {
        $test = Test::find($id);
        return view('questions.new',['test'=>$test]);
    }

    public function store(Request $request, $id)
    {
       $quest_id = Test::find($id)->addQuestion($request->name,$request->cost);
        Question::find($quest_id)->addAnswer($request->except(['name','rightAnswer','_token','cost']),$request->rightAnswer);
//        dump($request->rightAnswer);
        return back();
    }

    public function edit($id)
    {
        $question = Question::find($id);
       // dump($question->test->name);
        return view('questions.edit',['question'=>$question]);
    }

    public function update(Request $request, $id)
    {

        Question::find($id)->update(['text'=>$request->name,'cost'=>$request->cost]);
        Question::find($id)->answers()->delete();
        Question::find($id)->addAnswer($request->except(['name','rightAnswer','_token','_method','cost']),$request->rightAnswer);
        return back();
        //dump($request);
    }

    public function destroy($id)
    {
        Question::destroy($id);
        return back();
    }

}
