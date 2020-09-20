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
    <link href="{{ asset('assets/affiliate/css/pages/login/login-4.css') }}" rel="stylesheet" type="text/css"/>

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

<!-- begin:: Page -->
<div class="kt-grid kt-grid--ver kt-grid--root">
    <style>
        .form-group {
            padding-bottom: 10px;
        }
    </style>
    @php
        $generalsetting = \App\GeneralSetting::first();
    @endphp
    <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v4 kt-login--signin" id="kt_login">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor"
             style="background-image: url({{ asset('img/background-affiliate.png') }})">
            <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
                <div class="kt-login__container"
                     style="background-color:white;height: 1300px;width: 800px;padding: 40px">
                    <div class="kt-login__logo">
                        <a href="#">
                            <img src="{{ asset('img/affiliate-logo.png') }}" style="width: 100px;">
                        </a>
                    </div>
                    <div class="kt-login__signin">
                        <div class="kt-login__head">
                            <h3 class="kt-login__title">Apply To Affiliate</h3>
                        </div>
                        <form class="kt-form" method="POST" role="form"
                              action="{{ route('affiliate.register.store') }}">
                            @csrf
{{--                            //name--}}
                            <div class="form-group">
                                <label>Name *</label>
                                <input style="border-style: solid; border-width: 1px;" id="name" type="text"
                                       class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                       value="{{ old('name') }}" required autofocus placeholder="Name">
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                                @endif
                            </div>
{{--                            email--}}
                            <div class="form-group">
                                <label>Email *</label>

                                <input style="border-style: solid; border-width: 1px;" id="email" type="email"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                       value="{{ old('email') }}" required autofocus placeholder="Email">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                                @endif
                            </div>
{{--                            passord and confirm--}}
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Password *</label>
                                        <input style="border-style: solid; border-width: 1px;" id="password"
                                               class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                               type="password"
                                               name="password"
                                               required placeholder="Password">
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback"
                                                  role="alert"><strong>{{ $errors->first('password') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Password Confirmation *</label>

                                        <input style="border-style: solid; border-width: 1px;"
                                               id="password_confirmation"
                                               class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" type="password"
                                               name="password_confirmation"
                                               required placeholder="Password confirmation">
                                        @if ($errors->has('password_confirmation'))
                                            <span class="invalid-feedback"
                                                  role="alert"><strong>{{ $errors->first('password_confirmation') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
{{--                            birthdate--}}
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Date Of Birth *</label>

                                        <input style="border-style: solid; border-width: 1px;" id="birth_date"
                                               type="date"
                                               class="form-control{{ $errors->has('birth_date') ? ' is-invalid' : '' }}"
                                               name="birth_date"
                                               required placeholder="{{__('Date Of birth')}} *">
                                        @if ($errors->has('birth_date'))
                                            <span class="invalid-feedback"
                                                  role="alert"><strong>{{ $errors->first('birth_date') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Country *</label>
                                        <select style="border-style: solid; border-width: 1px;" id="country"
                                                class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}"
                                                name="country" required>
                                            <option value="" selected>Country</option>
                                            @foreach(\App\Country::all() as $country)
                                                <option value="{{ $country->code }}">{{ $country->name_en }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('country'))
                                            <span class="invalid-feedback"
                                                  role="alert"><strong>{{ $errors->first('country') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
{{--                            city--}}
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>City *</label>
                                        <select style="border-style: solid; border-width: 1px;" id="city"
                                                class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}"
                                                name="city_id" required>
                                            <option value="" selected>City</option>
                                            @foreach(\App\City::all() as $city)
                                                <option value="{{ $city->id }}">{{ $city->name_en }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('city'))
                                            <span class="invalid-feedback"
                                                  role="alert"><strong>{{ $errors->first('city') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
{{--                            Address details --}}
                            <div class="form-group">
                                <label>Address details *</label>
                                <input style="border-style: solid; border-width: 1px;" id="address_details" type="text"
                                       class="form-control{{ $errors->has('address_details') ? ' is-invalid' : '' }}"
                                       name="address_details"
                                       required placeholder="{{__('Address details')}}">
                                @if ($errors->has('address_details'))
                                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('address_details') }}</strong></span>
                                @endif
                            </div>
{{--                            phone and coupon--}}
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Phone *</label>
                                        <input style="border-style: solid; border-width: 1px;" id="phone" type="text"
                                               class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                               name="phone"
                                               required placeholder="{{__('Phone')}}">
                                        @if ($errors->has('phone'))
                                            <span class="invalid-feedback"
                                                  role="alert"><strong>{{ $errors->first('phone') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Coupon *</label>
                                        <input style="border-style: solid; border-width: 1px;" id="coupon"
                                               type="text"
                                               class="couponInputId form-control {{ $errors->has('coupon') ? ' is-invalid' : '' }} "
                                               name="coupon"
                                               onchange="ValidateCoupon(this)"
                                               required placeholder="{{__('coupon')}}">
                                        @if ($errors->has('coupon'))
                                            <span class="invalid-feedback"
                                                  role="alert"><strong>{{ $errors->first('coupon') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
{{--                            remember--}}
                            <div class="checkbox pad-btm text-left">
                                <input style="border-style: solid; border-width: 1px;" id="demo-form-checkbox"
                                       class="magic-checkbox" type="checkbox" name="remember" required
                                       id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="demo-form-checkbox">
                                    {{ __('By clicking "Register", you confirm that you accept NewFace.com Terms & Conditions  and  Privacy policy') }}
                                </label>
                            </div>
{{--                            submit button--}}
                            <button id="kt_login_signin_submit"
                                    class="btn btn-brand btn-pill kt-login__btn-primary">{{ __('Register') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

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
    function ValidateCoupon(elm) {
        var coupon = $(".couponInputId").val();
        alert(coupon);
        $.ajax({
            url: "{!! route('affiliate.validateCoupon') !!}",
            type: 'POST',
            data: {
                coupon: coupon
            },
        }).then((response) => {
            if (response.status === "success") {
                alert("You have entered valid coupon");
            } else if (response.status === "fail") {
                alert("Coupon already used.");
            }
            console.log(response.status);
        });
    }
</script>

<!--end::Page Scripts -->
</body>

<!-- end::Body -->
</html>
