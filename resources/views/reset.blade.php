@extends('layouts.app')

@section('content')
    <div class="container">
        <reset url_prefix="{{env('URL_PREFIX') ? env('URL_PREFIX') : ''}}"></reset>
    </div>
@endsection