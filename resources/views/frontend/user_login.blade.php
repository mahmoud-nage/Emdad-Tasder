@extends('frontend.layouts.app')
@section('title' , __('general.login'))
@section('meta')
<meta name="keywords" content="{{ $seo_setting->keyword }}">
<meta name="description" content="{{ $seo_setting->description}}">
<meta property="og:title" content="{{__('general.login')}}" />
<meta property="og:description" content="{{ $seo_setting->description}}" />
@endsection
@section('content')
    <section class="container text-center">
            <form class="login-form" role="form" action="{{ route('login') }}" method="POST">
                @csrf
            <div class="col-xs-12 col-md-8 col-md-push-2">
            <h2 class="color-main">{{__('general.login_to_your_account')}}</h2>
                <div class="form-group">
                    <div class="input-group">
                    <span class="input-group-addon">
                        <img src="{{ asset('assets/web/images/email.png') }}" alt="">
                    </span>
                        <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" name="email" placeholder="E-mail">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                    <span class="input-group-addon">
                        <img src="{{ asset('assets/web/images/password.png') }}" alt="">
                    </span>
                        <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    @if(env('MAIL_USERNAME') != null && env('MAIL_PASSWORD') != null)
                <a href="{{ route('password.request',['country' => get_country()->code]) }}" class="pull-left">{{__('general.did_you_forget_your_password')}}</a>
                    @endif
                    <a href="{{ route('user.registration',['country' => get_country()->code]) }}" class="pull-right">{{__('general.create_account')}}</a>
                </div>
                <div class="clearfix margin-10"></div>
                <div class="form-group text-center">
                    <input type="submit" class="btn btn-main" value="Login">
                </div>
                <div class="form-group text-center color-main font-size-16">
                    Or Login by
                </div>
                <div class="login-socials">
                    @if(\App\BusinessSetting::where('type', 'google_login')->first()->value == 1)
                        <a href="{{ route('social.login', ['country' => get_country()->code, 'provider' => 'google']) }}" class="login-google"></a>
                    @endif
                    @if (\App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1)
                            <a href="{{ route('social.login', ['country' => get_country()->code, 'provider' => 'facebook']) }}" class="login-facebook"></a>
                    @endif
                    @if (\App\BusinessSetting::where('type', 'twitter_login')->first()->value == 1)
                            <a href="{{ route('social.login', ['country' => get_country()->code, 'provider' => 'twitter']) }}" class="login-twitter"></a>
                    @endif

                </div>
            </div>
        </form>
    </section>


@endsection

