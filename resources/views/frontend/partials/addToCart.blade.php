<div class="modal-body p-4">
    <section class="product-details-wrapper">
        @if($product)
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <!-- Insert to your webpage where you want to display the slider -->
                @if(is_array(json_decode($product->photos)) && count(json_decode($product->photos)) > 0)
                    <div id="amazingslider-wrapper-1"
                         style="display:block;position:relative;max-width:100%;padding-left:0px; padding-right:83px;margin:0 auto;">
                        <div id="amazingslider-1" style="display:block;position:relative;margin:0 auto;">
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
                        </div>
                    </div>
            @endif
            <!-- End of body section HTML codes -->
            </div>
            <form id="option-choice-form">
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}">
                <div class="col-xs-12 col-md-6">
                    <div class="products-details-row"  id="product_details">
                        <div>
                         <span class="title">
                             {{ app()->isLocale('ar') ? $product->name_ar : $product->name_en }}
                        </span>
                            <span class="rating-wrapper">
                            <fieldset class="rating" disabled="" readonly="readonly">
                                <!-- 5 Stars-->
                                {{ renderStarRating($product->rating) }}
                            </fieldset>
                        </span>
                        </div>
                        @php
                            $locale = app()->getLocale();
                            $country = request()->session()->get('country') ? \App\Country::where('code' , request()->session()->get('country'))->first() : \App\Country::where('code' , 'eg')->first();
                        @endphp
                        @if($product->user->user_type == 'seller')
                            <div>
                                <span class="title">Seller</span>
                                <span class="description">{{ $product->user->name }}</span>
                            </div>
                        @endif
                        <div>
                         <span class="title">
                            {{__('forms.price')}}
                        </span>
                        <span id="chosen_price" class="description">
                            {{ home_discounted_base_price($product->id) }}
                            </span>
                            <span id="available-quantity" class="description col-sm-6 pull-right" @if(app()->getLocale() == 'ar') style="float:left!important" @endif>
                                {{$product->main_quantity}}
                            </span>
                            <!--<span class="description">-->
                            <!--    {{ home_discounted_base_price($product->id) }}-->
                            <!--</span>-->
                        </div>
                    </div>
              
                  <div class="products-details-row">
                            @foreach ($product->choices as $key => $choice)
                                <input type="hidden" name="options[]" value=""
                                       class="hidden">
                               {{-- <!--@if($choice->name_en == 'colors')-->
                                <!--    <div >-->
                                <!--        <span class="title">{{ $choice['name_'.app()->getLocale()] }}</span>-->
                                <!--        <ul class="size-list" id="choice_{{$choice->id}}" data-level="{{$choice->id}}">-->
                                <!--            @foreach ($choice->options as $option_key => $option)-->
                                <!--                <li class="{{ isset($option->Color->name)?$option->Color->name:$option['value_'.app()->getLocale()] }}"-->
                                <!--                    data-value="{{ $option->id }}"-->
                                <!--                    title="{{ isset($option->Color->name)?$option->Color->name:$option['value_'.app()->getLocale()] }}"-->
                                <!--                    style="background-color: {{ $option->value_en }}" onclick="getVariantPrice()">-->
                                <!--                    <input type="hidden" name="option" value="{{ $option->id }}" class="hidden">-->

                                                    <!--@if($option->image)-->
                                                    <!--    <a href="{{asset($option->image)}}" data-fancybox="gallary">-->
                                                    <!--        <img width="24px" height="24px" src="{{asset($option->image)}}">-->
                                                    <!--    </a>-->
                                                    <!--@else-->
                                <!--                        {{isset($option->Color->name)?$option->Color->name:$option['value_'.app()->getLocale()] }}-->
                                                    <!--@endif-->
                                <!--                </li>-->
                                <!--            @endforeach-->
                                <!--        </ul>-->
                                <!--    </div>-->
                                <!--@else-->
                                --}}
                                
                                    <div >
                                        <span class="title">{{ $choice['name_'.app()->getLocale()] }}</span>
                                        <ul class="size-list" id="choice_{{$choice->id}}">
                                           
                                            @foreach ($choice->options as $option_key => $option)
                                               {{-- <!--    @if($option->image)-->
                                                <!--<li data-level="{{$choice->id}}" onclick="getVariantPrice();getVariantOptions({{ $option->id }}, {{$product->id}}, {{$choice->id}})" class="size" data-value="{{ $option->id }}" style="padding: 5px 0 !important;border:0 !important;height: auto;">-->
                                                <!--        <input type="hidden" name="option"  value="{{ $option->id }}" class="hidden">-->
                                                <!--        <a data-fancybox="gallery" href="{{asset($option->image)}}">-->
                                                <!--            <img  width="50px" height="50px" src="{{asset($option->image)}}" alt="{{$option['value_'.app()->getLocale()]}}" title="{{$option['value_'.app()->getLocale()]}}">-->
                                                <!--        </a>-->
                                                <!--</li>-->
                                                <!--    @else--> --}}
                                                <li data-level="{{$choice->id}}" onclick="getVariantPrice();getVariantOptions({{ $option->id }}, {{$product->id}}, {{$choice->id}})" class="size" data-value="{{ $option->id }}">
                                                <input type="hidden" name="option" value="{{ $option->id }}" class="hidden">
                                                        {{isset($option->Color->name)?$option->Color->name:$option['value_'.app()->getLocale()] }}
                                                       </li>
                                                   {{-- <!--@endif--> --}}
                                             
                                            @endforeach
                                            {{-- <!--@endif--> --}}
                                        </ul>
                                    </div>
                              
                            @endforeach
                        </div>
                
                
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
                                           @change="getVariantPrice()">
                                    <button type="button" onclick="plus(this)"
                                            data-type="plus" data-field="quantity" class="plus"></button>
                                </div>
                            </div>
                        </span>
                        </div>
                    </div>
                    <div id="chosen_price_div" class="products-details-row">
                        <div>
                            <span class="title">{{__('general.total')}}</span>
                            <span id="chosen_price" class="description">
                                {{ home_discounted_base_price($product->id) }}
                                </span>
                        </div>
                        <div class="margin-top-10">
                            <button type="button" class="btn btn-main" onclick="addToCart()" id="addtocart">
                                <span class="fa fa-cart-arrow-down"></span>
                                {{__('general.add_to_cart')}}
                            </button>
                            <button type="button" class="btn btn-success" onclick="buyNow()" id="buynow">
                                <span class="fa fa-cart-arrow-down"></span>
                                {{__('general.buy_now')}}
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
                         <span class="title">
                            {{__('general.payment')}}
                        </span>
                            <span class="description">
                            {{__('general.cash_or_visa')}}
                        </span>
                        </div>
                    </div>
                    <div class="share-socials-icons-wrapper">
                        <span class="title">{{__('general.share')}}</span>
                        <span class="share-socials-icons">
                                <a href="https://www.facebook.com/share.php?u={{ request()->url() }}" target="_blank"><i class="fa fa-facebook"></i></a>
                                <a href="https://twitter.com/intent/tweet?url={{ request()->url() }}%20M%20%26%20W&original_referer=" target="_blank"><i class="fa fa-twitter"></i></a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ request()->url() }}&title=&summary=&source=in1.com" target="_blank"><i class="fa fa-linkedin" style="background-color: #0077b5"></i></a>
                            </span>
                    </div>
                </div>
            </form>
        </div>
        @endif
    </section>
</div>


<script type="text/javascript" src="{{ asset('assets/web/sliderengine/initslider-1.js') }}"></script>

<script type="text/javascript">
    cartQuantityInitialize();
    $(document).ready(function () {
        $(".size-list li,.colors-list li").click(function () {
            var elem = $(this);
            $(this).parent().children().removeClass("active");
            $(this).addClass("active");
            console.log(elem.data('value'));
            $(this).parent().parent().prev().val(elem.data('value'));
            getVariantPrice();
        });
        $('#share').share({
            networks: ['facebook', 'twitter', 'linkedin', 'instagram'],
            theme: 'square'
        });
        getVariantPrice();
    });

    function plus(elem) {
        elem.parentNode.querySelector('input[type=number]').stepUp();
        getVariantPrice();
    }

    function minus(elem) {
        elem.parentNode.querySelector('input[type=number]').stepDown();
        getVariantPrice();
    }
</script>
