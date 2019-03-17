@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <form action="{{route('groups')}}" method="post">
                {{csrf_field()}}
                <input type="text" name="name" placeholder="СП741" required>
                <input class="btn btn-primary"  type="submit" value="Добавить группу">
            </form>
        </div>

        @include('validerror')

        <h3>Список добавленных групп:</h3>

            @foreach($groups as $group)
                <div class="row">
                    <form action="{{route('one_group',$group->id)}}" method="post" class="col-md-9">
                        {{csrf_field()}}
                    <div class="col-md-3">
                        {{--{{$loop->index+1}}--}}
                        <input type="text" class="form-control" name="name" value="{{$group->name}}" >
                    </div>
                        <div class="col-md-6">
                        @if($users->where('group_id',$group->id)->count())
                        <select name="headman" class="form-control" id="">
                            @if($group->headman)
                                @foreach($users->where('group_id',$group->id) as $user)

                                        <option value="{{$user->id}}"
                                        @if($group->headman==$user->id)
                                            selected
                                            @endif
                                        >{{$user->name}}</option>
                                 @endforeach
                            @else
                                <option value="" selected disabled="disabled">Выбрать старосту</option>
                                @foreach($users->where('group_id',$group->id) as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            @endif
                        </select>
                        @else
                            В группе никто не зарегистрирован
                            @endif
                        </div>
                        <div class="col-md-3">
                    <input type="submit" class="btn btn-success" value="Сохранить">
                        </div>
                    </form>
                    {{--</form>--}}
                        <div class="col-md-3">
                    <form action="{{route('one_group',$group->id)}}" method="post">
                            {{csrf_field()}}
                            {{method_field('delete')}}

                            <input class="btn btn-danger" type="submit" value="Удалить">
                        </form>
                        </div>
                </div>
            @endforeach

    </div>



@endsection