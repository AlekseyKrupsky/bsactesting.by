@extends('layouts.app')

@section('content')
    <div class="container">

        @if($tests->count())
        <div class="row">
            <div class="col-md-12">
        <h2>Список всех тестов</h2>
            </div>
        </div>
            @foreach($tests as $test)
                <div class="row">
                    <div class="col-md-8">
                    {{$test->name}}
                    </div>
                    <div class="col-md-4">
                        @if($test->isComplete==1)
                        <a class="btn btn-primary" href="{{route('show_test',$test->id)}}">Пройти</a>
                        @endif
                        @if($test->isComplete==0)
                        <a class="btn btn-primary" href="{{route('show_test',$test->id)}}">Продолжить</a>
                        @endif
                        @if($test->isComplete==-1)
                        <a class="btn btn-primary" href="{{route('show_test',$test->id)}}">Результат</a>
                        @endif
                        @if($test->isComplete==-2)
                            <a class="btn btn-primary" href="" disabled>Результат не отправлен</a>
                        @endif
                    </div>
                </div>
            @endforeach
            @else
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">Доступных тестов нет</h2>
                </div>
            </div>
        @endif

    </div>
@endsection