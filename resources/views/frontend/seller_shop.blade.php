@extends('frontend.layouts.app')
@section('title' , $shop->meta_title)

@section('meta')
    <meta name="keywords" content="{{ $seo_setting->keyword }}">
    <meta name="description" content="{{ $shop->description}}">

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $shop->meta_title }}">
    <meta itemprop="description" content="{{ $shop->meta_description }}">
    <meta itemprop="image" content="{{ asset($shop->logo) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $shop->meta_title }}">
    <meta name="twitter:description" content="{{ $shop->meta_description }}">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ asset($shop->meta_img) }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $shop->meta_title }}"/>
    <meta property="og:type" content="Shop"/>
    <meta property="og:url" content="{{ route('shop.visit', ['country' => get_country()->code, 'slug'=>$shop->slug]) }}"/>
    <meta property="og:image" content="{{ asset($shop->logo) }}"/>
    <meta property="og:description" content="{{ $shop->meta_description }}"/>
    <meta property="og:site_name" content="{{ $shop->name }}"/>
@endsection
@section('content')
    @php
        $total = 0;
        $rating = 0;
        foreach ($shop->user->products as $key => $seller_product) {
            $total += $seller_product->reviews->count();
            $rating += $seller_product->reviews->sum('rating');
        }
    @endphp
