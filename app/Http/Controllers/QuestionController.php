<?php

namespace App\Http\Controllers;

use App\Model\Answer;
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

        $question = Question::where('questions.id',$id)
        ->join('tests','questions.test_id','=','tests.id')
            ->select('questions.id as id','text','cost','name','mark_system','test_id')
            ->first(); //join test


        if($question->images()->get()->count())
        $question_images = '/'.$question->images()->get()->first()->path;
        else $question_images = '';

        $answers = $question->answers()->select('correct','id','text')->get();

        $answer_images = Image::whereIn('model_id',$answers->pluck('id')->toArray())
            ->where('model','answer')->get();

        foreach ($answers as $answer) {
            if($answer_images->where('model_id',$answer->id)->count())
            $answer->path =  '/'.$answer_images->where('model_id',$answer->id)->first()->path;
            else $answer->path = '';
        }

        $answers=$answers->toJson();

        return view('questions.edit_vue',[
            'question'=>$question,
            'question_images'=>$question_images,
            'answers'=>$answers,
        ]);
    }

    public function update(QuestionValidate $request, $id)
    {


        $question = Question::find($id);
        $question->update([
            'text'=>$request->question,
            'cost'=>$request->cost,
        ]);
        $question->save();

        if(!$request->path || ($request->path && !empty($request->image))) {
            $images_q = Question::find($id)->images()->get();
            $paths = $images_q->pluck('path')->toArray();
            $paths_id = $images_q->pluck('id')->toArray();
            Image::destroy($paths_id);
            File::delete($paths);
        }

        if($request->path && !empty($request->image)) {
            $name = Helper::filename($request->image,'img/questions/');
            $question->addImage($name);
        }

        $new_answers = [];
        $old_answers = [];
        foreach ($request->answer as $key => $item) {
            if($item['new'])
            $new_answers[] = $item;
            else $old_answers[$key] = $item;
        }


        $question->updateAnswers($old_answers);
        
        $question->addAnswer($new_answers);

        return response()->json('Вопрос обновлен',200);

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
