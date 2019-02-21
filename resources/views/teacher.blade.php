@extends('layouts.app')

@section('content')

    <div class="container">
        <h3>Список преподавателей:</h3>
        @forelse($teachers->where('role','teacher') as $teacher)
                <div class="row">
                    <div class="col-6">
                        {{$loop->index+1}}.  {{$teacher->name}} <br>

                        @forelse($teacher->subjects as $subject)
                            {{$subject->name}}
                        @empty
                            Нет привязанных предметов
                            @endforelse
                        <form action="{{route('teachers',$teacher->id)}}" method="post">
                            {{csrf_field()}}
                            {{method_field('patch')}}
                            <input type="hidden" name="role" value="unsign_teacher">
                            <input class="btn btn-primary" type="submit" value="Деактивировать">
                        </form>
                            <div>
                                <form action="{{route('teacher_update',$teacher->id)}}" method="post">
                                    {{csrf_field()}}
                                    {{method_field('patch')}}
                                    <div class="col-md-6">
                                        <h4>Привязать предметы</h4>
                                        <select name="subjects_connect[]" id="" multiple class="form-control">
                                            @foreach($teacher->notAttachedSubjects() as $subject)
                                                <option value="{{$subject->id}}">{{$subject->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Отвязать предметы</h4>
                                        <select name="subjects_disconnect[]" id="" multiple class="form-control">
                                            @foreach($teacher->subjects as $subject)
                                                <option value="{{$subject->id}}">{{$subject->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input class="btn btn-primary" type="submit" value="Обновить">
                                </form>
                            </div>
                    </div>
                </div>
            @empty
            <p>Список пуст</p>
        @endforelse
    </div>



@endsection