@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{route('tests_new')}}" method="post">
            <div class="row">
                <div class="col-md-12">
                    <h3>Добавить новый тест</h3>
                </div>
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name" class="col-md-4 control-label">Название</label>
                    <div class="col-md-6">
                        <input  type="text" class="form-control" name="name"  required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="quest_number" class="col-md-4 control-label">Количество вопросов</label>
                    <div class="col-md-6">
                        <input  type="number" class="form-control" name="quest_number"required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="time" class="col-md-4 control-label">Время выполнения (минут)</label>
                    <div class="col-md-6">
                        <input  type="number" class="form-control" name="time" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="subject" class="col-md-4 control-label">Предмет</label>
                    <div class="col-md-6">
                        <select name="subject_id" id="subject" class="form-control">
                            @foreach($subjects as $subject)
                            <option value="{{$subject->id}}">{{$subject->name}}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="mark_system" class="col-md-4 control-label">Система оценивания</label>
                    <div class="col-md-6">
                        <select name="mark_system" id="mark_system" class="form-control">
                            <option value="simple">Простая</option>
                            <option value="difficult">Сложная</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <input type="submit" class="btn btn-success" value="Добавить тест">
                    </div>
                </div>
            </div>
        </form>
        <h3>Список тестов:</h3>
        @forelse($tests as $test)
            <div class="row">
                <div class="col-6 buttons">
                    {{$loop->index+1}}.  {{$test->name}} ({{$test->subject->name}}) <a class="btn btn-primary" href="{{route('tests_edit',$test->id)}}">Редактировать</a>
                    <a class="btn btn-primary" href="{{route('question_add',$test->id)}}">Добавить вопрос</a>
                    <form class="delete" action="{{route('test_delete',$test->id)}}" method="post">
                        {{csrf_field()}}
                        {{method_field('delete')}}
                        <button class="btn btn-danger">Удалить</button></form>
                </div>
            </div>
        @empty
            <p>Список пуст</p>
        @endforelse
    </div>



@endsection