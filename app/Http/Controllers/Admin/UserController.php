<?php

namespace App\Http\Controllers\Admin;

use App\Model\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;

class UserController extends Controller
{
    //

    public function new_users()
    {
        $groups = Group::all();
        $users = User::whereIn('role',['unsign_student','unsign_teacher'])->get();
        return view('new_users',['users'=>$users,'groups'=>$groups]);
    }

    public function update(Request $request,$id)
    {
//        dump($request->role);

        $user = User::find($id);
        $user->role = $request->role;
        $user->save();
//        ->update(['role'=>]);
        return back();
    }

    public function delete($id)
    {
        User::find($id)->delete();
        return back();
    }
    
}
