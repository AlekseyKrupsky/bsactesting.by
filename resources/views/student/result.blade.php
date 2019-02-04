@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="test-result">
            <div class="wrap">
                <h2>Вы прошли тест. Ваша оценка:</h2>
                <div class="pie p{{$mark}}"><span>{{$mark}}</span></div>
            </div>
        </div>

    </div>
@endsection