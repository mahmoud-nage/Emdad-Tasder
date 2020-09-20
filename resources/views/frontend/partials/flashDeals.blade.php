            <!-- Discounts -->
        @php
            $flash_deals = \App\FlashDeal::where('status', 1)->where('country_id', get_country()->id)->first();
        @endphp
                      <!-- Flash deals -->

               @if($flash_deals != null && strtotime(date('d-m-Y')) >= $flash_deals->start_date && strtotime(date('d-m-Y')) <= $flash_deals->end_date)

                        <div class="page-title">
                            {{$flash_deals['title_'.app()->getLocale()]}}
                        </div>
            
            <div class="row">

                    <div class="col-xs-12">
                    <div class="owl-carousel owl-theme products-slider">
                   
                   @foreach ($flash_deals->flash_deal_products->take(10) as $key => $flash_deal_product)
                   @php
                    $column = app()->isLocale('ar')? 'name_ar' : 'name_en'; 
                    $column_des = app()->isLocale('ar')? 'description_ar' : 'description_en'; 
                    $flash_product = \DB::table('products')->where('products.id', $flash_deal_product->product_id)->where('products.published', '1')->join('product_countries', 'products.id', '=', 'product_countries.product_id')->where('product_countries.country_id', get_country()->id)
                        ->select('products.id', 'products.' . $column . ' as name', 'products.thumbnail_img', 'products.featured_img',
                        'flash_deal_img', $column_des . ' as description', 'product_countries.unit_price', 'product_countries.discount',
                        'product_countries.discount_type', 'products.rating', 'products.slug')->first();
                   @endphp
                    @if ($flash_product != null)
                            <div class="item">
                                <div class="product-item">
                                    <div class="product-img">
                                        <img src="{{ asset($flash_product->thumbnail_img) }}" alt="">
                                    </div>
                        <div class="product-details">
                            <div class="product-title">
                                {{ $flash_product->name }}
                                @php
                                $product_country =
                                \Illuminate\Support\Facades\DB::table('product_countries')->where('product_id',
                                $flash_product->id)->where('country_id' , get_country()->id)->first();
                                if($product_country->discount &&
                                $product_country->discount_type =='amount')
                                    $symbol = currency_symbol();
                                else{
                                $symbol = '%';
                                }
                                $discount = $product_country->discount;
                                $price = $product_country->unit_price;
                                @endphp
                            </div>
                            <div class="product-price-wrapper">
                                <div class="product-price">
                                    {{home_discounted_base_price($flash_product->id)}}
                                </div>
                                @if(isset($discount) && $discount != '0' )
                                <div class="product-price-old">{{single_price($price)}} </div>
                                @endif
                                <div class="product-icon">
                                    <img src="{{ asset('assets/web/newface/images/Path%20113.webp') }}" alt="">
                                </div>
                            </div>
                            <div class="product-discount-rating">
                                @if(isset($discount) && $discount != '0' )
                                <div class="product-discount">{{__('general.discount')}} {{$discount}}
                                    {{$symbol}}
                                </div>
                                @endif
                                <div class="product-rating">
                                    <div class="rating-wrapper">
                                        <fieldset class="rating" disabled readonly="readonly">
                                            {{ renderStarRating($flash_product->rating) }}
                                        </fieldset>

                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="add-to-favourites @auth @if(auth()->user()->wishlists->contains('product_id',$flash_product->id)) active @endif @endauth"
                                onclick="addToWishList({{ $flash_product->id }},$(this))"></div>
                                    <a href="javascript:void(0)" class="btn btn-add-cart"
                                       onclick="showAddToCartModal({{ $flash_product->id }})"
                                       class="btn btn-add-cart">
                                        <img src="{{ asset('assets/web/newface/images/add-cart.png') }}" alt="">
                                    </a>
                                    <a href="{{ route('product', ['country' => get_country()->code,'slug'=>$flash_product->slug]) }}" class="btn btn-see-details">
                                        <span class="fa fa-eye"></span>
                                    </a>
                                </div>
                            </div>
                    @endif
                @endforeach

                    </div>
                </div>

            </div>
            @endif
            <!-- end flash deal -->