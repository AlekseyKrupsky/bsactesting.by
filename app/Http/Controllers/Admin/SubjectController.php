<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Subject;
use Psy\Sudo;

class SubjectController extends Controller
{
    //

    public function index()
    {
        $subjects = Subject::all();
        return view('subject',['subjects'=>$subjects]);
    }

    public function store(Request $request)
    {
       Subject::create($request->all());
       return back();
    }

    public function destroy($id)
    {
        Subject::find($id)->delete();
        return back();
    }


}
