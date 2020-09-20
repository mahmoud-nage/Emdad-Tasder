@extends('frontend.layouts.app')
@section('title' , 'Home ')

@section('content')

    @php
        $locale = app()->getLocale();
        $country = get_country();
        $flash_deal = \App\FlashDeal::where('status', 1)->where('start_date', '<=', today()->timestamp)->where('end_date', '>=', today()->timestamp)->where('country_id', get_country()->id)->get();
    @endphp
    <!-- Slider-->
    @include('frontend.inc.slider')
    <!-- Deals -->

    <section class="categories-wrapper deals-wrapper">
        <div class="container">
                <!-- Flash deals -->
    <div class="col-xs-12">
                    <div class="section-title">
                        {{__('general.deals')}}
                    </div>
        <div class="owl-carousel owl-theme categories-slider">
            <!-- end flash deal -->
                    @foreach($flash_deal as $item)
                            <div class="item">
                                <a href="{{ route('search',['country' => get_country()->code]) }}?flash_deal=flash_deal&id={{$item->id}}" class="category-slider-item">
                                    <div class="category-img">
                                        <img src="{{asset($item->photo)}}" alt="">
                                    </div>
                                    <div class="category-title">
                                        {{$item['title_'.$locale]}}
                                    </div>
                                </a>
                            </div>
        @endforeach
        </div>

    </div>
            <div class="text-center margin-10">
                <a href="{{route('make_deal1', get_country()->id)}}" class="btn btn-second">{{__('general.make_deal')}}</a>
            </div>
        </div>
    </section>
    <!-- Categories -->
    <section class="categories-wrapper">
        <div class="container">
            <div class="section-title">
                {{__('general.categories')}}
            </div>
            <div class="owl-carousel owl-theme categories-slider">
                @foreach($categories as $category)
                    <div class="item">
                        <a href="{{ route('categories.all' ,['country' => get_country()->code])}}?id={{$category->id}}"
                           class="category-slider-item">
                            <div class="category-img">
                                <img src="{{$category->icon}}" alt="">
                            </div>
                            <div class="category-title">
                                {{$category['name_'.$locale]}}
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="text-center margin-10">
                <a href="{{ route('categories.all' ,['country' => get_country()->code])}}" class="btn btn-second">{{__('general.all_categories')}}</a>
            </div>
        </div>
    </section>


    <!-- Page Contents Wrapper-->
    <div class="container margin-30">
        @if(isset($todays_deal) && count($todays_deal)>0)
            <div class="section-title">
                {{__('general.todays_offers')}}
            </div>
            @foreach ($todays_deal as $key => $product)
                @if ($product != null)
                    @include('frontend.partials.product')
                @endif
            @endforeach
        @endif

        <div class="clearfix"></div>

        @isset($home_categories)
            @foreach($home_categories as $key => $category)
            <!-- Makeup -->
                <div class="section-title">
                    <span>{{ $category['name_'.$locale]  }}</span>
                </div>
                {{--                    <div class="col-xs-12">--}}
                {{--                        <div class="owl-carousel owl-theme products-slider">--}}
                @foreach($category->products as $index => $product)
                    @include('frontend.partials.product')
                @endforeach
                {{--                        </div>--}}
                {{--                    </div>--}}
                <div class="clearfix"></div>
            @endforeach
        @endisset
    </div>
@endsection
