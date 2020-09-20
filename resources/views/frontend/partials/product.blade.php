<!-- Products-->

    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 wow fadeIn" data-wow-delay="0.2s">
        <div class="product-item">
            <a href="{{ route('product', ['country' => get_country()->code,'slug'=>$product->slug]) }}"
               class="product-img">
                <img class="lozad" src="{{ asset($product->thumbnail_img) }}" alt="">
            </a>
            <a href="{{ route('product', ['country' => get_country()->code,'slug'=>$product->slug]) }}"
               class="product-details">
                <div class="product-title">
                    {{ isset($product->name)?$product->name:$product['name_'.app()->getLocale()] }}
                </div>

                @php
                    if($product->discount && $product->discount_type=='amount')
                    $symbol = currency_symbol();
                    else{
                    $symbol = '%';
                    }
                    $discount = $product->discount;
                    $price = $product->unit_price;
                @endphp


                <div class="product-price">
                    {{home_discounted_base_price($product->id)}}
                    @if(isset($discount) && $discount != '0' )
                        <span class="product-old-price">{{single_price($price)}} </span>
                    @endif
                </div>
                <div>
                    <div class="product-rating pull-right">
                        {{ renderStarRating($product->rating) }}
                    </div>

                    @if(isset($discount) && $discount != '0' )
                        <div class="product-discount pull-left">
                            {{__('general.discount')}} {{$discount}} {{$symbol}}
                        </div>
                    @endif

                </div>
                <a href="cart.html" class="btn btn-add-cart">
                    {{__('general.request_now')}}
                    <i class="fa fa-shopping-cart"></i>
                </a>
            </a>
            <div class="add-to-favourites @auth @if(auth()->user()->wishlists->contains('product_id',$product->id)) active @endif @endauth"
                 onclick="addToWishList({{ $product->id }},$(this))">
            </div>

        </div>
    </div>
