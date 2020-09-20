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
        <div class="page-title">{{__('general.events')}}</div>
        <span class="page-title-branch"> > {{$record['name_'.app()->getLocale()]}}</span>
    </div>
    <!---->
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-4">
                @php
                    $photos = json_decode($record->photos);
                @endphp
                <div class="event-single-img">
                    <img src="{{asset($photos[0])}}" alt="">
                </div>
                <ul class="event-images">
                    @foreach($photos as $photo)
                        <li>
                            <img src="{{asset($photo)}}" alt="">
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-xs-12 col-md-8">
                <div class="event--single-title">
                    {{$record['name_'.app()->getLocale()]}}
                </div>
                <div class="event--single-date" style="margin-bottom: 10px;">
                    {{date('d/m/y', strtotime($record->date))}}
                </div>
{{--                <div class="event--single-title">--}}
{{--                    Quality management systems--}}
{{--                </div>--}}
                <div class="event-single-details">
                    {!! $record['desc_'.app()->getLocale()] !!}
                </div>
            </div>
        </div>
    </div>
@endsection
