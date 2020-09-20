@extends('frontend.layouts.app')
@section('title', __('general.follow_purchase'))
@section('meta')
<meta name="keywords" content="{{ $seo_setting->keyword }}">
<meta name="description" content="{{ $seo_setting->description}}">
<meta property="og:title" content="{{__('general.follow_purchase')}}" />
<meta property="og:description" content="{{ $seo_setting->description}}" />
@endsection
@section('content')

<!-- Page Contents Wrapper-->
<div class="container">
    <div class="index-container">
        <div class="follow-order">
            <img src="{{asset('assets/web/newface/images/follow.png')}}" alt="">
        </div>
        @if(!isset($order))
        <h4> {{__('general.order_info')}}</h4>
        <div class="order-code-wrapper">
            <form action="{{route('purchase.follow.get',['country' => get_country()->code])}}" method="post" id="orderForm">
                @csrf
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">{{__('general.order_number')}}<i class="text-danger">*</i></span>
                        <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="" required>
                        @error('code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                </div>
                <div class="text-center center-block margin-10">
                    <button type="submit" onclick="disabled()" id="btn_form" class="btn btn-main btn-second">
                    {{__('general.follow_order')}}
                    </button>
                </div>
            </form>
        </div>
        @endif
        @isset($order)
        
        @if($order != null)
        @php
            $status = $order->orderDetails->first()->delivery_status;
                               $status_name = \App\Status::all();

        @endphp
        <h4>{{__('general.order_summery')}}</h4>
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <div class="order-wrapper">
                    <div>
                        <span>{{__('general.order_number')}}</span>
                        <span>{{$order->code}}</span>
                    </div>
                    <div>
                        <span>{{__('general.customer')}}</span>
                        <span>
                            @if ($order->user_id != null)
                            {{ $order->user->name }}
                            @endif
                        </span>
                    </div>
                    <div>
                        <span>{{__('forms.email')}}</span>
                        <span>
                            @if ($order->user_id != null)
                            {{ $order->user->email }}
                            @endif
                        </span>
                    </div>
                    <div>
                        <span>{{__('general.delivery_address')}}</span>
                        <span>{{ isset(json_decode($order->shipping_address)->address_details)?json_decode($order->shipping_address)->address_details:'' }}</span>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <div class="order-wrapper">
                    <div>
                        <span>{{__('general.order_date')}}</span>
                        <span>{{ date('d-m-Y H:m A', $order->date) }}</span>
                    </div>
                    <div>
                        <span>{{__('general.total')}}</span>
                        <span>{{ single_price($order->grand_total)}}</span>
                    </div>
                    <div>
                        <span>{{__('general.shipping')}}</span>
                        <span>{{ single_price($order->status['name_'.app()->getLocale()]) }}</span>
                    </div>
                    <div>
                        <span>{{__('general.payment_method')}}</span>
                        <span>{{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <!--        -->
        <div class="order-stepper order-stepper-2">
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
            @foreach ($order->orderDetails as $key => $orderDetail)
            <div class="col-xs-6">
                <div class="order-wrapper products-wrapper">
                    <div>
                        <span>{{__('general.product')}}</span>
                        <span>{{ $orderDetail->product['name_'.app()->getLocale()] }}
                            {{ isset($orderDetail->Variation) ? ($orderDetail->Variation->getChoice()) : '' }}</span>
                    </div>
                    <div>
                        <span>{{__('general.quantity')}}</span>
                        <span>{{ $orderDetail->quantity  }}</span>
                    </div>
                    <div>
                    <span>{{__('general.seller_name')}}</span>
                    <span>{{isset($orderDetail->seller->shop->name)?$orderDetail->seller->shop->name:$orderDetail->seller->user->name}}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
        @endisset
    </div>
    <div class="clearfix"></div>
</div>

@endsection
@section('script')
<script>
    function disabled(){
        $('#btn_form').prop('disabled', true);
    }
</script>
@stop