@extends('layouts.app')

@section('content')

    <div class="container">

        <form action="{{route('question_edit',$question->id)}}" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12">
                    <h3>Обновить вопрос для теста "{{$question->test->name}}"</h3>
                </div>
                {{method_field('patch')}}
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name" class="col-md-4 control-label">Вопрос</label>
                    <div class="col-md-8">
                        <textarea  class="form-control" name="name" required>{{$question->text}}</textarea>
                    </div>
                </div>
                @if($question->test->mark_system=='difficult')
                    <div class="form-group">
                        <label for="cost" class="col-md-4 control-label">Баллов за ответ</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="cost" id="cost" value="{{$question->cost}}" required>
                        </div>
                    </div>
                @endif
                <div class="form-group">
                    <label for="image" class="col-md-4 control-label">Изображение</label>
                    <div class="col-md-8">
                        <input type="file" name="image" id="file">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3>Варианты ответов</h3>
                </div>
            </div>
            <div class="row answers d-flex flex-column">
                @foreach($question->answers as $answer)
                <div class="form-group answer">
                    <div class="col-md-4">

                        <input type="checkbox" id="right-a{{$loop->index+1}}" class="check"
                               name="rightAnswer[]" value="a{{$loop->index+1}}" @if($answer->correct) checked @endif>
                        <label for="right-a{{$loop->index+1}}" class="control-label btn btn-danger">
                            Это правильный ответ
                        </label>
                        <label for="a{{$loop->index+1}}" class="control-label">
                            @if($loop->index>1)
                            <button class="btn btn-danger delete-answer" >Удалить</button>
                                @endif
                                Текст ответа:
                        </label>
                    </div>

                    <div class="col-md-8">
                        <textarea required class="form-control" name="a{{$loop->index+1}}">{{$answer->text}}</textarea>
                    </div>
                </div>
                    @endforeach
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-6">
                    <button class="add-answer btn btn-info">Добавить ответ</button>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-6">
                        <input type="submit" class="btn btn-success" value="Обновить вопрос">
                        <a class="btn btn-success" href="{{route('tests_edit',$question->test->id)}}">Настройки теста</a>

                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection