@extends('layouts.app')

@section('content')

    <div class="container">

        <form action="{{route('question_add',$test->id)}}" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12">
                    <h3>Добавить новый вопрос для теста "{{$test->name}}"</h3>
                </div>
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name" class="col-md-4 control-label">Вопрос</label>
                    <div class="col-md-8">
                        <textarea  class="form-control" name="name"  required></textarea>
                    </div>
                </div>
                @if($test->mark_system=='difficult')
                <div class="form-group">
                    <label for="cost" class="col-md-4 control-label">Баллов за ответ</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="cost" id="cost" required>
                    </div>
                </div>
                @else
                    <input type="hidden" class="form-control" value="0" name="cost" id="cost" required>
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
                <div class="form-group answer">
                    <div class="col-md-4">

                        <input type="checkbox" id="right-a1" class="check" name="rightAnswer[]" value="a1" checked>
                        <label for="right-a1" class="control-label btn btn-danger">
                           Это правильный ответ
                        </label>
                        <label for="a1" class="control-label">
                             Текст ответа:
                        </label>
                    </div>

                        <div class="col-md-8">
                            <textarea required class="form-control" name="a1"></textarea>
                        </div>
                    </div>

                <div class="form-group answer">
                    <div class="col-md-4">
                        <input type="checkbox" id="right-a2" class="check" name="rightAnswer[]" value="a2">
                        <label for="right-a2" class="control-label btn btn-danger">
                            Это правильный ответ
                        </label>
                        <label for="a2" class="control-label">
                            Текст ответа:
                        </label>
                    </div>
                    <div class="col-md-8">
                        <textarea required class="form-control" name="a2"></textarea>
                    </div>
                </div>

            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-6">
                    <button class="add-answer btn btn-info">Добавить ответ</button>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <div class="col-md-6">
                        <input type="submit" class="btn btn-success" value="Добавить вопрос">
                        <a class="btn btn-success" href="{{route('tests_edit',$test->id)}}">Настройки теста</a>

                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection