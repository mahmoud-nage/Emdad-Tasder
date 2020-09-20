@extends('frontend.layouts.app')
@section('title' , __('general.register'))
@section('meta')
<meta name="keywords" content="{{ $seo_setting->keyword }}">
<meta name="description" content="{{ $seo_setting->description}}">
<meta property="og:title" content="{{__('general.register')}}" />
<meta property="og:description" content="{{ $seo_setting->description}}" />
@endsection
@section('content')
    <section class="container text-center">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form class="login-form" role="form" action="{{ route('register', ['country' => get_country()->code]) }}" method="POST">
            @csrf
            <div class="col-xs-12 col-md-8 col-md-push-2">
                <h2 class="color-main">{{__('forms.create_new_account')}}</h2>
                <div class="form-group">
                    <div class="input-group">
                    <span class="input-group-addon">
                        <img src="{{ asset('assets/web/images/uname.png') }}" alt="">
                    </span>
                        <input type="text" class="form-control" name="name" placeholder="Name">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                    <span class="input-group-addon">
                        <img src="{{ asset('assets/web/images/email.png') }}" alt="">
                    </span>
                        <input type="email" class="form-control" name="email" placeholder="E-mail">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                    <span class="input-group-addon">
                        <img src="{{ asset('assets/web/images/password.png') }}" alt="">
                    </span>
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                    <span class="input-group-addon">
                        <img src="{{ asset('assets/web/images/password.png') }}" alt="">
                    </span>
                        <input type="password" class="form-control" name="password_confirmation"
                               placeholder="Confirm Password">
                    </div>
                </div>
                <div class="checkbox">
                    <label class="color-main">
                        <input type="checkbox" required> Agree on terms and condition
                    </label>
                </div>
                <div class="form-group text-center">
                    <input type="submit" class="btn btn-main" value="Register">
                </div>
                <div class="form-group text-center color-main font-size-16">
                    Or Sign Up by
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

@section('script')
    <script type="text/javascript">
        function autoFillSeller() {
            $('#email').val('seller@example.com');
            $('#password').val('123456');
        }

        function autoFillCustomer() {
            $('#email').val('customer@example.com');
            $('#password').val('123456');
        }
    </script>
@endsection
