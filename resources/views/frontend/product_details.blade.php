@extends('frontend.layouts.app')
@section('title' , app()->isLocale('ar') ? $product->name_ar : $product->name_en)

@section('meta')
    <meta name="keywords" content="{{ $seo_setting->keyword }}">
    <meta name="description" content="{{ $product->meta_description}}">
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $product->meta_title }}">
    <meta itemprop="description" content="{{ $product->meta_description }}">
    <meta itemprop="image" content="{{ asset($product->meta_img) }}">
    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $product->meta_title }}">
    <meta name="twitter:description" content="{{ $product->meta_description }}">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ asset($product->meta_img) }}">
    <meta name="twitter:data1" content="{{ single_price($product->unit_price) }}">
    <meta name="twitter:label1" content="Price">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $product->meta_title }}"/>
    <meta property="og:type" content="product"/>
    <meta property="og:url"
          content="{{ route('product', ['country' => get_country()->code, 'slug'=>$product->slug]) }}"/>
    <meta property="og:image" content="{{ asset($product->meta_img) }}"/>
    <meta property="og:description" content="{{ $product->meta_description }}"/>
    <meta property="og:site_name" content="{{ env('APP_NAME') }}"/>
    <meta property="og:price:amount" content="{{ single_price($product->unit_price) }}"/>

