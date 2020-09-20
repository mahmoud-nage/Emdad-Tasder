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
<body
    class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">


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
                        <h4 class="kt-login__subtitle">The ultimate E-commerce for new face. </h4>
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
                            <h3>Sign in To Affiliate</h3>
                        </div>
                        <!--begin::Form-->
                        <form class="kt-form" method="post" id="kt_login_form"
                              action="{{ route('affiliate.login.store')}}">
                            @csrf
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
                            <!--begin::Action-->
                            <div class="kt-login__actions">
                                <a class="kt-link kt-login__link-forgot">
                                </a>
                                <button id="kt_login_signin_submit" type="submit"
                                        class="btn btn-primary btn-elevate kt-login__btn-primary">{{('Login')}}
                                </button>
                            </div>

                            <!--end::Action-->
                        </form>

                        <!--end::Form-->

                        <div class="text-center">
                            <a href="{{ route('affiliate.register') }}" class="btn btn-link">Create new account</a>
                        </div>
                        <!--begin::Divider-->
                        <div style="display: none" class="kt-login__divider">
                            <div class="kt-divider">
                                <span></span>
                                <span>OR</span>
                                <span></span>
                            </div>
                        </div>

                        <!--end::Divider-->

                    </div>

                    <!--end::Signin-->
                </div>

                <!--end::Body-->
            </div>

            <!--end::Content-->
        </div>
    </div>
</div>
<!-- begin:: Page -->

<!-- end:: Page -->

<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5d78ff",
                "dark": "#282a3c",
                "light": "#ffffff",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": [
                    "#c5cbe3",
                    "#a1a8c3",
                    "#3d4465",
                    "#3e4466"
                ],
                "shape": [
                    "#f0f3ff",
                    "#d9dffa",
                    "#afb4d4",
                    "#646c9a"
                ]
            }
        }
    };
</script>

<!-- end::Global Config -->

<!--begin::Global Theme Bundle(used by all pages) -->

<script src="{{ asset('assets/affiliate/js/scripts.bundle.js') }}" type="text/javascript"></script>

<!--end:: Vendor Plugins for custom pages -->

<!--end::Global Theme Bundle -->

<!--begin::Page Scripts(used by this page) -->
<script src="{{ asset('assets/affiliate/js/pages/custom/login/login-general.js') }}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

<script>
    @if(\Session::has('success'))
    Swal.fire({
        position: 'center',
        type: 'success',
        title: '{!! Session::get('success') !!}',
        showConfirmButton: false,
        timer: 1500
    });
    @endif
    @if(\Session::has('error'))
    Swal.fire({
        position: 'center',
        type: 'error',
        title: '{!! Session::get('error') !!}',
        showConfirmButton: false,
        timer: 1500
    });
    @endif
</script>

<!--end::Page Scripts -->
</body>

<!-- end::Body -->
</html>
