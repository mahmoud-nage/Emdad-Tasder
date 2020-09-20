@extends('frontend.layouts.app')
@section('title' , __('general.about_us') )
@section('meta')
    <meta name="keywords" content="{{ $seo_setting->keyword }}">
    <meta name="description" content="{{ $seo_setting->description}}">
    <meta property="og:title" content="{{__('general.about_us')}}" />
    <meta property="og:description" content="{{ $seo_setting->description}}" />
@endsection
@section('content')
    @php
        $locale = app()->getLocale();
    @endphp
    <!-- About-->
    <section class="container margin-50">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <div class="section-title">
                    {{__('general.about_us')}}
                </div>
                <div class="about-description">
                    {{$general_setting['about_'.$locale]}}
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <div class="about-img">
                    <img src="{{asset($general_setting->about_us_img)}}" alt="">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-6">
                <div class="about-title">
                    {{__('general.vision')}}
                </div>
                <div class="about-description">
                    {{$general_setting['vision_'.$locale]}}
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <div class="about-title">
                    {{__('general.mission')}}
                </div>
                <div class="about-description">
                    {{$general_setting['mission_'.$locale]}}
                </div>
            </div>
        </div>
    </section>

@endsection
