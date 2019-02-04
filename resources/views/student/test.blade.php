@extends('layouts.app')

@section('content')

    <div class="container">
        <form action="{{route('show_test',$test->id)}}" method="post">
            {{csrf_field()}}
            <div class="row">
                <h2>Тест по теме "{{$test->name}}"</h2>
                <div class="alert alert-warning">
                    <ul>
                        <li>На время выполнения теста дается {{$test->time}} минут</li>
                        @if($test->mark_system=='simple')<li>Тест включает {{$test->quest_number}} случайных вопросов</li>@else
                            <li>Тест включает {{$questions->count()}} случайных вопросов различной сложности</li>
                        @endif
                    </ul>
                </div>
                <input type="hidden" name="stdans" value="{{base64_encode($stdans_id)}}">
                <input type="hidden" name="test" value="{{$test->id}}">
                @foreach($questions as $question)

                    <div class="form-group">
                        <h3>{{$question->text}}</h3>

                        @foreach($question->answers->shuffle() as $answer)
                            <div class="col-md-12">
                                <input type="checkbox" id="a{{$answer->id}}" name="{{md5($question->id)}}[]" class="check" value="{{$answer->id}}">
                                <label for="a{{$answer->id}}" class="alert alert-danger test-answer">
                                    {{$answer->text}}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endforeach
                <div class="form-group">
                    <div class="col-md-6">
                        <input type="submit" class="btn btn-success complete-test" value="Отправить на проверку">
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection