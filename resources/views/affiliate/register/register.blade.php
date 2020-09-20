<!DOCTYPE html>
<html lang="en">

<!-- begin::Head -->
<head>

    <meta charset="utf-8"/>
    <title>NewFace Affiliate | Register</title>
    <meta name="description" content="Login page example">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--begin::Fonts -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

    <!--end::Fonts -->

    <!--begin::Page Custom Styles(used by this page) -->
    <link href="{{ asset('assets/affiliate/css/pages/login/login-1.css') }}" rel="stylesheet" type="text/css"/>

    <link href="{{ asset('assets/affiliate/css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>


    <!--end:: Vendor Plugins for custom pages -->

    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->
    <link href="{{ asset('assets/affiliate/css/skins/header/base/light.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/css/skins/header/menu/light.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/css/skins/brand/dark.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/css/skins/aside/dark.css') }}" rel="stylesheet" type="text/css"/>

    <!--end::Layout Skins -->
    <link rel="shortcut icon" href="{{ asset('assets/affiliate/media/logos/favicon.png') }}"/>
</head>

<!-- end::Head -->

<!-- begin::Body -->

<div class="kt-grid kt-grid--ver kt-grid--root kt-page">
    <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v1" id="kt_login">
        <div
            class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">

            <!--begin::Aside-->
            <div class="kt-grid__item kt-grid__item--order-tablet-and-mobile-2 kt-grid kt-grid--hor kt-login__aside"
                 style="background-image: url({{asset('assets/affiliate/media/bg/bg-4.jpg')}});">
                <div class="kt-grid__item">
                    <a href="#" class="kt-login__logo">
                        {{--                        <img style="width: 10rem;height: 10rem" src="{{ asset('img/affiliate-logo.png') }}">--}}
                    </a>
                </div>
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver">
                    <div class="kt-grid__item kt-grid__item--middle">
                        <h3 class="kt-login__title">Welcome to NewFace!</h3>
                        <h4 class="kt-login__subtitle">The ultimate Bootstrap & Angular 6 admin theme framework for next
                            generation web apps.</h4>
                    </div>
                </div>
                <div class="kt-grid__item">
                    <div class="kt-login__info">
                        <div class="kt-login__copyright">
                            &copy 2020 Krito
                        </div>
                        <div class="kt-login__menu">
                            {{--                            <a href="#" class="kt-link">Privacy</a>--}}
                        </div>
                    </div>
                </div>
            </div>

            <!--begin::Aside-->

            <!--begin::Content-->
            <div
                class="kt-grid__item kt-grid__item--fluid  kt-grid__item--order-tablet-and-mobile-1  kt-login__wrapper">

                <!--begin::Body-->
                <div class="kt-login__body">

                    <!--begin::Signin-->
                    <div class="kt-login__form">
                        <div class="kt-login__title">
                            <div class="kt-grid__item">
                                <a href="#" class="kt-login__logo">
                                    <img style="width: 10rem;height: 10rem" src="{{ asset('img/affiliate-logo.png') }}">
                                </a>
                            </div>
                            <h3>Apply To Affiliate</h3>
                        </div>
                        <!--begin::Form-->
                        <form class="kt-form" method="post" id="kt_login_form"
                              action="{{ route('affiliate.register.storeUser') }}">
                            @csrf
                            <div class="form-group">
                                <input style="background-color:#a9a9a947" type="text"
                                       class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                       value="{{ old('name') }}" required="required" autofocus placeholder="Name">
                                <strong style="color: red" role="alert">{!! $errors->first('name') !!}</strong>
                            </div>
                            <div class="form-group">
                                <input style="background-color:#a9a9a947"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                       value="{{ old('email') }}" required="required" placeholder="Email" type="email">
                                <strong style="color: red" role="alert">{!! $errors->first('email') !!}</strong>
                            </div>
                            <div class="form-group">
                                <input style="background-color:#a9a9a947"
                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       type="password" name="password" required="required" placeholder="Password">
                                <strong style="color: red" role="alert">{!! $errors->first('password') !!}</strong>
                            </div>
                            <div class="form-group">
                                <input style="background-color:#a9a9a947"
                                       class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                       type="password"
                                       name="password_confirmation" required="required"
                                       placeholder="Password confirmation">
                                <strong style="color: red"
                                        role="alert">{!! $errors->first('password_confirmation') !!}</strong>
                            </div>
                            <div class="checkbox pad-btm text-left">
                                <input style="border-style: solid; border-width: 1px;" id="demo-form-checkbox"
                                       class="magic-checkbox" type="checkbox" name="remember" required
                                       id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <strong style="color: red" role="alert">{!! $errors->first('remember') !!}</strong>
                                <label for="demo-form-checkbox">
                                    {{ __('By clicking "Register", you confirm that you accept NewFace.com Terms & Conditions  and  Privacy policy') }}
                                </label>
                            </div>
                            <!--begin::Action-->
                            <div class="kt-login__actions">
                                <a class="kt-link kt-login__link-forgot">
                                </a>
                                <button id="kt_login_signin_submit" type="submit"
                                        class="btn btn-primary btn-elevate kt-login__btn-primary">Register
                                </button>
                            </div>

                            <!--end::Action-->
                        </form>

                        <!--end::Form-->

                        <!--begin::Divider-->
                        <div style="display: none" class="kt-login__divider">
                            <div class="kt-divider">
                                <span></span>
                                <span>OR</span>
                                <span></span>
                            </div>
                        </div>

                        <!--end::Divider-->

                        <!--begin::Options-->
                        <div style="display: none" class="kt-login__options">
                            <a href="#" class="btn btn-primary kt-btn">
                                <i class="fab fa-facebook-f"></i>
                                Facebook
                            </a>
                            <a href="#" class="btn btn-info kt-btn">
                                <i class="fab fa-twitter"></i>
                                Twitter
                            </a>
                            <a href="#" class="btn btn-danger kt-btn">
                                <i class="fab fa-google"></i>
                                Google
                            </a>
                        </div>

                        <!--end::Options-->
                    </div>

                    <!--end::Signin-->
                </div>

                <!--end::Body-->
            </div>

            <!--end::Content-->
        </div>
    </div>
</div>

<!-- end::Body -->
</html>
