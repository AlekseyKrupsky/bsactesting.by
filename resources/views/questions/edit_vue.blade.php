@extends('layouts.app')

@section('content')

    <div class="container">
        <editquestion id="editquestion"
                      question_p="{{$question}}"
                       question_image="{{$question_images}}"
                      answers_p="{{$answers}}"
                      route="{{route('question_edit',$question->id)}}"
                        test_route="{{route('tests_edit',$question->test_id)}}"
                @showmessage="showmessage">

        </editquestion>
        <alert :messages="messages" :mess_type="mess_type" :key="alert_key"></alert>
    </div>
@endsection