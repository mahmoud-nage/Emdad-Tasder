@extends('frontend.layouts.app')
@section('title' , __('general.view_cart'))
@section('meta')
<meta name="keywords" content="{{ $seo_setting->keyword }}">
<meta name="description" content="{{ $seo_setting->description}}">
<meta property="og:title" content="{{__('general.view_cart')}}" />
<meta property="og:description" content="{{ $seo_setting->description}}" />
@endsection
@section('content')

    <section class="container">
        <!--   Cart  -->
        <div class="cart-tabs">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs " role="tablist">
                <li role="presentation" class="active">
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
                <li role="presentation">
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
                <li role="presentation">
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
        <div id="cart-summary" class="row">
            @include('frontend.partials.cart_summary')
            <div class="col-xs-12 col-md-7 col-lg-8">
                @if(session()->has('cart_'.session()->get('country')))
                    <div class="cart-items-wrapper">
                        <table class="table table-responsive cart-item">
                            <thead>
                            <tr>
                                <th class="product-image"></th>
                                <th class="product-name">{{__('general.product')}}</th>
                                <th class="product-price d-none d-lg-table-cell">{{__('forms.price')}}</th>
                                <th class="product-quanity d-none d-md-table-cell">{{__('general.quantity')}}</th>
                                <th class="product-total">{{__('general.total')}}</th>
                                <th class="product-remove"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach (Session::get('cart_'.session()->get('country')) as $key => $cartItem)
                                @php
                                    $product = \App\Product::find($cartItem['id']);
                                    $total = $total + $cartItem['price']*$cartItem['quantity'];
                                    $product_name_with_choice = app()->isLocale('ar') ? $product->name_ar : $product->name_en;
                                    if(isset($cartItem['color'])){
                                        $product_name_with_choice .= ' - '.\App\Color::where('code', $cartItem['color'])->first()->name;
                                    }
                                    
                                    foreach ((array)json_decode($product->choice_options) as $choice){
                                    
                                        $str = $choice->name;
                                        // example $str =  choice_0
                                        if (array_key_exists($str, $cartItem)){
                                        $product_name_with_choice .= ' - '.$cartItem[$str];
                                        }
                                    }
                                @endphp
                                <tr class="cart-item">
                                    <td class="product-image">
                                        <a href="#" class="mr-3">
                                            <img src="{{ asset($product->thumbnail_img) }}" width="100">
                                        </a>
                                    </td>

                                    <td class="product-name">
                                        <span
                                            class="pr-4 d-block">{{ app()->isLocale('ar') ? $product->name_ar : $product->name_en }}</span>
                                    </td>

                                    <td class="product-price d-none d-lg-table-cell">
                                        <span class="pr-3 d-block">{{ single_price($cartItem['price']) }}</span>
                                    </td>
                                    <td class="product-quantity d-none d-md-table-cell">
                                        <div class=" number-input-wrapper">
                                            <div class="number-input">
                                                <button
                                                    onclick="updateQuantity({{ $key }}, this.nextElementSibling , 'minus')"
                                                    data-type="minus" data-field="quantity[{{ $key }}]"></button>
                                                <input class="quantity" min="0" name="quantity[{{ $key }}]"
                                                       value="{{ $cartItem['quantity'] }}" type="number"
                                                       onchange="updateQuantity({{ $key }}, this)">
                                                <button
                                                    onclick="updateQuantity({{ $key }}, this.previousElementSibling , 'plus')"
                                                    class="plus" data-type="plus"
                                                    data-field="quantity[{{ $key }}]"></button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="product-total">
                                        <span>{{ single_price($cartItem['price']*$cartItem['quantity']) }}</span>
                                        <!--<span>{{ home_discounted_base_price($product->id) }}</span>-->
                                    </td>
                                    <td class="product-remove">
                                        <span class="remove-item fa fa-trash" title="Remove from Cart"
                                              onclick="removeFromCartView(event, {{ $key }})"></span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                    <div class="form-group text-right">
                        @if(Auth::check())
                            <a href="{{ route('checkout.shipping_info',['country' => get_country()->code]) }}"
                               class="btn btn-main next-tab">{{__('general.continue_to_shipping')}}</a>
                        @else
                            <button class="btn btn-main next-tab"
                                    onclick="showCheckoutModal()">{{__('general.continue_to_shipping')}}
                                <i class="fa fa-chevron-right"></i>
                            </button>
                        @endif
                    </div>
                @else
                    <div class="dc-header">
                        <h3 class="heading heading-6 strong-700">{{__('general.empty_cart')}}</h3>
                    </div>
                @endif
            </div>
        </div>
    </section>


    <!-- Modal -->
    <div class="modal fade" id="GuestCheckout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-zoom" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <section class="text-center">
                        <form class="login-form" role="form" action="{{ route('cart.login.submit',['country' => get_country()->code]) }}" method="POST"
                              style="width: 100%">
                            @csrf
                            <div class="col-xs-12 col-md-8 col-md-push-2">
                                <h2 class="color-main">{{__('general.login')}}</h2>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <img src="{{ asset('assets/web/images/email.png') }}" alt="">
                                        </span>
                                        <input type="email"
                                               class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                               value="{{ old('email') }}" name="email" placeholder="E-mail">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <img src="{{ asset('assets/web/images/password.png') }}" alt="">
                                        </span>
                                        <input type="password"
                                               class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                               name="password" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    @if(env('MAIL_USERNAME') != null && env('MAIL_PASSWORD') != null)
                                        <a href="{{ route('password.request',['country' => get_country()->code]) }}"
                                           class="pull-left">{{__('general.did_you_forget_your_password')}}</a>
                                    @endif
                                    <a href="{{ route('user.registration',['country' => get_country()->code]) }}"
                                       class="pull-right">{{__('forms.create_new_account')}}</a>
                                </div>
                                <div class="clearfix margin-10"></div>
                                <div class="form-group text-center">
                                    <input type="submit" class="btn btn-main" value="Login">
                                </div>
                                <div class="form-group text-center color-main font-size-16">
                                    {{__('general.or')}} {{__('general.login')}}
                                </div>
                                <div class="login-socials">
                                    @if(\App\BusinessSetting::where('type', 'google_login')->first()->value == 1)
                                        <a href="{{ route('social.login', ['country' => get_country()->code, 'provider' => 'google']) }}"
                                           class="login-google"></a>
                                    @endif
                                    @if (\App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1)
                                        <a href="{{ route('social.login', ['country' => get_country()->code,'provider' => 'facebook']) }}"
                                           class="login-facebook"></a>
                                    @endif
                                    @if (\App\BusinessSetting::where('type', 'twitter_login')->first()->value == 1)
                                        <a href="{{ route('social.login', ['country' => get_country()->code,'provider' => 'twitter']) }}"
                                           class="login-twitter"></a>
                                    @endif

                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        function removeFromCartView(e, key) {
            e.preventDefault();
            removeFromCart(key);
        }


        function updateQuantity(key, element, type) {
            if (type == 'plus') {
                element.parentNode.querySelector('input[type=number]').stepUp()
            } else {
                element.parentNode.querySelector('input[type=number]').stepDown()
            }
            $.post('{{ route('cart.updateQuantity',["country" => get_country()->code]) }}', {
                _token: '{{ csrf_token() }}',
                key: key,
                quantity: element.value
            }, function (data) {
                updateNavCart();
                $('#cart-summary').html(data);
// location.reload();
            });
        }

        function showCheckoutModal() {
            $('#GuestCheckout').modal();
        }
    </script>
@endsection
