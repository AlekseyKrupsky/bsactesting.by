@extends('layouts.app')

@section('content')

    <div class="container">
        <addquestion id="addquestion" test="{{$test}}"
                     route="{{route('question_add',$test->id)}}"
                     @showmessage="showmessage"
                     @update="updateKey"
                     test_route="{{route('tests_edit',$test->id)}}"
                     :key="addQuestion_key" ></addquestion>
        <alert :messages="messages" :mess_type="mess_type" :key="alert_key"></alert>
    </div>
@endsection