<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Group;
use App\User;
use App\Http\Requests\GroupValidation;

class GroupController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
        $groups = Group::all();
        $users = User::whereIn('group_id',$groups->pluck('id')->toArray())->orderBy('name')->get();
        return view('admin.group',['groups'=>$groups,'users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupValidation $request)
    {
        //

        $group = new Group();

        $group->name = $request->name;
        $group->save();

        return back()->with('message','Группа успешно добавлена');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request,[
            'name'=>'required|max:255|unique:groups,name,'.$id
        ],
            [
                'required'=>'Название группы обязательно к заполнению',
                'max'=>'Длина названия группы не должно превышать 255 символов',
                'unique'=>'Название группы должно быть уникальным',
            ]);

        Group::find($id)->update($request->all());
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $group = Group::find($id);

        $users = $group->users;

        foreach ($users as $user) {
            $user->deleteItem();
        }
        $name = $group->name;
        $group->delete();
//
        return back()->with('message','Группа '.$name.' была успешно удалена');
    }
}
