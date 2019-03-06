<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Test;
use App\Model\Question;
use App\Helpers\Helper;
use App\Model\Image;
use Illuminate\Support\Facades\File;
use App\Http\Requests\QuestionValidate;

class QuestionController extends Controller
{
    //
    public function create($id)
    {
        $test = Test::find($id);
//        return view('questions.new',['test'=>$test]);
        return view('questions.new_vue',['test'=>$test]);
    }

    public function store(QuestionValidate $request, $id)
    {

        $quest_id = Test::find($id)->addQuestion($request->question,$request->cost);
        $question = Question::find($quest_id);

        $question->addAnswer($request->answer);

        if($request->image)
        {
            $name = Helper::filename($request->image,'img/questions/');
            $question->addImage($name);
        }

        return response()->json('Вопрос добавлен',200);
    }

    public function edit($id)
    {
        $question = Question::find($id);
       // dump($question->test->name);
//        return view('questions.edit',['question'=>$question]);
        return view('questions.edit_vue',['question'=>$question]);
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

        $images_q = Question::find($id)->images()->get();
        $paths = $images_q->pluck('path')->toArray();


        $answers = Question::find($id)->answers->pluck('id')->toArray();

        $images_a = Image::where('model','answer')->whereIn('model_id',$answers)->get();
        $paths = array_merge($paths,$images_a->pluck('path')->toArray());

        $paths_id = $images_q->pluck('id')->toArray();
        $paths_id = array_merge($paths_id,$images_a->pluck('id')->toArray());

        Image::destroy($paths_id);

        $status = File::delete($paths);

        Question::destroy($id);
        return back();
    }

}
