@extends('layouts.app')

@section('content')



    <div class="container">
        @include('validerror')
        @include('message')

        <div class="row">
            <form action="{{route('subjects')}}" method="post" class="col-md-12" >
                {{csrf_field()}}
                <input type="text" name="name" placeholder="Математика" required>
                <input class="btn btn-primary"  type="submit" value="Добавить предмет">
            </form>
        </div>



        @foreach($errors->all() as $error)
            {{$error}}
        @endforeach
        <h3>Список предметов:</h3>
        @forelse($subjects as $subject)
            <div class="row d-flex flex-row mb-5">
                    <form action="{{route('delete_subject',$subject->id)}}" method="post">
                        {{csrf_field()}}
                        {{method_field('delete')}}
                        <div class="col-md-4">
                        {{$loop->index+1}}.  {{$subject->name}}
                        </div>
                        <div class="col-md-auto">
                        <input class="btn btn-danger" type="submit" value="Удалить">
                        </div>
                    </form>
            </div>
        @empty
            <h4>Список предметов пуст</h4>
        @endforelse
    </div>



@endsection