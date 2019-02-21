@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="test-result">
            <div class="wrap">
                <h2>Вы прошли тест. Ваша оценка:</h2>
                <div class="pie p{{$mark}}"><span>{{$mark}}</span></div>
            </div>


            <a class="btn btn-info" href="{{route('show_tests')}}">К тестам</a>
            <a class="btn btn-info" href="{{route('home')}}">На главную</a>
        </div>

    </div>
@endsection