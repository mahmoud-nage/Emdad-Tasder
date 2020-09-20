@extends('layouts.blank2')

@section('content')

<div class="container">
    <div class="error-wrapper">
        <div class="error-title">
{{--            Page Not Found--}}
        </div>
        <div class="error-img">
            <img src="{{asset('assets/web/newface/images/404.png')}}" alt="">
        </div>
        <div class="form-group">
{{--            <a href="{{env('APP_URL')}}" class="btn btn-main btn-lg input-lg">Home Page</a>--}}
        </div>
    </div>
</div>
@endsection
