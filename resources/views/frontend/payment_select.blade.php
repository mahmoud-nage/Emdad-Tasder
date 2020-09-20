@extends('frontend.layouts.app')
@section('title', __('general.select_payment'))
@section('meta')
<meta name="keywords" content="{{ $seo_setting->keyword }}">
<meta name="description" content="{{ $seo_setting->description}}">
<meta property="og:title" content="{{__('general.select_payment')}}" />
<meta property="og:description" content="{{ $seo_setting->description}}" />
@endsection
@section('content')

    <section class="container">
        <!--   Cart  -->
        <div class="cart-tabs">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs " role="tablist">
                <li role="presentation">
                    <a href="#" aria-controls="cart" role="tab" data-toggle="tab">
                        <span>1</span>
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 48 48" style="enable-background:new 0 0 48 48;" xml:space="preserve">
                        <style type="text/css">
                            .st0 {
                                fill: #DDDDDD;
                            }
                        </style>
                            <g>
                                <path class="st0" d="M16.5,29.6h18.6c2.1,0,3.8-1.7,3.8-3.8V18v0c0,0,0,0,0-0.1c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0
                                c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0s0,0,0,0s0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0
                                c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0
                                c0,0,0,0,0,0c0,0,0,0-0.1,0c0,0,0,0,0,0l-23.6-3.3v-3.3c0,0,0-0.1,0-0.1c0,0,0,0,0,0c0,0,0,0,0-0.1c0,0,0,0,0-0.1c0,0,0,0,0,0
                                c0,0,0,0,0-0.1c0,0,0,0,0,0c0,0,0,0,0-0.1c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0
                                c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0-0.1,0c0,0,0,0,0,0c0,0-0.1,0-0.1,0L8.9,7.4c-0.5-0.2-1,0-1.2,0.5
                                c-0.2,0.5,0,1,0.5,1.2l4.5,1.9v4.3V16v5.2v4.6v5.8c0,1.9,1.5,3.6,3.3,3.8c-0.3,0.6-0.5,1.2-0.5,1.9c0,2.1,1.7,3.8,3.8,3.8
                                s3.8-1.7,3.8-3.8c0-0.7-0.2-1.4-0.5-1.9H31c-0.3,0.6-0.5,1.2-0.5,1.9c0,2.1,1.7,3.8,3.8,3.8s3.8-1.7,3.8-3.8s-1.7-3.8-3.8-3.8H16.5
                                c-1.1,0-2-0.9-2-2v-2.5C15.1,29.4,15.8,29.6,16.5,29.6z M21.2,37.4c0,1.1-0.9,1.9-1.9,1.9c-1,0-1.9-0.9-1.9-1.9s0.9-1.9,1.9-1.9
                                C20.3,35.5,21.2,36.3,21.2,37.4z M36.2,37.4c0,1.1-0.9,1.9-1.9,1.9s-1.9-0.9-1.9-1.9s0.9-1.9,1.9-1.9S36.2,36.3,36.2,37.4z
                                 M35.2,27.8H16.5c-1.1,0-2-0.9-2-2v-4.6V16v-0.3l22.6,3.1v7C37.1,26.9,36.2,27.8,35.2,27.8z"/>
                            </g>
                    </svg>
                        {{__('general.cart')}}
                    </a>
                </li>
                <li role="presentation" >
                    <a href="#" aria-controls="shipping" role="tab" data-toggle="tab">
                        <span>2</span>
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 48 48" style="enable-background:new 0 0 48 48;" xml:space="preserve">
                        <style type="text/css">
                            .st0 {
                                opacity: 0.7;
                            }

                            .st1 {
                                fill: #DDDDDD;
                            }
                        </style>
                            <g class="st0">
                                <g>
                                    <g>
                                        <path class="st1" d="M16.4,27.7c-2,0-3.6,1.6-3.6,3.6s1.6,3.6,3.6,3.6s3.6-1.6,3.6-3.6S18.4,27.7,16.4,27.7z M16.4,33.7
				c-1.3,0-2.4-1.1-2.4-2.4c0-1.3,1.1-2.4,2.4-2.4c1.3,0,2.4,1.1,2.4,2.4C18.8,32.6,17.7,33.7,16.4,33.7z"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <path class="st1" d="M36.8,27.7c-2,0-3.6,1.6-3.6,3.6s1.6,3.6,3.6,3.6s3.6-1.6,3.6-3.6S38.8,27.7,36.8,27.7z M36.8,33.7
				c-1.3,0-2.4-1.1-2.4-2.4c0-1.3,1.1-2.4,2.4-2.4c1.3,0,2.4,1.1,2.4,2.4C39.2,32.6,38.1,33.7,36.8,33.7z"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <path class="st1" d="M43.9,24.4L38.5,16c-0.1-0.2-0.3-0.3-0.5-0.3h-6.6c-0.3,0-0.6,0.3-0.6,0.6v15c0,0.3,0.3,0.6,0.6,0.6h2.4
				v-1.2H32V16.9h5.7l5.1,8v5.8h-3v1.2h3.6c0.3,0,0.6-0.3,0.6-0.6v-6.6C44,24.6,44,24.5,43.9,24.4z"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <path class="st1" d="M34.4,23.5v-4.2h4.8v-1.2h-5.4c-0.3,0-0.6,0.3-0.6,0.6v5.4c0,0.3,0.3,0.6,0.6,0.6h9v-1.2L34.4,23.5
				L34.4,23.5z"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <path class="st1" d="M31.4,11.5H8.6c-0.3,0-0.6,0.3-0.6,0.6v19.2c0,0.3,0.3,0.6,0.6,0.6h4.8v-1.2H9.2v-18h21.6v18H19.4v1.2h12
				c0.3,0,0.6-0.3,0.6-0.6V12.1C32,11.8,31.7,11.5,31.4,11.5z"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <rect x="8.6" y="28.3" class="st1" width="3.6" height="1.2"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <rect x="20.6" y="28.3" class="st1" width="10.2" height="1.2"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <rect x="41" y="28.3" class="st1" width="2.4" height="1.2"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <rect x="10.4" y="13.9" class="st1" width="21" height="1.2"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <rect x="15.8" y="30.7" class="st1" width="1.2" height="1.2"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <rect x="36.2" y="30.7" class="st1" width="1.2" height="1.2"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <rect x="10.4" y="9.1" class="st1" width="8.4" height="1.2"/>
                                    </g>
                                </g>
                                <g>
                                    <g>
                                        <rect x="8" y="9.1" class="st1" width="1.2" height="1.2"/>
                                    </g>
                                </g>
                            </g>
                    </svg>
                        {{__('general.shipping')}}
                    </a>
                </li>
                <li role="presentation" class="active">
                    <a href="#" aria-controls="payment" role="tab" data-toggle="tab">
                        <span>3</span>
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 48 48" style="enable-background:new 0 0 48 48;" xml:space="preserve">
                    <style type="text/css">
                        .st0 {
                            fill: #DDDDDD;
                        }
                    </style>
                            <g>
                                <g>
                                    <g>
                                        <path class="st0" d="M39.4,20.5h-0.5V19v-5.3c0-1.7-1.4-3.1-3.1-3.1H22.2L13,8c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0
                                        c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0
                                        c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0
                                        c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0
                                        c0,0,0,0,0,0c0,0,0,0,0,0l-0.6,2.3h-1.6c-1.7,0-3.1,1.4-3.1,3.1c0,0,0,0,0,0v17.1c0,0.3,0.2,0.5,0.5,0.5c0.3,0,0.5-0.2,0.5-0.5
                                        V16.1c0.6,0.5,1.3,0.9,2.1,0.9h25.5c0,0,0,0,0,0c1.2,0,2.1,1,2.1,2.1v3.5h-5.4c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0
                                        c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0
                                        c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0l-2.6,4c0,0,0,0.1,0,0.1c0,0,0,0,0,0c0,0,0,0,0,0
                                        c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0
                                        c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0.1,0,0.1l2.6,4c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0
                                        c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0
                                        c0,0,0,0,0,0c0,0,0,0,0.1,0c0,0,0,0,0,0c0,0,0,0,0,0h5.4v3.5c0,1.2-1,2.1-2.1,2.1H10.3c-1.2,0-2.1-1-2.1-2.1c0,0,0,0,0,0v-2
                                        c0-0.3-0.2-0.5-0.5-0.5c-0.3,0-0.5,0.2-0.5,0.5v2c0,0,0,0,0,0c0,1.7,1.4,3.1,3.1,3.1h25.5c1.7,0,3.1-1.4,3.1-3.1c0,0,0,0,0,0
                                        v-3.5h0.5c0.8,0,1.5-0.7,1.5-1.5V22C40.9,21.2,40.2,20.5,39.4,20.5z M13.2,9.1l8.7,2.5c0,0,0,0,0,0l5.8,1.7H12.2L13.2,9.1z
                                         M37.9,16.8c-0.6-0.5-1.3-0.9-2.1-0.9c0,0,0,0,0,0H10.3c-1.2,0-2.1-1-2.1-2.1s1-2.1,2.1-2.1h1.3l-0.4,1.6h-0.9
                                        c-0.3,0-0.5,0.2-0.5,0.5c0,0.3,0.2,0.5,0.5,0.5h1.3c0,0,0,0,0,0l0,0h19.8c0,0,0,0,0,0c0,0,0,0,0,0h3.8c0.3,0,0.5-0.2,0.5-0.5
                                        c0-0.3-0.2-0.5-0.5-0.5h-3.7l-5.8-1.6h10.1c1.2,0,2.1,1,2.1,2.1V16.8z M39.9,29.9L39.9,29.9c0,0.3-0.2,0.5-0.5,0.5h-6.7L30.4,27
                                        l2.3-3.5h6.7c0,0,0,0,0,0c0.2,0,0.3,0,0.5-0.1V29.9L39.9,29.9z M39.4,22.5C39.4,22.5,39.4,22.5,39.4,22.5l-0.5,0v-1h0.5
                                        c0.3,0,0.5,0.2,0.5,0.5C39.9,22.3,39.7,22.5,39.4,22.5z"/>
                                    </g>
                                </g>
                            </g>
                    </svg>
                        {{__('general.payment')}}
                    </a>
                </li>
            </ul>
        </div>

        <div class="row">
            @include('frontend.partials.cart_summary')
            <div class="col-xs-12 col-md-7 col-lg-8">
                <div class="cart-items-wrapper">
                    <form action="{{ route('payment.checkout',['country' => get_country()->code]) }}" class="form-style form-sipping"
                          data-toggle="validator"
                          role="form"
                          method="POST" id="checkout-form">
                        @csrf
                        <div class="col-xs-12">
                            <div class="payment">
                                <h4 class="color-main">{{__('general.select_payment')}}</h4>
                                <div class="form-group">
                                    <!--@if(\App\BusinessSetting::where('type', 'paypal_payment')->first()->value == 1)-->
                                    <!--    <label class="radio-container">-->
                                    <!--        Paypal-->
                                    <!--        <img src="{{ asset('assets/web/newface/images/124px-PayPal.svg.png')}}" alt="">-->
                                    <!--        <input type="radio" name="payment_option" value="paypal" onclick="change_btn()">-->
                                    <!--        <span class="checkmark"></span>-->
                                    <!--    </label>-->
                                    <!--@endif-->
                                    <!--@if(\App\BusinessSetting::where('type', 'stripe_payment')->first()->value == 1)-->
                                    <!--    <label class="radio-container">-->
                                    <!--        Strip-->
                                    <!--        <img src="{{ asset('frontend/images/icons/cards/stripe.png')}}" alt="">-->
                                    <!--        <input type="radio" name="payment_option" value="stripe" onclick="change_btn()">-->
                                    <!--        <span class="checkmark"></span>-->
                                    <!--    </label>-->

                                    <!--@endif-->

                                    @if(\App\BusinessSetting::where('type', 'accept_kiosk')->first()->value == 1 && get_country()->accept_kiosk == 1)
                                        <label class="radio-container">
                                            Accept Masary or Aman
                                            <img src="{{ asset('frontend/images/icons/cards/accept.png')}}" alt="">
                                            <input type="radio"  name="payment_option" value="accept_kiosk" onclick="change_btn()">
                                            <span class="checkmark"></span>
                                        </label>
                                    @endif
                                    @if(\App\BusinessSetting::where('type', 'accept_card')->first()->value == 1 && get_country()->accept_card == 1)
                                        <label class="radio-container">
                                            Accept Card
                                            <img src="{{ asset('frontend/images/icons/cards/accept.png')}}" alt="">
                                            <input type="radio" name="payment_option" value="accept_card" onclick="change_btn()">
                                            <span class="checkmark"></span>
                                        </label>
                                    @endif
                                    @if(\App\BusinessSetting::where('type', 'accept_valu')->first()->value == 1 && get_country()->accept_valu == 1)
                                        <label class="radio-container">
                                            Accept ValU
                                            <img src="{{ asset('frontend/images/icons/cards/accept.png')}}" alt="">
                                            <input type="radio"  name="payment_option" value="accept_valu" onclick="change_btn()">
                                            <span class="checkmark"></span>
                                        </label>
                                    @endif
                                    @if(\App\BusinessSetting::where('type', 'cash_payment')->first()->value == 1 && get_country()->cash_payment == 1)
                                        <label class="radio-container">
                                            {{__('general.cash_on_delivery')}}
                                            <img src="{{ asset('assets/web/newface/images/cod-icon-640w.png')}}" alt="">
                                            <input type="radio" name="payment_option" value="cash_on_delivery" onclick="change_btn()">
                                            <span class="checkmark"></span>
                                        </label>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('home',['country' => get_country()->code]) }}" class="btn btn-success">
                                        <i class="fa fa-arrow-left"></i>
                                        {{__('general.return_to_shop')}}
                                    </a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="submit" id="btn_check" class="btn btn-main" disabled>{{__('general.complete_order')}}</button>
                                </div>
                            </div>
                            <br>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </section>


@endsection


@section('script')
    <script type="text/javascript">
        function use_wallet() {
            $('input[name=payment_option]').val('wallet');
            $('#checkout-form').submit();
        }
        function change_btn(){
            $('#btn_check').prop( "disabled", false );
        }
    </script>
@endsection
