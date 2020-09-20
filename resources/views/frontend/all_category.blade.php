@extends('frontend.layouts.app')
@section('title' , __('general.categories') )
@section('meta')
    <meta name="keywords" content="{{ $seo_setting->keyword }}">
    <meta name="description" content="{{ $seo_setting->description}}">
    <meta property="og:title" content="{{__('general.categories')}}"/>
    <meta property="og:description" content="{{ $seo_setting->description}}"/>
@endsection
@section('content')
    <!-- Slider -->
    <div class="owl-carousel owl-theme category-carousel">
        @foreach($records as $record)
            <div class="item">
                <div class="slider-img">
                    <img src="{{asset($record->banner)}}" alt="">
                </div>
            </div>
        @endforeach
    </div>
    <!-- Categories -->
    <section>
        <div class="container">
            <div class="section-title">
                @if($type == 1)
                    {{__('general.categories')}}
                @else
                    {{__('general.sub_category')}}
                @endif
            </div>
            <div class="infinite-scroll">
                <div class="row">
                    @foreach($records as $record)
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            @if($type == 1)
                                <a href="{{ route('categories.all' ,['country' => get_country()->code])}}?id={{$record->id}}"
                                   class="category-item">
                                    @else
                                        <a href="{{ route('products.subcategory' ,['country' => get_country()->code, 'subcategory_slug' => $record->slug ])}}"
                                           class="category-item">
                                            @endif
                                            <div class="category-img">
                                                <img src="{{asset($record->icon)}}" alt="">
                                            </div>
                                            <div class="category-title">
                                                {{$record['name_'.app()->getLocale()]}}
                                            </div>
                                        </a>
                        </div>
                    @endforeach
                </div>
                {{$records->links()}}
            </div>
        </div>
    </section>

@endsection
