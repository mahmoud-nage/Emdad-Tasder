@php
$deleviry = 0;
@endphp
<div class="col-xs-12 col-md-5 col-lg-4">
    @if (Auth::check() && \App\BusinessSetting::where('type', 'coupon_system')->first()->value == 1)
        <div class="block-wrapper discount-coupon">
            <div class="block-header">{{__('general.coupon_discount')}}</div>
            <div class="block-body">

                @if (session()->has('coupon_discount') || session()->has('coupon_url'))
                    <form class="" action="{{ route('checkout.remove_coupon_code', ['country' => get_country()->code]) }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @php
                            if (session()->has('coupon_discount')){
                                $value = session()->get('coupon_discount');
                            }
                            if(session()->has('coupon_affiliate')){
                                $value = \App\CouponUrl::find(session()->get('coupon_url'))->CouponAffiliate->code;
                            }
                        @endphp
                        <div class="form-group">
                            <input type="text" class="form-control" name="code" value="{{ $value }}"
                                   placeholder="PROMO CODE" readonly>
                            <input type="reset" value="{{__('general.clear')}}" class="clear-btn">
                        </div>
                        <div class="congrats">
                            {{__('general.congratulations')}}
                            <img src="{{ asset('assets/web/images/ticket.svg') }}" alt="">
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" class="btn btn-activate" value="{{__('general.change_coupon')}}">
                        </div>
                    </form>
                @else
                    <form class="" action="{{ route('checkout.apply_coupon_code', ['country' => get_country()->code]) }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" name="code"
                                   placeholder="{{__('general.promo_code')}}" required>
                            <input type="reset" value="{{__('general.clear')}}" class="clear-btn">
                        </div>
        <div class="col-sm-12">
            <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))
                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
                @endif
                @endforeach
            </div>
        </div>
                        <div class="form-group text-center">
                            <input type="submit" class="btn btn-activate" value="{{__('general.apply')}}">
                        </div>
                    </form>
                @endif
            </div>
        </div>
    @endif
    @if(session()->has('cart'))
        <div class="block-wrapper">
            <div class="block-header">
                {{__('general.order_summery')}}
            </div>
            <div class="block-body">
                <div class="order-summery-wrapper">
                    <div>
                        <div class="order-summery head-title">
                            <span class="title">{{__('general.product')}}</span>
                            <span class="title">{{__('general.total')}}</span>
                        </div>
                        @php
                            $subtotal = 0;
                            $tax = 0;
                        @endphp
                        @foreach (Session::get('cart') as $key => $cartItem)
                            @php
                                $product = \App\Product::find($cartItem['id']);
                                $subtotal += $cartItem['price']*$cartItem['quantity'];
                                $tax += $cartItem['tax']*$cartItem['quantity'];
                                $product_name_with_choice = app()->isLocale('ar') ? $product->name_ar : $product->name_en;
                            @endphp
                            <div class="order-summery products">
                            <span class="title">{{ $product_name_with_choice }}
                             <strong class="product-quantity">× {{ $cartItem['quantity'] }}</strong></span>
                                <span class="price">{{ single_price($cartItem['price']*$cartItem['quantity']) }}</span>
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
                        @if(session()->get('shipping_info'))
                            <div class="order-summery">
                                <span class="title">{{__('general.shipping')}}</span>
@php
$deleviry =  \App\City::find(Session::get('shipping_info')['city']) ? \App\City::find(Session::get('shipping_info')['city'])->delivery_price : 0 ;
@endphp
                                <span class="price">          
                                    {{ single_price($deleviry) }}
                            </span>
                            </div>
                        @endif
                        @if (Session::has('coupon_discount'))
                            <div class="order-summery">
                                <span class="title">{{__('general.coupon_discount')}}</span>
                                <span class="price">{{ single_price(Session::get('coupon_discount')) }}</span>
                            </div>
                        @elseif(session()->has('coupon_url'))
                            @php
                                $setting = \App\BusinessSetting::where('type' , 'coupon_affiliate_value')->first()->value;
                                $value = explode('_' , $setting)[0];
                            @endphp
                            <div class="order-summery">
                                <span class="title">{{__('general.coupon_discount')}}</span>
                                <span class="price">{{ single_price($value) }}</span>
                            </div>
                        @endif

                        @php
                            $total = $subtotal+$tax+$deleviry;
                            if(Session::has('coupon_discount')){
                                $total -= Session::get('coupon_discount');
                                if($total < 0){
                                    $total = 0;
                                    }
                            }
                        @endphp
                        <div class="order-summery">
                            <span class="title">{{__('general.total')}}</span>
                            <span class="price">{{ single_price($total) }}</span>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    @endif
</div>
