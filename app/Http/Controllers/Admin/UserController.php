<?php

namespace App\Http\Controllers\Admin;

use App\Model\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //

    public function new_users()
    {

        $groups = Group::all();
        if(Auth::user()->role == 'teacher') {
            $users = User::whereIn('role',['unsign_student'])->get();
        }
        if(Auth::user()->role == 'admin') {
            $users = User::whereIn('role', ['unsign_student', 'unsign_teacher'])->get();
        }
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
       $users =  User::select('name','email','id','deleted_at')->get();

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

    }

    public function deleteUser(Request $request)
    {
        $user = User::find($request->id);
        if($user) {
            $user->deleted_at = new \DateTime();
            $user->save();

            return response()->json(['message'=>'User has been safe deleted'],200);
        }
        return response()->json(['message'=>'User does not exist'],404);

    }

    public function deletePermanentUser(User $user)
    {

        if($user) {

            $user->delete();
            return response()->json(['message'=>'User has been deleted'],200);
        }
        return response()->json(['message'=>'User does not exist'],404);

    }



    public function restoreUser(Request $request)
    {

        $user = User::find($request->id);
        if($user) {
            $user->deleted_at = null;
            $user->save();

            return response()->json(['message'=>'User has been restored'],200);
        }
        return response()->json(['message'=>'User does not exist'],404);
    }
}
