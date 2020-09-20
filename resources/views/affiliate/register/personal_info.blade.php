<!DOCTYPE html>
<html lang="en">

<!-- begin::Head -->
<head>

    <meta charset="utf-8"/>
    <title>NewFace | Register</title>
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
<body>
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
                        <h4 class="kt-login__subtitle">The ultimate E-Commerce website.</h4>
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
                            <h3>Welcome {{$user->name}} please complete your info</h3>
                        </div>
                        <!--begin::Form-->
                        <form class="kt-form" method="post" id="kt_login_form"
                              action="{{ route('affiliate.register.storeInfo') }}">
                            @csrf
                            {{--birthdate--}}
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Date Of Birth *</label>

                                        <input style="background-color:#a9a9a947" id="birth_date"
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
                            </div>
                            {{--country && city--}}
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Country *</label>
                                        <select style="background-color:#a9a9a947" id="country"
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
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>City *</label>
                                        <select style="background-color:#a9a9a947" id="city"
                                                class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}"
                                                name="city_id">
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
                            {{--Address details --}}
                            <div class="form-group">
                                <label>Address details *</label>
                                <input style="background-color:#a9a9a947" id="address_details" type="text"
                                       class="form-control{{ $errors->has('address_details') ? ' is-invalid' : '' }}"
                                       name="address_details"
                                       required placeholder="{{__('Address details')}}">
                                @if ($errors->has('address_details'))
                                    <span class="invalid-feedback"
                                          role="alert"><strong>{{ $errors->first('address_details') }}</strong></span>
                                @endif
                            </div>
                            {{-- phone--}}
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Phone *</label>
                                        <input style="background-color:#a9a9a947" id="phone" type="text"
                                               class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                               name="phone"
                                               required placeholder="{{__('Phone')}}">
                                        @if ($errors->has('phone'))
                                            <span class="invalid-feedback"
                                                  role="alert"><strong>{{ $errors->first('phone') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!--begin::Action-->
                            <div class="kt-login__actions">
                                <a class="kt-link kt-login__link-forgot">
                                </a>
                                <button id="kt_login_signin_submit" type="submit"
                                        class="btn btn-primary btn-elevate kt-login__btn-primary"> Save
                                </button>
                            </div>
                            <!--end::Action-->
                        </form>
                        <!--end::Form-->
                    </div>

                    <!--end::Signin-->
                </div>

                <!--end::Body-->
            </div>

            <!--end::Content-->
        </div>
    </div>
</div>
</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    function ValidateCoupon(elm) {
        var coupon = $(".couponInputId").val();
        $.ajax({
            url: "<?php echo route('affiliate.validateCoupon'); ?>",
            type: 'POST',
            data: {
                coupon: coupon
            },
        }).then((response) => {
            if (response.status === "success") {
                $('.couponValidationMessage').show();
                $('.couponValidationMessage').removeClass('invalid-feedback');
                $('.couponValidationMessage').addClass('valid-feedback');
                $('.couponValidationMessage').text('Valid coupon');
            } else if (response.status === "fail") {
                $('.couponValidationMessage').show();
                $('.couponValidationMessage').removeClass('valid-feedback');
                $('.couponValidationMessage').addClass('invalid-feedback');
                $('.couponValidationMessage').text('Invalid coupon');
            }
            console.log(response.status);
        });
    }
</script>
<!-- end::Body -->
</html>
