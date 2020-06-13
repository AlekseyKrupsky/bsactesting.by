@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Доступ к этой странице ограничен. Вернутся на <a href="{{route('home')}}">главную</a></h3>
        @if(!empty($message))
            <p>{{$message}}</p>
            @endif
    </div>
@endsection