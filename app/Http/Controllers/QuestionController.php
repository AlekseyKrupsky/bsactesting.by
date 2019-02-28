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
        $question = Question::find($quest_id);
        $question->addAnswer($request->except(['name','rightAnswer','_token','cost','image']),$request->rightAnswer);

//        dump($request->all());
        if($request->image)
        {
            $image = time().'_'.uniqid().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('img/questions'), $image);
            $question->addImage('img/questions/'.$image);
        }


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
