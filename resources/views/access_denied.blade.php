@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Доступ к этой странице ограничен. Вернутся на <a href="{{route('home')}}">главную</a></h2>
        @if(!empty($message))
            <p>{{$message}}</p>
            @endif
    </div>
@endsection