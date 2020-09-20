@extends('frontend.layouts.app')
@section('title' , __('general.track_order'))
@section('meta')
<meta name="keywords" content="{{ $seo_setting->keyword }}">
<meta name="description" content="{{ $seo_setting->description}}">
<meta property="og:title" content="{{__('general.track_order')}}" />
<meta property="og:description" content="{{ $seo_setting->description}}" />
@endsection
@section('content')

    <section class="container">
        <!--   Orders  -->
        @isset($order)

            @php
                $status = $order->orderDetails->first()->delivery_status;
                                   $status_name = \App\Status::all();

            @endphp
            <div class="order-stepper">
                <div class="stepper">
                    <ul class="step-wrapper">
                     @if($status != 'Canceled')
                    <li @if($status == 'pending' || $status == 'on_review' || $status == 'on_delivery' || $status == 'delivered') class="active" @endif>
                        <span data-text="{{$status_name[0]['name_'.app()->getLocale()]}}">1</span>
                    </li>
                    <li @if($status == 'on_review' || $status == 'on_delivery' || $status == 'delivered') class="active"  @endif>
                        <span data-text="{{$status_name[1]['name_'.app()->getLocale()]}}">2</span>
                    </li>
                    <li @if($status == 'on_delivery' || $status == 'delivered') class="active" @endif>
                        <span data-text="{{$status_name[2]['name_'.app()->getLocale()]}}">3</span>
                    </li>
                    <li @if($status == 'delivered') class="active" @endif>
                        <span data-text="{{$status_name[3]['name_'.app()->getLocale()]}}">4</span>
                    </li>
                    @else
                    <li @if($status == 'Canceled') class="active" @endif>
                        <span data-text="{{$status_name[4]['name_'.app()->getLocale()]}}">1</span>
                    </li>
                    @endif
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-5 col-lg-4">
                    <div class="block-wrapper">
                        <div class="block-header">
                            {{__('general.order_summery')}}
                        </div>
                        <div class="block-body">
                            <div class="order-summery-wrapper">
                                <div>
                                    <div class="order-summery head-title">
                                        <span class="title">{{__('general.total')}}</span>
                                        <span class="title">{{__('general.product')}}</span>
                                    </div>
                                    @php
                                        $subtotal = 0;
                                        $tax = 0;
                                    @endphp
                                    @foreach ($order->orderDetails as $key => $orderDetail)
                                        @php
                                            $product = \App\Product::find($orderDetail->product_id);
                                            $subtotal += $orderDetail->price;
                                            $tax +=$orderDetail->tax;
                                            $product_name_with_choice = app()->isLocale('ar') ? $product->name_ar : $product->name_en;
                                        @endphp
                                        <div class="order-summery products">
                                            <span class="title">{{ $product_name_with_choice }}
                                                <strong class="product-quantity">× {{ $orderDetail->quantity }}</strong>
                                            </span>
                                            <span class="title">{{ single_price($orderDetail->price) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                <div>
                                    <div class="order-summery">
                                        <span class="title">{{__('general.sub_total')}}</span>
                                        <span class="price">{{ single_price($subtotal) }}</span>
                                    </div>
                                    <div class="order-summery">
                                        <span class="title">{{__('general.tax')}}</span>
                                        <span class="price">{{ single_price($tax) }}</span>
                                    </div>
                                    @if($order->shipping_address)
                                        <div class="order-summery">
                                            <span class="title">{{__('general.shipping')}}</span>
                                            <span class="price" id="delivery_price">
                                        <!--// update mahmoud nage at 20-6-2020-->
                                                {{  json_decode($order->shipping_address)->city ? single_price(\App\City::find(json_decode($order->shipping_address)->city)->delivery_price) : single_price(0) }}
                                         <!--{{  json_decode($order->shipping_address)->city ? \App\City::find(json_decode($order->shipping_address)->city)->delivery_price : 0 }}-->
                                        </span>
                                        </div>

                                    @endif
                                    @if ($order->coupon_discount)
                                        <div class="order-summery">
                                            <span class="title">{{__('general.coupon_discount')}}</span>
                                            <span class="price">{{ $order->coupon_discount }}</span>
                                        </div>
                                    @elseif($order->coupon_url_id)
                                        @php
                                            $setting = \App\BusinessSetting::where('type' , 'coupon_affiliate_value')->first()->value;
                                            $value = explode('_' , $setting)[0];
                                        @endphp
                                        <div class="order-summery">
                                            <span class="title">{{__('general.coupon_discount')}}</span>
                                            <span class="price">{{ single_price($value) }}</span>
                                        </div>
                                    @endif
                                    <div class="order-summery">
                                        <span class="title">{{__('general.total')}}</span>
                                        <span class="price">{{ single_price($order->grand_total) }}</span>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-7 col-lg-8">
                    <h3 class="color-main">
                        {{__('general.track_order_msg')}}
                    </h3>
                    <div class="orderNo-wrapper">
                        <div class="order-summery row">
                            <div class="title col-md-3">{{__('general.order_number')}}</div>
                            <div class="price col-md-9">{{$order->code}}</div>
                        </div>
                        @if(isset($response))
                        <div class="order-summery row">
                            <div class="title col-md-3">{{__('general.response')}}</div>
                            <br>
                            <br>
                            <div class="price col-md-9">{!!$response!!}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        @endisset
    </section>


@endsection
