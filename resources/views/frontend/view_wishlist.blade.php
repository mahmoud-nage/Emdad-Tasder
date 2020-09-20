@extends('frontend.layouts.app')
@section('title' , __('general.favourites') )
@section('meta')
<meta name="keywords" content="{{ $seo_setting->keyword }}">
<meta name="description" content="{{ $seo_setting->description}}">
<meta property="og:title" content="{{__('general.favourites')}}" />
<meta property="og:description" content="{{ $seo_setting->description}}" />
@endsection
@section('content')
    <!-- Page Contents Wrapper-->
    <div class="container">
        <!-- Content -->
        <div class="page-title">
            <!-- Menu -->
        @include('frontend.inc.customer_side_nav')
                <div class="  infinite-scroll">

        <div class="row">
                <div class="index-container">
                    @foreach ($wishlists as $key => $wishlist)
                        @php
                            $product = $wishlist->product;
                        @endphp
                    <div id="wishlist_{{ $wishlist->id }}" class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="product-item">
                            <div class="product-img">
                                <img src="{{ asset($product->thumbnail_img) }}" alt="">
                            </div>
                            <div class="product-details">
                            <div class="product-title">
                                {{ app()->isLocale('ar') ? $product->name_ar : $product->name_en }}
                                @php
                                $product_country = \Illuminate\Support\Facades\DB::table('product_countries')->where('product_id', $product->id)->where('country_id' , get_country()->id)->first();
                                if($product_country->discount &&
                                $product_country->discount_type=='amount')
                                $symbol = currency_symbol();
                                else{
                                $symbol = '%';
                                }
                                $discount = $product_country->discount;
                                $price = $product_country->unit_price;
                                @endphp
                            </div>
                            
                            <div class="product-price">
                                    {{home_discounted_base_price($product->id)}}
                                    @if(isset($discount) && $discount != '0' )
                                    <span class="product-old-price">{{single_price($price)}} </span>
                                    @endif
                                    <span class="pull-right"><img class="lozad" data-src="{{asset('assets/web/newface/images/Group 51.png')}}" alt=""></span>
                                </div>
                                
                                <div>
                                        @if(isset($discount) && $discount != '0' )
                                    <div class="product-discount pull-left">
                                        {{__('general.discount')}} {{$discount}} {{$symbol}}
                                    </div>
                                        @endif
                                    <div class="product-rating pull-right">
                                        {{ renderStarRating($product->rating) }}
                                    </div>
                                </div>
                                
                                 
                            </div>
                            <div class="add-to-favourites @auth @if(auth()->user()->wishlists->contains('product_id',$product->id)) active @endif @endauth"
                                onclick="addToWishList({{ $product->id }},$(this))"></div>
                            <a href="javascript:void(0)" class="btn btn-add-cart"
                               onclick="showAddToCartModal({{ $product->id }})">
                                <img src="{{ asset('assets/web/images/add-cart.png') }}" alt="">
                            </a>
                            <a href="{{ route('product',[ 'country' => get_country()->code, 'slug'=>$product->slug]) }}" class="btn btn-see-details">
                                <span class="fa fa-eye"></span>
                            </a>
                        </div>
                    </div>

                    @endforeach

                </div>
            </div>
            {{ $wishlists->links() }}
            </div>

        </div>
    </div>

    <div class="modal fade" id="addToCart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="c-preloader">
                    <i class="fa fa-spin fa-spinner"></i>
                </div>
                <button type="button" class="close absolute-close-btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div id="addToCart-modal-body">

                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        function removeFromWishlist(id){
            $.post('{{ route('wishlists.remove',['country' => get_country()->code]) }}',{_token:'{{ csrf_token() }}', id:id}, function(data){
                $('#wishlist').html(data);
                $('#wishlist_'+id).hide();
                showFrontendAlert('success', 'Item has been renoved from wishlist');
            })
        }
    </script>
@endsection
