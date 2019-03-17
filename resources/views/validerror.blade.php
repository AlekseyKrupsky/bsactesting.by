@if($errors->count())
    <div class="row">
        <div class="alert alert-danger">
            <b>Ошибка валидации. Введены неверные данные</b>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif