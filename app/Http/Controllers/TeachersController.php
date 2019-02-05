<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Group;
use App\Model\Subject;

class TeachersController extends Controller
{
    //

    public function index(Request $request)
    {
        if(Auth::user()->role=='teacher'){
            $subjects = Auth::user()->subjects;
        }
        elseif(Auth::user()->role=='admin')
            $subjects = Subject::all();
        $groups = Group::all();
        return view('teacher.dash',['subjects'=>$subjects,'groups'=>$groups,
            'group_show'=>Group::find($request->group),'subject_show'=>Subject::find($request->subject)]);
    }
}
