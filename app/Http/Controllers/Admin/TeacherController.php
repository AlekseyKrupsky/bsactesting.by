<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\Subject;

class TeacherController extends Controller
{
    //

    public function index()
    {
        $subjects = Subject::all();
        $teachers = User::where('role','unsign_teacher')->orWhere('role','teacher')->get();

        return view('teacher',['teachers'=>$teachers,'subjects'=>$subjects]);
    }

    public function update(Request $request,$id)
    {
        $subjects_connect = $request->subjects_connect;
        $subjects_disconnect = $request->subjects_disconnect;
       // dump($subjects_connect);
       // dump($subjects_disconnect);
        $teacher = User::find($id);
        $teacher->connectSubject($subjects_connect);
        $teacher->disconnectSubject($subjects_disconnect);



       // dump($request->all());
        //$teacher->update($request->all());
        return back();
    }
}
