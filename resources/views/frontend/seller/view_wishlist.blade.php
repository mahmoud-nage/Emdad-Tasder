@extends('frontend.layouts.app')
@section('title' , __('general.favourites') )
@section('meta')
<meta name="keywords" content="{{ $seo_setting->keyword }}">
<meta name="description" content="{{ $seo_setting->description}}">
<meta property="og:title" content="{{__('general.favourites')}}" />
<meta property="og:description" content="{{ $seo_setting->description}}" />
@endsection
@section('content')

    <div class="container-fluid">
        <!-- Content -->
        <div class="page-wrap profile-page">
            <!-- Menu -->
        @include('frontend.inc.seller_side_nav')
        <!--  Content -->
            <div class="main-content">
                <div class="index-container" style="border-radius: 20px; margin-top: 20px">
                <div class="row">
                    @foreach ($wishlists as $key => $wishlist)
                        @php
                            $product = $wishlist->product;
                            $image = isset($product->thumbnail_img)?$product->thumbnail_img:'assets/web/newface/images/logo.png';
                        @endphp
                        @if($product)
                            <div id="wishlist_{{ $wishlist->id }}" class="col-xs-12 col-sm-4 col-md-6 col-lg-4">
                            <div class="product-item">
                                <div class="product-img">
                                    <img src="{{ asset($image) }}" alt="">
                                </div>
                                <div class="product-details">
                            <div class="product-title">
                                
                                {{ app()->isLocale('ar') ? $product->name_ar : $product->name_en }}
                                @php
                                                if (request()->session()->get('country')){
                                                    $country = \App\Country::where('code' , request()->session()->get('country'))->first();
                                                }else{
                                                    $country = \App\Country::where('code' , 'eg')->first();
                                                }
                                                $discount = $product->get_discount($country->id);
                                                $price = $product->get_price($country->id);
                                             
                                            @endphp
                            </div>
                                 <div class="product-price-wrapper">
                                            <div class="product-price">
                                                {{home_discounted_base_price($product->id)}}
                                            </div>

                                            @if(isset($discount) && $discount != '0' )
                                                <div class="product-price-old">{{single_price($price)}} </div>
                                            @endif
                                            <div class="product-icon">
                                                <img src="{{ asset('assets/web/newface/images/Path%20113.png') }}"
                                                     alt="">
                                            </div>
                                        </div>
                                 <div class="product-discount-rating">
                                            @if(isset($discount) && $discount != '0' )
                                            <div class="product-discount">{{$discount}}
                                            </div>
                                            @endif
                                            <div class="product-rating">
 <div class="rating-wrapper">
                                            <fieldset class="rating" disabled readonly="readonly">
                                                {{ renderStarRating($product->rating) }}
                                            </fieldset>
                                            
                                        </div>
                                            </div>
                                        </div>
                            </div>
                                <div
                                    class="add-to-favourites active"
                                    onclick="removeFromWishlist({{ $wishlist->id }})"></div>
                                <a href="javascript:void(0)" class="btn btn-add-cart"
                                   onclick="showAddToCartModal({{ $product->id }})">
                                    <img src="{{ asset('assets/web/images/add-cart.png') }}" alt="">
                                </a>
                                <a href="{{ route('product', ['country' => get_country()->code, 'slug'=>$product->slug]) }}" class="btn btn-see-details">
                                    <span class="fa fa-eye"></span>
                                </a>
                            </div>
                        </div>
                        @endif
                    @endforeach

                </div>
                        <div class="text-center">
            {{ $wishlists->links() }}
        </div>
        <div class="clearfix"></div>
                </div>
            
            </div>

        </div>
    </div>
    <div class="modal fade" id="wallet_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="modal-header">
                    <h5 class="modal-title strong-600 heading-5">{{__('Recharge Wallet')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="" action="{{ route('wallet.recharge',['country' => get_country()->code]) }}" method="post">
                    @csrf
                    <div class="modal-body gry-bg px-3 pt-3">
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{__('Amount')}} <span class="required-star">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <input type="number" class="form-control mb-3" name="amount" placeholder="Amount" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{__('Payment Method')}}</label>
                            </div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <select class="form-control" data-minimum-results-for-search="Infinity" name="payment_option">
                                        @if (\App\BusinessSetting::where('type', 'paypal_payment')->first()->value == 1)
                                            <option value="paypal">{{__('Paypal')}}</option>
                                        @endif
                                        @if (\App\BusinessSetting::where('type', 'stripe_payment')->first()->value == 1)
                                            <option value="stripe">{{__('Stripe')}}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-base-1">{{__('Confirm')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div style="position: relative;bottom: -40px;">
        @include('frontend.seller.footer_tabs')
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        function show_wallet_modal(){
            $('#wallet_modal').modal('show');
        }
    </script>
@endsection
