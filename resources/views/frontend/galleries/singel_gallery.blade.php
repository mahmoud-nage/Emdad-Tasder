@extends('frontend.layouts.app')
@section('title' , $record['name_'.app()->getLocale()] )
@section('meta')
    <meta name="keywords" content="{{ $seo_setting->keyword }}">
    <meta name="description" content="{{ $seo_setting->description}}">
    <meta property="og:title" content="{{$record['name_'.app()->getLocale()]}}"/>
    <meta property="og:description" content="{{ $seo_setting->description}}"/>
@endsection
@section('content')
    <!-- Contact -->
    <div class="container">
        <div class="page-title">{{__('general.galleries')}} </div>
        <span class="page-title-branch"> > {{$record['name_'.app()->getLocale()]}} </span>
    </div>
    <!---->
    <div class="container">
        <ul class="gallery-single">
            @php
                $photos = json_decode($record->photos);
            @endphp
            @foreach($photos as $photo)
                <li>
                    <img src="{{asset($photo)}}" alt="">
                </li>
            @endforeach
            <li>
                <video width="400" controls>
                    <source src="assets/videos/wazer.MP4" type="video/mp4">
                    <source src="assets/videos/wazer.MP4" type="video/ogg">
                    Your browser does not support HTML5 video.
                </video>
            </li>
        </ul>
        <div class="clearfix"></div>
        <div class="gallery-single-title">
            {!! $record['name_'.app()->getLocale()] !!}
        </div>
        <div class="gallery-single-description">
            {!! $record['desc_'.app()->getLocale()] !!}
        </div>
    </div>
@endsection
