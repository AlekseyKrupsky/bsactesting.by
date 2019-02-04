@extends('layouts.app')

@section('content')

    <div class="container">
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
                    @if($test->isComplete(\Illuminate\Support\Facades\Auth::user())==1)
                    <a class="btn btn-primary" href="{{route('show_test',$test->id)}}">Пройти</a>
                        @endif
                        @if($test->isComplete(\Illuminate\Support\Facades\Auth::user())==0)
                            <a class="btn btn-primary" href="{{route('show_test',$test->id)}}">Продолжить</a>

                        @endif @if($test->isComplete(\Illuminate\Support\Facades\Auth::user())==-1)
                            <a class="btn btn-primary" href="{{route('test_result',$test->id)}}">Результат</a>
                        @endif

                </div>
            </div>
        @endforeach
    </div>
@endsection