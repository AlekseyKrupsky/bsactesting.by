<?php

namespace App\Http\Controllers\Admin;

use App\Model\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;

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

    public function reset()
    {
        return view('reset');
    }


    public function search(Request $request)
    {
       $users =  User::where('name','like','%'.$request->name.'%')->
        where('email','like','%'.$request->email.'%')
           ->select('name','email')
           ->get();

        return $users;
    }


    public function updatePassword(Request $request)
    {

//        return $request->pass;

        $this->validate($request, [
            'id'=>'required',
            'pass'=>'required|min:6'
        ]);



        $user = User::find($request->id);
        $user->password = Hash::make($request->pass);
        $user->save();
        return response()->json(['message'=>'Пароль успешно изменен'],200);
//        return response()->json(['message'=>'asd'],422);

//        $request->validate([
//
//        ]);
//
//        return 123;

    }
}
