@extends('frontend.layouts.app')

@if(isset($subsubcategory_id))
    @php
        $meta_title = \App\SubSubCategory::find($subsubcategory_id)->meta_title;
        $meta_description = \App\SubSubCategory::find($subsubcategory_id)->meta_description;
    @endphp
@elseif (isset($subcategory_id))
    @php
        $meta_title = \App\SubCategory::find($subcategory_id)->meta_title;
        $meta_description = \App\SubCategory::find($subcategory_id)->meta_description;
    @endphp
@elseif (isset($category_id))
    @php
        $meta_title = \App\Category::find($category_id)->meta_title;
        $meta_description = \App\Category::find($category_id)->meta_description;
    @endphp
@elseif (isset($brand_id))
    @php
        $meta_title = \App\Brand::find($brand_id)->meta_title;
        $meta_description = \App\Brand::find($brand_id)->meta_description;
    @endphp
@else
    @php
        $meta_title = env('APP_NAME');
        $meta_description = \App\SeoSetting::first()->description;
    @endphp
@endif
@php
    $sliders = \App\Slider::where("type","web")->where("published",1)->get();
@endphp

@section('meta_title'){{ $meta_title }}@stop
@section('meta_description'){{ $meta_description }}@stop


@section('content')
    <style>
        .form-control {
            border-radius: 10px;
        }

        select option {
            color: white;
            background-color: #f76b99;
        }

        .form-control option:after {
            color: #f76b99 !important;
            background-color: white !important;
        }

        .form-control option::selection {
            color: #f76b99 !important;
            background-color: white !important;
        }
    </style>
    <!-- Breadcrumb -->

    @php
        $brands = array();
        $locale = app()->getLocale();
        $country = request()->session()->get('country') ? \App\Country::where('code' , request()->session()->get('country'))->first() : \App\Country::where('code' , 'eg')->first();
    @endphp
    @if(isset($subsubcategory_id))
        @php
            foreach (json_decode(\App\SubSubCategory::find($subsubcategory_id)->brands) as $brand) {
                if(!in_array($brand, $brands)){
                    array_push($brands, $brand);
                }
            }
       @endphp
    @elseif(isset($subcategory_id))
    @php
         $products = \App\SubCategory::find($subcategory_id)->products;
            if($products != null){
                $ids = $products->pluck('id');
           }
        @endphp
        @foreach (\App\SubCategory::find($subcategory_id)->subsubcategories as $key => $subsubcategory)
            @php
                foreach (json_decode($subsubcategory->brands) as $brand) {
                    if(!in_array($brand, $brands)){
                        array_push($brands, $brand);
                    }
                }
            @endphp
        @endforeach
    @elseif(isset($category_id))
        @foreach (\App\Category::find($category_id)->subcategories as $key => $subcategory)
            @foreach ($subcategory->subsubcategories as $key => $subsubcategory)
                @php
                    if (is_array(json_decode($subsubcategory->brands)))
                        foreach (json_decode($subsubcategory->brands) as $brand) {
                            if(!in_array($brand, $brands)){
                                array_push($brands, $brand);
                            }
                        }
                @endphp
            @endforeach
        @endforeach
    @else
        @php
            foreach (\App\Brand::all() as $key => $brand){
                if(!in_array($brand->id, $brands)){
                    array_push($brands, $brand->id);
                }
            }
        @endphp
    @endif
    
    @php
        if(isset($ids) && $ids != null && count($ids)>0){
             $max_prices = \Illuminate\Support\Facades\DB::table('product_countries')->where('country_id' , $country->id)->whereIn('product_id', $ids)->max('unit_price');
        }else{
             $max_prices = \Illuminate\Support\Facades\DB::table('product_countries')->where('country_id' , $country->id)->max('unit_price');
        }
    @endphp
    <!-- Page Contents Wrapper-->
    
    
    
    
    <section class="filter-wrapper">
        <div class="container">
            <!-- filter -->
             <form class="" id="search-form" action="{{ route('search') }}" method="GET">
                @isset($category_id)
                    <input type="hidden" name="category" value="{{ \App\Category::find($category_id)->slug }}">
                @endisset
                @isset($subcategory_id)
                    <input type="hidden" name="subcategory" value="{{ \App\SubCategory::find($subcategory_id)->slug }}">
                @endisset
                @isset($subsubcategory_id)
                    <input type="hidden" name="subsubcategory"
                           value="{{ \App\SubSubCategory::find($subsubcategory_id)->slug }}">
                @endisset
                <div class="row">
                    <div class="filter-menu">
                        
                        <div class="col-md-3">
                            <select class="form-control select_filter" name="sort_by" onchange="filter()">
                                <option value="1"
                                        @isset($sort_by) @if ($sort_by == '1') selected @endif @endisset>{{__('general.newest')}}
                                    </option>
                                <option value="2"
                                        @isset($sort_by) @if ($sort_by == '2') selected @endif @endisset>{{__('general.oldest')}}
                                    </option>
                                <option value="3"
                                        @isset($sort_by) @if ($sort_by == '3') selected @endif @endisset>{{__('general.price_low_to_high')}}
                                    </option>
                                <option value="4"
                                        @isset($sort_by) @if ($sort_by == '4') selected @endif @endisset>{{__('general.price_high_to_low')}}
                                    </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control select_filter" name="brand" onchange="filter()">
                                <option value="">{{__('general.all_brands')}}</option>
                                @foreach ($brands as $key => $id)
                                    @if (\App\Brand::find($id) != null)
                                        <option value="{{ \App\Brand::find($id)->slug }}"
                                                @isset($brand_id) @if ($brand_id == $id) selected @endif @endisset>{{ \App\Brand::find($id)->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-3">
                            <select class="form-control select_filter" name="seller_id" onchange="filter()">
                                <option value="">{{__('general.all_sellers')}}</option>
                                @foreach (\App\Seller::all() as $key => $seller)
                                    <option value="{{ $seller->id }}"
                                            @isset($seller_id) @if ($seller_id == $seller->id) selected @endif @endisset>{{ $seller->user->shop->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- <div class="col-md-3">
                            <select class="form-control select_filter" name="subsubcategory" onchange="filter()">
                                <option value="" disabled>{{__('general.all_cat')}}</option>
                                
                                @foreach (\App\SubSubCategory::where('sub_category_id', \App\SubSubCategory::find($subsubcategory_id)->sub_category_id)->get() as $key => $value)
                                    @if ($value->count() > 0)
                                        <option value="{{ $value->slug }}"
                                                @isset($subsubcategory_id) @if ($subsubcategory_id == $value->id) selected @endif @endisset>{{ $value['name_'.app()->getLocale()] }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        
                        {{-- // new filters --}}
                     <div class="col-md-3">
                            <select class="form-control select_filter" name="rating" onchange="filter()">
                                <option value="">{{__('general.all_rating')}}</option>
                                <option value="1">{{__('general.downRating')}}</option>
                                <option value="5">{{__('general.upRating')}}</option>
                      
                            </select>
                        </div> 

                    </div>
                </div>
                <input type="hidden" name="min_price" value="">
                <input type="hidden" name="max_price" value="">
            </form>
            <!-- Price slider -->
            <br/>
            <br/>
         
            <div class="row">
                <div class="col-xs-12 col-sm-10 col-sm-push-1 col-md-8 col-md-push-2 col-lg-6 col-lg-push-3">
                    <div data-role="page">
                        <div class="price-range-slider">
                            <p class="range-value">
                                <input type="text" id="amount1" readonly>
                            </p>
                            <div id="slider-range" class="range-bar"></div>
                            <p class="range-value">
                                <input type="text" id="amount2" readonly>
                            </p>
                        </div>
                    </div>
                </div>
            </div> 
                    <!-- Category -->
                    <div style="font-size: 24px;
                    color: #EA1262;
                    border-bottom: 2px solid #EA1262;
                    margin: 10px auto;
                    width: fit-content;">
                        {{__('general.subcat')}}
                    </div>
        <div class="owl-carousel owl-theme categories-slider">

            @if($subcategory_id)
                        @foreach (\App\SubCategory::find($subcategory_id)->subsubcategories as $key => $subsubcategory)
            <div class="item">
                <a href="{{ route('products.subsubcategory', $subsubcategory->slug) }}" class="category-item">
                    <div class="cat-img">

                        @if($subsubcategory->image)
                        <img src="{{asset($subsubcategory->image)}}" alt="{{ $subsubcategory['name_'.app()->getLocale()] }}">
                        @else
                        <img src="{{ asset('assets/web/newface/images/logo.png') }}" style="opacity: 0.7;" alt="">
                        @endif
                    </div>
                    <div class="cat-title">
                        {{ $subsubcategory['name_'.app()->getLocale()] }}
                    </div>
                </a>
            </div>
            @endforeach
            @endif

        </div>
        </div>
    </section>

    <div class="container" style="background: #fff;margin-top: 20px;">
        <!-- Special Deals -->
        <div class="clearfix"></div>
                    <div class="clearfix"></div>
            @include('frontend.partials.flashDeals')
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        function filter() {
            $('#search-form').submit();
        }

        $(document).ready(function () {
            $("#slider-range").slider({
                range: true,
                min: 0,
                // max: {!! \Illuminate\Support\Facades\DB::table('product_countries')->where('country_id' , $country->id)->max('unit_price') !!},
                 max: {!! $max_prices !!},
                values: [ {!! request()->input('min_price') ? request()->input('min_price') : 0 !!}, {!! request()->input('max_price') ? request()->input('max_price') : 100000 !!} ],
                slide: function (event, ui) {
                    $("#amount1").val(ui.values[0] + " L.E ");
                    $("#amount2").val(ui.values[1] + " L.E ");
                    $('input[name=min_price]').val(ui.values[0]);
                    $('input[name=max_price]').val(ui.values[1]);
                    filter();
                }
            });
            $("#amount1").val($("#slider-range").slider("values", 0) + " L.E ");
            $("#amount2").val($("#slider-range").slider("values", 1) + " L.E ");

        });

        function rangefilter(arg) {
            $('input[name=min_price]').val(arg[0]);
            $('input[name=max_price]').val(arg[1]);
            filter();
        }
    </script>
@endsection
