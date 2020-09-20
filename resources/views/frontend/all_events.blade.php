@extends('frontend.layouts.app')
@section('title' , __('general.events') )
@section('meta')
    <meta name="keywords" content="{{ $seo_setting->keyword }}">
    <meta name="description" content="{{ $seo_setting->description}}">
    <meta property="og:title" content="{{__('general.events')}}"/>
    <meta property="og:description" content="{{ $seo_setting->description}}"/>
@endsection
@section('content')
    <!-- Contact -->
    <div class="container">
        <div class="page-title">{{__('general.events')}}</div>
    </div>
    <!---->
    <div class="container">
        <div class="row">
@if($events->count() > 0)
            @foreach($events as $item)
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="event-wrapper">
                    <div class="event-img">
                        <img src="{{asset(json_decode($item->photos)[0])}}" alt="">
                    </div>
                    <a href="{{route('singel_event', ['id'=>$item->id, 'country'=>get_country()->id])}}" class="event-title">
                        {{$item['name_'.app()->getLocale()]}}
                    </a>
                </div>
            </div>
            @endforeach
@endif
        </div>
    </div>
@endsection
