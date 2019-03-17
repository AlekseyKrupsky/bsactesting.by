@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <form action="{{route('subjects')}}" method="post">
                {{csrf_field()}}
                <input type="text" name="name" placeholder="Математика" required>
                <input class="btn btn-primary"  type="submit" value="Добавить предмет">
            </form>
        </div>

        @include('validerror')

        @foreach($errors->all() as $error)
            {{$error}}
        @endforeach
        <h3>Список предметов:</h3>
        @forelse($subjects as $subject)
            <div class="row d-flex flex-row">

                <div class="col-6">

                    <form action="{{route('delete_subject',$subject->id)}}" method="post">
                        {{csrf_field()}}
                        {{method_field('delete')}}
                        {{$loop->index+1}}.  {{$subject->name}}
                        <input class="btn btn-danger" type="submit" value="Удалить">
                    </form>
                </div>
            </div>
        @empty
            <h4>Список предметов пуст</h4>
        @endforelse
    </div>



@endsection