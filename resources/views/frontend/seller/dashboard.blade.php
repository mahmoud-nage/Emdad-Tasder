@extends('frontend.layouts.app')
@section('title' , __('general.dashboard') )
@section('meta')
    <meta name="keywords" content="{{ $seo_setting->keyword }}">
    <meta name="description" content="{{ $seo_setting->description}}">
<meta property="og:title" content="{{__('general.dashboard')}}" />
    <meta property="og:description" content="{{ $seo_setting->description}}"/>
@endsection
@section('content')
    <style>
        body {
            padding-bottom: 427.094px !important;
        }
    </style>
    <div class="container-fluid">
        <!-- Content -->
        <div class="page-wrap profile-page">
            <!-- Menu -->
        @include('frontend.inc.seller_side_nav')
        <!--  Content -->
            <div class="main-content">
                <!--  Dashboard  -->
                <div class="profile-title">
                    {{__('general.dashboard')}}
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-lg-3">
                        <div class=" dashboard-stat stat-products">
                            <div class="stat-title">
                                {{__('general.products')}}
                            </div>
                            <div class="stat-number">
                                <span class="counter">{{ count(\App\Product::where('user_id', Auth::user()->id)->get()) }}</span>
                            </div>
                            <div class="stat-icon">
                                <img src="{{ asset('assets/web/newface/images/cloud.webp') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-lg-3">
                        <div class=" dashboard-stat stat-sale">
                            <div class="stat-title">
                                {{__('general.total_sales')}}
                            </div>
                            <div class="stat-number">

                                <span class="counter">{{ count(\App\OrderDetail::where('seller_id', Auth::user()->id)->where('delivery_status', 'delivered')->groupby('order_id')->get()) }}</span>
                            </div>
                            <div class="stat-icon">
                                <img src="{{ asset('assets/web/newface/images/sale.webp') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-lg-3">
                        <div class=" dashboard-stat stat-prescription">
                            <div class="stat-title">
                                {{__('general.total_earnings')}}
                            </div>
                            @php
                                $orderDetails = \App\OrderDetail::where('seller_id', Auth::user()->id)->get();
                                $total = 0;
                                foreach ($orderDetails as $key => $orderDetail) {
                                    if($orderDetail->delivery_status == 'delivered'){
                                        $total += $orderDetail->price - $orderDetail->commission;
                                    }
                                }
                            @endphp
                            <div class="stat-number">
                                <span class="counter">{{ single_price($total) }}</span>
                            </div>
                            <div class="stat-icon">
                                <img src="{{ asset('assets/web/newface/images/earning.webp') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-lg-3">
                        <div class=" dashboard-stat stat-orders">
                            <div class="stat-title">
                               {{__('general.successful_orders')}}
                            </div>
                            <div class="stat-number">
                                <span class="counter">{{ count(\App\OrderDetail::where('seller_id', Auth::user()->id)->where('delivery_status', 'delivered')->groupby('order_id')->get()) }}</span>
                            </div>
                            <div class="stat-icon">
                                <img src="{{ asset('assets/web/newface/images/successful.webp') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-8">
                        <!-- Order -->
                        <div class="profile-title">
                            {{__('general.orders')}}
                        </div>
                        <div class="order-wrapper">
                            <div class="order-row">
                                <span class="order-title">{{__('general.total_orders')}}:	</span>
                                <span class="order-number">{{ count(\App\OrderDetail::where('seller_id', Auth::user()->id)->groupby('order_id')->get()) }}</span>
                            </div>
                            <div class="order-row">
                                <span class="order-title">{{__('general.pending_orders')}}:</span>
                                <span class="order-number">{{ count(\App\OrderDetail::where('seller_id', Auth::user()->id)->where('delivery_status', 'pending')->groupby('order_id')->get()) }}</span>
                            </div>
                            <div class="order-row">
                                <span class="order-title">{{__('general.canceled_orders')}}:	</span>
                                <span class="order-number">{{ count(\App\OrderDetail::where('seller_id', Auth::user()->id)->where('delivery_status', 'Canceled')->groupby('order_id')->get()) }}</span>
                            </div>
                            <div class="order-row">
                                <span class="order-title">{{__('general.successful_orders')}}:	</span>
                                <span class="order-number">{{ count(\App\OrderDetail::where('seller_id', Auth::user()->id)->where('delivery_status', 'delivered')->groupby('order_id')->get()) }}</span>
                            </div>
                        </div>
                        <!-- User Info -->
                        <div class="section-wrapper">
                            <div class="section-header">
                                {{__('general.products')}}
                            </div>
                            <div class="section-body">
                                <div class="text-center margin-20">
                                    @if(Auth::user()->seller->verification_status == 0) 
                                  <div class="dash-tab-title">
                                    {{__('general.verify_now')}}
                                </div>
                                    @else
                                        <a href="{{ route('seller.products.upload',['country' => get_country()->code]) }}"  class="text-muted"> {{__('general.add_new_product')}}
                                        +</a>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <br><br>
                        @if(Auth::user()->seller->verification_status == 0)
                            <a href="#" class="dash-tab">
                                <!--{{ route('shop.verify',['country' => get_country()->code]) }}-->
                                <div class="dash-tab-icon">
                                    <img src="{{ asset('assets/web/newface/images/verify.webp') }}" alt="">
                                </div>
                                <div class="dash-tab-title">
                                    {{__('general.verify_now')}}
                                </div>
                            </a>
                        @else
                            <a href="#" class="dash-tab">
                                <div class="dash-tab-icon">
                                    <img src="{{ asset('assets/web/newface/images/verify.webp') }}" alt="">
                                </div>
                                <div class="dash-tab-title">
                                    {{__('general.verified')}}
                                </div>
                            </a>
                        @endif
                        <a href="{{ route('shops.index',['country' => get_country()->code]) }}" class="dash-tab">
                            <div class="dash-tab-title">
                                <img src="{{ asset('assets/web/newface/images/market.webp') }}" alt="">
                                {{__('general.profile')}}
                            </div>
                            <div class="dash-tab-description">
                                {{__('general.manage_shop')}}
                            </div>
                        </a>
                        <!--<a href="{{ route('profile',['country' => get_country()->code]) }}" class="dash-tab">-->
                        <!--    <div class="dash-tab-title">-->
                        <!--        <img src="{{ asset('assets/web/newface/images/cash.webp') }}" alt="">-->
                        <!--        {{__('general.payment')}}-->
                        <!--    </div>-->
                        <!--    <div class="dash-tab-description">-->
                        <!--        {{__('general.configure_payment_method')}}-->
                        <!--    </div>-->
                        <!--    <div class="dash-tab-validation valid">-->
                        <!--        5/5/2020-->
                        <!--    </div>-->
                        <!--</a>-->

                    </div>
                </div>

            </div>
        </div>
    </div>
    <div style="position: relative;bottom: -165px;">
        @include('frontend.seller.footer_tabs')
    </div>
@endsection
