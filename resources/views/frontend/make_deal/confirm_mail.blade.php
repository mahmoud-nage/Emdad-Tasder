@extends('frontend.layouts.app')
@section('title' , __('general.confirm_mail') )
@section('meta')
    <meta name="keywords" content="{{ $seo_setting->keyword }}">
    <meta name="description" content="{{ $seo_setting->description}}">
    <meta property="og:title" content="{{__('general.confirm_mail')}}" />
    <meta property="og:description" content="{{ $seo_setting->description}}" />
@endsection
@section('content')
    <!-- Content -->
    <div class="container">
        <br>
        <div class="logo">
            <img src="{{ asset($general_setting->logo) }}" alt="">
        </div>
        <div class="confirm-wrapper">
            <p>Hello Mr Abdallah</p>
            <p>Thank you for register with us</p>
            <p>your account's username is <a href="#" class="color-main">abdallah</a></p>
            <p>To activate your account click the following link</p>
            <a href="mail-template.html" class="btn btn-second">Confirm Mail</a>
            <br><br><br>
            <h4>Thank you</h4>
            <h5>Emdad team</h5>
            <a href="index.html" class="color-main"></a>
        </div>

    </div>
    <!-- Footer -->
@endsection