@if ($shop->sliders != null)
        <div id="carousel-wrapper" class="carousel slide" data-ride="carousel">

            <ol class="carousel-indicators">
                @if ($shop->sliders != null)

                    @foreach (json_decode($shop->sliders) as $key => $slide)
                        <li data-target="#carousel-wrapper" data-slide-to="{{$key}}"
                            class="@if($key == 0) active @endif"></li>
                    @endforeach
                @endif
            </ol>

            <div class="carousel-inner" role="listbox">
                @if ($shop->sliders != null)
                    @foreach (json_decode($shop->sliders) as $key => $slide)
                        <div class="item @if($key == 0) active @endif">
                            <img src="{{ asset($slide) }}" alt="...">
                        </div>
                    @endforeach
                @endif
            </div>

            <a class="left carousel-control" href="#carousel-wrapper" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-wrapper" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        @endif

    <!-- Page Contents Wrapper-->
    <section class="container padding-top-50">
        <!--  Seller  -->
        <div class="block-wrapper product-tabs">
            <div class="block-header">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li @if(!isset($type)) class="active" @endif>
                        <a href="{{ route('shop.visit',['country' => get_country()->code, 'slug'=>$shop->slug]) }}">{{__('general.store_home')}}</a>
                    </li>
                    <li @if(isset($type) && $type == 'top_selling') class="active" @endif>
                        <a href="{{ route('shop.visit.type', ['country' => get_country()->code,'slug'=>$shop->slug, 'type'=>'top_selling']) }}">
                            {{__('general.top_selling')}}
                        </a>
                    </li>
                    <li @if(isset($type) && $type == 'all_products') class="active" @endif>
                        <a href="{{ route('shop.visit.type', ['country' => get_country()->code,'slug'=>$shop->slug, 'type'=>'all_products']) }}">
                            {{__('general.all_products')}}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
   

        @if (!isset($type))
            @if($shop->user->products->where('published', 1)->where('featured', 1)->count() > 0)
                    <div class="index-container">
                <div class="seller-featured-products">
                    <!-- Featured products -->
                    <div class="page-title">
                        {{__('general.premium_products')}}
                    </div>
                    <div class="clearfix"></div>
                    <!-- Featured products -->
                    <div class="col-xs-12">
                        <div class="owl-carousel owl-theme products-slider">
                            @foreach ($products as $key => $product)
                                <div class="item">
                                    <div class="product-item">
                                        <div class="product-img">
                                            <img src="{{ asset($product->featured_img) }}" alt="">
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

                                            <div class="product-price-old">{{single_price($price)}} </div>
                                            <div class="product-icon">
                                                <img src="{{ asset('assets/web/newface/images/Path%20113.webp') }}"
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
                                            class="add-to-favourites @auth @if(auth()->user()->wishlists->contains($product->id)) active @endif @endauth"
                                            onclick="addToWishList({{ $product->id }},$(this))"></div>
                                        <a href="javascript:void(0)" class="add-to-compare"
                                           onclick="addToCompare({{ $product->id }})"></a>
                                        <a href="javascript:void(0)" class="btn btn-add-cart"
                                           onclick="showAddToCartModal({{ $product->id }})">
                                            <img src="{{ asset('assets/web/images/add-cart.png') }}" alt="">
                                        </a>
                                        <a href="{{ route('product', ['country' => get_country()->code, 'slug'=>$product->slug]) }}" class="btn btn-see-details">
                                            <span class="fa fa-eye"></span>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
    </div>
            @endif
        @endif
        <div class="row">
            <div class="col-xs-12 col-md-5 col-lg-4">
                <div class="block-wrapper seller-information">
                    <div class="row block-header">

                        <div class="col-md-6 text-left">
                            <h4 class="">{{__('general.seller_info')}}</h4>
                        </div>
                        <div class="col-md-6">
                            @if($shop->user->seller->verification_status == 1)
                                <div class="position-absolute medal-badge pull-right">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve"
                                         viewBox="0 0 287.5 442.2" style="width: 30px">
                                                <polygon style="fill:#F8B517;"
                                                         points="223.4,442.2 143.8,376.7 64.1,442.2 64.1,215.3 223.4,215.3 "/>
                                        <circle style="fill:#FBD303;" cx="143.8" cy="143.8" r="143.8"/>
                                        <circle style="fill:#F8B517;" cx="143.8" cy="143.8" r="93.6"/>
                                        <polygon style="fill:#FCFCFD;"
                                                 points="143.8,55.9 163.4,116.6 227.5,116.6 175.6,154.3 195.6,215.3 143.8,177.7 91.9,215.3 111.9,154.360,116.6 124.1,116.6 "/>
                                            </svg>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="block-body">
                        <div class="seller-name">{{ $shop->name }}</div>

                        <div class="seller-bio">{{ $shop->meta_description }}</div>
                        <div class="seller-rating-reviews">
                            <div class="rating-wrapper seller-rating">
                                @if ($total > 0)
                                    {{ renderStarRating($rating/$total) }}
                                @else
                                    {{ renderStarRating(0) }}
                                @endif
                            </div>
                            <div class="seller-rating-text">({{ $total }} {{__('general.customer_rev')}})</div>
                        </div>
                        <!--<div class="seller-socials">-->
                        <!--    <a href="{{ $shop->facebook }}" target="_blank" class="fa fa-facebook"></a>-->
                        <!--    <a href="{{ $shop->twitter }}" target="_blank" class="fa fa-twitter"></a>-->
                        <!--    <a href="{{ $shop->google }}" target="_blank" class="fa fa-google"></a>-->
                        <!--    <a href="{{ $shop->youtube }}" target="_blank" class="fa fa-youtube"></a>-->
                        <!--</div>-->
                    </div>
                </div>
                @php
                    $brands = array();
                @endphp
                <div class="block-wrapper">
                    <div class="block-header">{{__('general.categories')}}</div>
                    <div class="block-body">
                        <div class="panel-group" id="accordion1" role="tablist" aria-multiselectable="true">
                            @foreach (\App\Product::where('user_id', $shop->user->id)->distinct()->
                                pluck('category_id')->toArray() as $key => $category_id)
                                @php
                                    $category = \App\Category::find($category_id);
                                @endphp
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse"
                                               data-parent="#accordion1"
                                               href="#collapse{{$key}}" aria-expanded="false"
                                               aria-controls="collapse{{$key}}">
                                                {{ app()->isLocale('ar') ? $category->name_ar : $category->name_en }}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse{{$key}}" class="panel-collapse collapse " role="tabpanel">
                                        <div class="panel-body">
                                            <ul class="">
                                                @foreach (\App\Product::where('user_id', $shop->user->id)->where('category_id', $category_id)->distinct()->pluck('subcategory_id')->toArray() as $subcategory_id)
                                                    @foreach (\App\Product::where('user_id', $shop->user->id)->where('category_id',$category_id)->where('subcategory_id', $subcategory_id)->distinct()->pluck('subsubcategory_id')->toArray() as $subsubcategory_id)
                                                        @php
                                                            $subsubcategory = App\SubSubCategory::findOrFail($subsubcategory_id);
                                                            foreach (json_decode($subsubcategory->brands) as $brand) {
                                                                if(!in_array($brand, $brands)){
                                                                    array_push($brands, $brand);
                                                                }
                                                            }
                                                        @endphp
                                                    @endforeach
                                                    @php
                                                        $subcategory = \App\SubCategory::find($subcategory_id);
                                                    @endphp
                                                    <li>
                                                        <a href="{{ route('products.subcategory',  ['country' => get_country()->code, 'subcategory_slug' =>$subcategory->slug]) }}">
                                                            {{ app()->isLocale('ar') ? $subcategory->name_ar : $subcategory->name_en }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                    </div>
                </div>
                <div class="block-wrapper">
                    <div class="block-header">{{__('general.brands')}}</div>
                    <div class="block-body"  style="height: 230px; overflow-y: scroll;">
                        <ul class="brands-list">
                            @foreach ($brands as $brand_id)
                                <li class="brand-item">
                                    <a href="{{ route('products.brand', ['country' => get_country()->code, 'brand_slug' => \App\Brand::find($brand_id)->slug] ) }}"><img
                                            src="{{ asset(\App\Brand::find($brand_id)->logo) }}"
                                            class="img-fluid"></a>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>
            
            
            <div class="col-xs-12 col-md-7 col-lg-8">
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <!-- New Products -->
                        <div class="index-container">
                        <div class="page-title">
                            @if (!isset($type))
                                {{__('general.new_products')}}
                            @elseif ($type == 'top_selling')
                                {{__('general.top_selling')}}
                            @elseif ($type == 'all_products')
                                {{__('general.all_products')}}
                            @endif
                        </div>
                                            <div class="  infinite-scroll">

                        <div class="clearfix"></div>
                        <!-- New Products -->
                        <div class="row">
                            @php
                                if (!isset($type)){
                                    $productss = \App\Product::where('user_id', $shop->user->id)->where('published', 1)->orderBy('created_at', 'desc')->take(6)->get();
                                
                                }
                                elseif ($type == 'top_selling'){
                                    $productss = \App\Product::where('user_id', $shop->user->id)->where('published', 1)->orderBy('num_of_sale', 'desc')->take(6)->get();
                                }
                                elseif ($type == 'all_products'){
                                    $productss = \App\Product::where('user_id', $shop->user->id)->where('published', 1)->paginate(9);
                                }
                            @endphp
                            @foreach ($productss as $key => $product)
                                <div class="col-xs-12 col-sm-4 col-md-6 col-lg-4">
                                    <div class="product-item">
                                        <div class="product-img">
                                            <img src="{{ asset($product->thumbnail_img) }}" alt="">
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
                                                <img src="{{ asset('assets/web/newface/images/Path%20113.webp') }}"
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
                                                <!-- 5 Stars-->
                                                {{ renderStarRating($product->rating) }}
                                            </fieldset>
                                        </div>
                                            </div>
                                        </div>
                                    </div>
                                       
                                        <div
                                            class="add-to-favourites @auth @if(auth()->user()->wishlists->contains('product_id',$product->id)) active @endif @endauth"
                                            onclick="addToWishList({{ $product->id }},$(this))"></div>
                                        <a href="javascript:void(0)" class="btn btn-add-cart"
                                           onclick="showAddToCartModal({{ $product->id }})">
                                            <img src="{{ asset('assets/web/images/add-cart.png') }}" alt="">
                                        </a>
                                        <a href="{{ route('product',  ['country' => get_country()->code, 'slug' => $product->slug]  ) }}"
                                           class="btn btn-see-details">
                                            <span class="fa fa-eye"></span>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                                            @if($productss->count()>6)
                                            {{ $productss->links() }}
                                            @endif
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <br><br>
    </section>
@endsection
