<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Subject;
use Psy\Sudo;
use App\Http\Requests\SubjectValidation;

class SubjectController extends Controller
{
    //

    public function index()
    {
        $subjects = Subject::all();
        return view('admin.subject',['subjects'=>$subjects]);
    }

    public function store(SubjectValidation $request)
    {

       Subject::create($request->all());
       return back()->with('message','Новый предмет успешно добавлен');
    }

    public function destroy($id)
    {
        $subject = Subject::find($id);
        $name = $subject->name;
        $subject->deleteItem();
        return back()->with('message','Предмет \''.$name.'\' был успешно удален');
    }


}
