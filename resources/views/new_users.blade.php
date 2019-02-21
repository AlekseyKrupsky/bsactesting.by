@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @if($users->count())
            <h2>Таблица новых пользователей</h2>
            <table>
            @foreach($users as $user)
               <tr>
                   <td>
                    @if($user->role=='unsign_teacher')
                        Преподаватель
                        @elseif($user->role=='unsign_student')
                        Студент
                    @endif
                   </td>
                   <td>
                    {{$user->name}}
                   </td>
                   <td>
                @if($user->role=='unsign_student')
                    @if($user->group_id)
                        Группа {{$groups->where('id',$user->group_id)->first()->name}}
                    @else
                        Группа не определена
                    @endif
                @endif
                   </td>
                   <td>
                       <form action="{{route('new_users_update',$user->id)}}" method="post">
                           {{csrf_field()}}
                           {{method_field('patch')}}
                           @if($user->role=='unsign_teacher')
                               <input type="hidden" name="role" value="teacher">
                           @elseif($user->role=='unsign_student')
                               <input type="hidden" name="role" value="student">
                           @endif
                           <input class="btn btn-primary" type="submit" value="Активировать">
                       </form>
                   </td>
                   <td>
                       <form action="{{route('new_users_delete',$user->id)}}" method="post">
                           {{csrf_field()}}
                           {{method_field('delete')}}
                           <input class="btn btn-primary" type="submit" value="Удалить">
                       </form>
                   </td>
               </tr>
            @endforeach
            </table>
                @else
                <h3 class="text-center">Новых пользователей нет</h3>
            @endif
        </div>
    </div>
@endsection