@extends('layouts.app')

@section('content')

    <div class="container">
        <form action="" method="get">
            {{csrf_field()}}
            <div class="row">
                <div class="col-md-12">
                <h2>Страница преподавателя</h2>
                </div>
                <div class="col-md-6">
                <h3>Выберите предмет</h3>
                    <div class="form-group">
                @foreach($subjects as $subject)
                            <input type="radio" id="s{{$subject->id}}" name="subject" class="check" value="{{$subject->id}}" @if($loop->index==0) checked @endif>
                            <label for="s{{$subject->id}}" class="alert alert-danger test-answer">
                                {{$subject->name}}
                            </label>
                @endforeach
                    </div>
                </div>
                <div class="col-md-6">
                    <h3>Выберите группу</h3>

                        <select name="group" id=""  class="form-control">
                @foreach($groups as $group)
                                <option  class="form-control" value="{{$group->id}}">{{$group->name}}</option>
                @endforeach
                        </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-6">
                        <input type="submit" class="btn btn-success complete-test" value="Показать">
                    </div>
                </div>
            </div>
        </form>
        @if($group_show)
        <h3>Группа {{$group_show->name}}</h3>
        <table>
            <tr>
                <td>ФИО студента</td>
                @foreach($subject_show->tests as $test)
                    <td>
                    {{$test->name}}
                    </td>
                @endforeach
            </tr>

            @foreach($group_show->users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    @foreach($subject_show->tests as $test)
                        <td>
                            @if($user->stdanswers->where('test_id',$test->id)->last())
                            {{$user->stdanswers->where('test_id',$test->id)->last()->mark?
                            $user->stdanswers->where('test_id',$test->id)->last()->mark:
                            'Сдает'
                            }}
                                @endif
                        </td>
                    @endforeach
                </tr>

                @endforeach
        </table>
        @endif
    </div>
@endsection