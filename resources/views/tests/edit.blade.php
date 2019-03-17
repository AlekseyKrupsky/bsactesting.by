@extends('layouts.app')

@section('content')

    <div class="container">
        @if($user->haveAccess($test))

            @if($errors->count())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{route('tests_edit',$test->id)}}" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Обновить тест</h3>
                    </div>
                    {{csrf_field()}}
                    {{method_field('patch')}}
                    <div class="form-group">
                        <label for="name" class="col-md-4 control-label">Название</label>
                        <div class="col-md-6">
                            <input  type="text" class="form-control" name="name" value="{{$test->name}}" required>
                        </div>
                    </div>
                    @if($test->mark_system!='difficult')
                        <div class="form-group">
                            <label for="quest_number" class="col-md-4 control-label">Количество вопросов</label>
                            <div class="col-md-6">
                                <input  type="number" class="form-control" name="quest_number" value="{{$test->quest_number}}" required>
                            </div>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="time" class="col-md-4 control-label">Время выполнения (минут)</label>
                        <div class="col-md-6">
                            <input  type="number" class="form-control" name="time" value="{{$test->time}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="subject" class="col-md-4 control-label">Предмет</label>
                        <div class="col-md-6">
                            <select name="subject_id" id="subject" class="form-control">
                                @foreach($subjects as $subject)
                                    <option value="{{$subject->id}}" @if($subject->id==$test->subject->id) selected @endif>{{$subject->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mark_system" class="col-md-4 control-label">Система оценивания</label>
                        <div class="col-md-6">
                            <select name="mark_system" id="mark_system" class="form-control">
                                <option value="simple" @if($test->mark_system=='simple') selected @endif>Простая</option>
                                <option value="difficult" @if($test->mark_system=='difficult') selected @endif>Сложная</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mark_system" class="col-md-4 control-label">Статус теста</label>
                        <div class="col-md-6">
                            <select name="status" id="status" class="form-control" @if($questions->count()==0) disabled @endif>
                                <option value="build" @if($test->status=='build' || $questions->count()==0) selected @endif>Создание</option>
                                <option value="ready" @if($test->status=='ready' && $questions->count()>0) selected @endif>Рабочий</option>
                                <option value="changing" @if($test->status=='changing' && $questions->count()>0) selected @endif>Изменение</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <input type="submit" class="btn btn-success" value="Обновить">
                            <a class="btn btn-primary" href="{{route('question_add',$test->id)}}">Добавить вопрос</a>
                            <a href="{{route('tests')}}" class="btn btn-primary">Список всех тестов</a>
                        </div>
                    </div>
                </div>
            </form>

            @if($test->mark_system=='difficult')

                <form action="{{route('tests_edit',$test->id)}}" method="post">
                    <div class="row">
                        <div class="col-md-12"><h4><b>Количество вопросов</b></h4></div>
                        {{csrf_field()}}
                        @if(!empty($quest_count))
                            @foreach($quest_count as $cost=>$count)
                                <div class="form-group">
                                    <label for="count{{$loop->index}}" class="col-md-4 control-label">
                                        Количество вопросов на {{$cost}} б. (всего {{$count}})</label>
                                    <div class="col-md-6">
                                        <input  type="number" min="0" max="{{$count}}" id="count{{$loop->index}}"
                                                data-cost="{{$cost}}"
                                                class="form-control test-cost" name="question_info[{{$cost}}]"
                                                value="@if(!empty($question_info[$cost]) && $question_info[$cost]<=$count){{$question_info[$cost]}}@else{{0}}@endif" required>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="alert alert-info col-md-10">
                        <b>В тесте будет выведено</b>
                        <span class="quest_count">
                            <b>
                               @if(!empty($question_info)) {{array_sum($question_info)}} @endif
                            </b>
                        </span>
                        <b>вопрос(ов)</b>
                    </div>

                    <div class="row">
                        <div class="col-md-12"><h4><b>Критерии оценивания</b></h4></div>
                            @for($i=0; $i<=10;$i++)
                                <div class="form-group">
                                    <label for="limit{{$i}}" class="col-md-4 control-label">
                                        Баллы на оценку {{$i}}</label>
                                    <div class="col-md-3">
                                        <input  type="number" id="" @if($i==0) value="0" @else
                                        value="{{$mark_info[$i-1]+1}}" @endif disabled
                                                data-min="{{$i-1}}"
                                                class="form-control test-min">
                                    </div>
                                    <div class="col-md-3">
                                        <input  type="number" id="" placeholder="до:" @if($i==10) value="{{$maximum}}"  disabled @else
                                        value="{{$mark_info[$i]}}" @endif data-max="{{$i}}" min="0" max="{{$maximum}}"
                                                class="form-control test-max" name="mark_info[]">
                                    </div>
                                </div>
                            @endfor
                        <input class="btn btn-success" type="submit" value="Сохранить систему оценивания">
                    </div>
                </form>
            @endif

            <form class="delete" action="{{route('test_delete',$test->id)}}" method="post">
                {{csrf_field()}}
                {{method_field('delete')}}
                <button class="btn btn-danger">Удалить тест</button></form>
            <div class="row">
                @if($questions->count()<$test->quest_number)
                <div class="col-md-12 alert alert-warning">Недостаточно вопросов. Необходимо добавить минимум <b>  {{$test->quest_number-$questions->count()}}</b></div>
                @endif
                <div class="col-md-12">
                    <h3>Список вопросов и ответов ({{$questions->count()}})</h3>
                </div>
                @forelse($questions as $question)
                    <div class="col-md-12 question-admin">

                        <div data-quest="{{$question->id}}" class="col-md-8 wrapper open-ans">
                            {{$question->text}}
                        </div>
                        @if($test->mark_system=='difficult')
                            {{$question->cost}}
                        @endif
                        <div class="buttons">
                            <form class="delete" action="{{route('question',$question->id)}}" method="post">
                                {{csrf_field()}}
                                {{method_field('delete')}}
                                <button class="btn btn-danger">Удалить</button></form>
                            <a href="{{route('question_edit',$question->id)}}" class="btn btn-success">Редактировать</a>

                        </div>
                    </div>
                    <div class="col-md-12 answers-admin" id="quest-{{$question->id}}">
                        @foreach($answers->where('question_id',$question->id) as $answer)
                            <div class="alert @if($answer->correct)alert-success @else alert-danger @endif">
                                {{$answer->text}}
                            </div>
                        @endforeach

                    </div>

                @empty
                        @if(!empty($question_info))
                        {{array_sum($question_info)}}
                        @endif
                @endforelse
            </div>
        @else

            <div class="alert alert-danger">У вас нет доступа к этой странице</div>
        @endif

    </div>
@endsection