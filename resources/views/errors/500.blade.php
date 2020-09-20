@extends('layouts.blank2')
@section('content')

    <div class="container">
        <div class="error-wrapper">
            <h1 class="error-code text-danger">{{__('500')}}</h1>
            <p class="h4 text-uppercase text-bold">{{__('OOPS!')}}</p>
            <div class="pad-btm">
                {{__('Something went wrong. Looks like server failed to load your request.')}}
            </div>
            <div class="error-img">
                <img src="{{asset('assets/web/newface/images/500.png')}}" alt="">
            </div>
            <div class="form-group">
                {{--            <a href="{{env('APP_URL')}}" class="btn btn-main btn-lg input-lg">Home Page</a>--}}
            </div>
        </div>
    </div>
@endsection