@endsection
@section('content')
    <style>
        .share-socials-icons a {
            border-radius: 50%;
        }
    </style>
    @php
        $locale = app()->getLocale();
    @endphp

    <!-- Page Contents Wrapper-->
    <section class="container">

        <br>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('products.subcategory' ,['country' => get_country()->code, 'subcategory_slug' => $product->subcategory->slug ])}}">{{$product->subcategory['name_'.app()->getLocale()]}}</a>
            </li>
            <li class="active"> {{ $product['name_'.$locale] }} </li>
        </ol>
        <!-- Item Details -->
        <section class="product-details-wrapper">
            <div class="row">
                <div class="col-xs-12 col-md-6" itemscope
                     itemtype="{{ route('product', ['country' => get_country()->code, 'slug'=>$product->slug]) }}"
                     itemprop="product">
                    <!-- Insert to your webpage where you want to display the slider -->
                    <div id="amazingslider-wrapper-1"
                         style="display:block;position:relative;max-width:100%;padding-left:0px; padding-right:83px;margin:0 auto;">
                        <div id="amazingslider-1" style="display:block;position:relative;margin:0 auto;">
                            <!--<span class="view-gallery">-->
                            <!--    <i class="fa fa-search-plus"></i>-->
                            <!--</span>-->
                            @if(is_array(json_decode($product->photos)) && count(json_decode($product->photos)) > 0)
                                <ul class="amazingslider-slides" style="display:none;">
                                    @foreach (json_decode($product->photos) as $key => $photo)
                                        <li><img src="{{ asset($photo) }}"/></li>
                                    @endforeach
                                </ul>

                                <ul class="amazingslider-thumbnails" style="display:none;">
                                    @foreach (json_decode($product->photos) as $key => $photo)
                                        <li><img src="{{ asset($photo) }}"/></li>
                                    @endforeach
                                </ul>
                            @endif

                            @if(is_array(json_decode($product->choice_options)) && count(json_decode($product->choice_options)) > 0)

                                <ul class="amazingslider-slides" style="display:none;">
                                    @foreach ($product->choices as $key => $choice)
                                        @foreach ($choice->options as $key1 => $option)

                                            @if($option->image)
                                                <li><img src="{{ asset($option->image) }}"/></li>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </ul>

                                <ul class="amazingslider-thumbnails" style="display:none;">
                                    @foreach ($product->choices as $key => $choice)
                                        @foreach ($choice->options as $key1 => $option)
                                            @if($option->image)
                                                <li id="option_{{$option->id}}"><img src="{{ asset($option->image) }}"/>
                                                </li>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                    <!-- End of body section HTML codes -->
                </div>
                <form method="post" action="{{route('make_deal1', ['country' => get_country()->id])}}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product->id }}">
                    <div class="col-xs-12 col-md-6">
                        <div class="products-details-row" id="product_details">
                            <div>
                         <span class="title" itemprop="name">
                             {{ $product['name_'.$locale] }}
                        </span>
                                <span class="rating-wrapper">
                            <fieldset class="rating" disabled="" readonly="readonly" itemprop="rating">
                                {{ renderStarRating($product->rating)  }}
                            </fieldset>
                        </span>
                            </div>
                            @php
                                $locale = app()->getLocale();
                                $country = get_country()->code;
                            @endphp
                            @if(isset($product->user->shop))
                                <div>
                                    <span class="title">{{__('general.seller')}}</span>
                                    <a href="{{route('shop.visit',['country' => get_country()->code, 'slug'=>$product->user->shop->slug] )}}">
                                        <span
                                            class="description">{{isset($product->user->shop->name)?$product->user->shop->name:$product->user->name}}</span>
                                    </a>
                                </div>
                            @endif
                            <div>
                         <span class="title">
                            {{__('forms.price')}}
                        </span>
                                <span id="chosen_price" class="description" itemprop="price">
                            {{ home_discounted_base_price($product->id) }}
                            </span>
                            </div>
                        </div>
                        @if($product->Variations()->where('product_country_id', get_country()->id)->count()>0)
                            <div class="products-details-row">
                                @foreach ($product->choices as $key => $choice)
                                    <input type="hidden" name="options[]" value=""
                                           class="hidden" required>

                                    <div>
                                        <span class="title">{{ $choice['name_'.$locale] }}</span>
                                        <ul class="size-list" id="choice_{{$choice->id}}">

                                            @foreach ($choice->options as $option_key => $option)
                                                <li data-level="{{$choice->id}}"
                                                    onclick="getVariantPrice();getVariantOptions({{ $option->id }}, {{$product->id}}, {{$choice->id}})"
                                                    class="size @if($loop->index == 0) active @endif"
                                                    data-value="{{ $option->id }}">
                                                    <input type="hidden" name="option" value="{{ $option->id }}"
                                                           class="hidden">
                                                    {{isset($option->Color->name)?$option->Color->name:$option['value_'.app()->getLocale()] }}
                                                </li>
                                                {{-- <!--@endif--> --}}

                                            @endforeach
                                            {{-- <!--@endif--> --}}
                                        </ul>
                                    </div>

                                @endforeach
                            </div>
                        @endif
                        <div class="products-details-row">
                            <div>
                         <span class="title">
                            {{__('general.quantity')}}
                        </span>
                                <span class="description">
                            <div class="input-group number-input-wrapper">
                                <div class="number-input">
                                    <button type="button" onclick="minus(this)"
                                            data-type="minus" data-field="quantity"></button>
                                    <input class="quantity" min="1" name="quantity" value="1" type="number"
                                           onchange="getVariantPrice()">
                                    <button type="button" onclick="plus(this)"
                                            data-type="plus" data-field="quantity" class="plus"></button>
                                </div>
                            </div>
                        </span>
                                <span class="product-unit">
                                    {{$product->unit['name_'.$locale]}}
                            </span>
                            </div>
                        </div>
                        <div id="chosen_price_div" class="products-details-row">
                            <div>
                                <span class="title" itemprop="total">{{__('general.total')}}</span>
                                <span class="description pull-right" id="discount">
                                </span>
                                <span id="chosen_price" class="description">
                                    @php
                                        $price = $product->get_price(get_country()->id);
                                    @endphp
                                    {{ $price }}
                                </span>
                            </div>
                            <div class="margin-top-10">
                                <button type="button" class="btn btn-main">
                                    <span class="fa fa-cart-arrow-down"></span>
                                    {{__('general.request_now')}}
                                </button>
                            </div>
                        </div>
                        <div class="products-details-row">
                            <div class="">
                                <a href="#" class="btn btn-link color-main" onclick="addToWishList({{ $product->id }})">
                                    <span class="fa fa-heart-o"></span>
                                    {{__('general.add_to_fav')}}
                                </a>
                            <!--<a href="#" class="btn btn-link color-main" onclick="addToCompare({{ $product->id }})">-->
                            <!--    <img src="{{ asset('assets/web/images/compare-2.png') }}" alt="" width="16">-->
                            <!--    {{__('general.add_to_compare')}}-->
                                <!--</a>-->
                            </div>
                        </div>
                        <div class="products-details-row">
                            <div>
                                @php
                                    $police = \App\Policy::where('name_en','return_policy')->first();
                                @endphp
                                <span class="title">
                                 {{$police['name_'.app()->getLocale()]}}
                                 <!--Return Policy-->
                            </span>
                                <span class="refund-details" itemprop="policy">

                                @if($police)
                                        {!! substr(strip_tags($police['content_'.app()->getLocale()]), 0, 100) !!}
                                    @endif
                            </span>
                                <a href="{{route('returnpolicy',['country' => get_country()->code])}}"
                                   class="color-main btn-link">{{__('general.details')}}</a>
                            </div>
                        </div>
                        <div class="products-details-row">
                            <div>
                                <span class="description" itemprop="description">
                                    {{__('general.cash_or_visa')}}
                                </span>
                            </div>
                        </div>
                        <div class="share-socials-icons-wrapper">
                            <span class="title">{{__('general.share')}}</span>
                            <span class="share-socials-icons">
                                <a href="https://www.facebook.com/share.php?u={{ request()->url() }}" target="_blank"><i
                                        class="fa fa-facebook"></i></a>
                                <a href="https://twitter.com/intent/tweet?url={{ request()->url() }}%20M%20%26%20W&original_referer="
                                   target="_blank"><i class="fa fa-twitter"></i></a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ request()->url() }}&title=&summary=&source=in1.com"
                                   target="_blank"><i class="fa fa-linkedin" style="background-color: #0077b5"></i></a>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <!--    -->
        <div class="block-wrapper">
            <div class="block-header">
                {{__('general.product_description')}}
            </div>
            <div class="block-body">
                {!! $product['description_'.$locale] !!}
            </div>
        </div>
        <div class="block-wrapper">
            <div class="block-header">
                {{__('general.seasonal_calendar')}}
            </div>
            <div class="block-body">
                <div class="calendar-title">
                    {{__('general.seasonal_calendar')}}
                </div>
                <ul class="calendar-menu">
                    <li class="@if(date('M', ($product->Season_from)) == 'Jan' || date('M', ($product->Season_to)) == 'Jan') active @endif ">
                        jan
                    </li>
                    <li class="@if(date('M', ($product->Season_from)) == 'Feb' || date('M', ($product->Season_to)) == 'Feb') active @endif ">
                        feb
                    </li>
                    <li class="@if(date('M', ($product->Season_from)) == 'Mar' || date('M', ($product->Season_to)) == 'Mar') active @endif ">
                        mar
                    </li>
                    <li class="@if(date('M', ($product->Season_from)) == 'Apr' || date('M', ($product->Season_to)) == 'Apr') active @endif ">
                        apr
                    </li>
                    <li class="@if(date('M', ($product->Season_from)) == 'May' || date('M', ($product->Season_to)) == 'May') active @endif ">
                        may
                    </li>
                    <li class="@if(date('M', ($product->Season_from)) == 'Jun' || date('M', ($product->Season_to)) == 'Jun') active @endif ">
                        jun
                    </li>
                    <li class="@if(date('M', ($product->Season_from)) == 'Jul' || date('M', ($product->Season_to)) == 'Jul') active @endif ">
                        jul
                    </li>
                    <li class="@if(date('M', ($product->Season_from)) == 'Aug' || date('M', ($product->Season_to)) == 'Aug') active @endif ">
                        aug
                    </li>
                    <li class="@if(date('M', ($product->Season_from)) == 'Sep' || date('M', ($product->Season_to)) == 'Sep') active @endif ">
                        sep
                    </li>
                    <li class="@if(date('M', ($product->Season_from)) == 'Oct' || date('M', ($product->Season_to)) == 'Oct') active @endif ">
                        oct
                    </li>
                    <li class="@if(date('M', ($product->Season_from)) == 'Nov' || date('M', ($product->Season_to)) == 'Nov') active @endif ">
                        nov
                    </li>
                    <li class="@if(date('M', ($product->Season_from)) == 'Des' || date('M', ($product->Season_to)) == 'Des') active @endif ">
                        des
                    </li>
                </ul>
                <div class="details-description">
                    {!! $product['Season_msg_'.$locale] !!}
                </div>
            </div>
        </div>
        <div class="block-wrapper">
            <div class="block-header">
                {{__('general.product_rating')}}
            </div>
            <div class="block-body">
                <div class="rating-wrapper actual-rating">

                    @foreach ($product->reviews()->orderBy('id', 'desc')->get() as $key => $review)
                        <div class="block block-comment">
                            <div class="block-image">
                                <img src="{{ asset($review->user->avatar_original) }}"
                                     class="rounded-circle">
                            </div>
                            <div class="block-body">
                                <div class="block-body-inner">
                                    <div class="row no-gutters">
                                        <div class="col">
                                            <h3 class="heading heading-6">
                                                <a href="javascript:;">{{ $review->user->name }}</a>
                                            </h3>
                                            <span class="comment-date">
                        {{ date('d-m-Y', strtotime($review->created_at)) }}
                    </span>
                                        </div>
                                        <div class="col">
                                            <div class="rating text-right clearfix d-block">
                        <span
                            class="star-rating star-rating-sm float-right">
                            @for ($i=0; $i < $review->rating; $i++)
                                <i class="fa fa-star active"></i>
                            @endfor
                            @for ($i=0; $i < 5-$review->rating; $i++)
                                <i class="fa fa-star"></i>
                            @endfor
                        </span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="comment-text">
                                        {{ $review->comment }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if(count($product->reviews) <= 0)
                        <div class="text-center">
                            {{ __('There have been no reviews for this product yet.') }}
                        </div>
                    @endif
                    @auth
                        @php
                            $perm = false;
                                foreach (auth()->user()->orders as $key => $order) {
                                    foreach ($order->orderDetails as $key => $orderDetail) {
                                      if($orderDetail->where('product_id', $product->id)->first()){
                                            $orderDetail->where('product_id', $product->id)->latest()->first()->delivery_status == 'delivered'?$perm = true:$perm = false;
                                        }
                                    }
                                }
                        @endphp
                        @if($perm && !auth()->user()->reviews->contains('product_id',$product->id))
                            <form action="{{ route('reviews.store',['country' => get_country()->code]) }}"
                                  method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""
                                                   class="text-uppercase c-gray-light">{{__('Your name')}}</label>
                                            <input type="text" name="name"
                                                   value="{{ Auth::user()->name }}"
                                                   class="form-control"
                                                   disabled required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""
                                                   class="text-uppercase c-gray-light">{{__('Email')}}</label>
                                            <input type="text" name="email"
                                                   value="{{ Auth::user()->email }}"
                                                   class="form-control" required disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="c-rating mt-1 mb-1 clearfix d-inline-block rat"
                                             style="margin: 20px auto;">
                                            <button type="submit" class="full" id="star5" name="rating" title="Awesome"
                                                    value="5"
                                                    required>
                                                <i class="fa fa-star"></i>
                                            </button>

                                            <button type="submit" id="star4" name="rating" title="Great" value="4"
                                                    required>
                                                <i class="fa fa-star"></i>
                                            </button>

                                            <button type="submit" id="star3" title="Very good" name="rating" value="3"
                                                    required>
                                                <i class="fa fa-star"></i>
                                            </button>

                                            <button type="submit" id="star2" name="rating" title="Good" value="2"
                                                    required>
                                                <i class="fa fa-star"></i>
                                            </button>

                                            <button type="submit" id="star1" name="rating" title="Bad" value="1"
                                                    required>
                                                <i class="fa fa-star"></i>
                                            </button>

                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-sm-12">
                                        <input type="hidden" id="star1" name="comment" value="text"
                                               required/>
                                        <textarea class="form-control" rows="4" name="comment"
                                                  placeholder="{{__('Your review')}}"
                                                  required></textarea>
                                    </div>
                                </div>

                                <!--<div class="text-right">-->
                                <!--    <button type="submit"-->
                                <!--            class="btn btn-styled btn-base-1 btn-circle mt-4">-->
                            <!--        {{__('Send review')}}-->
                                <!--    </button>-->
                                <!--</div>-->
                            </form>
                        @endif
                    @endauth


                </div>
            </div>
        </div>
    </section>
@endsection


