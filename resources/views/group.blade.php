@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <form action="{{route('groups')}}" method="post">
                {{csrf_field()}}
                <input type="text" name="name" placeholder="СП741">
                <input class="btn btn-primary"  type="submit" value="Добавить группу">
            </form>
        </div>
        <h3>Список добавленных групп:</h3>
        @foreach($groups as $group)
        <div class="row d-flex flex-row">

            <div class="col-6">

                <form action="{{route('delete_group',$group->id)}}" method="post">
                    {{csrf_field()}}
                    {{method_field('delete')}}
                    {{$loop->index+1}}.  {{$group->name}}
                    <input class="btn btn-danger" type="submit" value="Удалить">
                </form>
            </div>
            <div class="col-6">
                @if($group->headman)
                {{$group->headmanUser->name}}
                    @endif
            </div>
        </div>
        @endforeach
    </div>



@endsection