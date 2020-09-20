@extends('frontend.layouts.app')

@section('title', __('general.products'))
@section('meta')
    <meta name="keywords" content="{{ $seo_setting->keyword }}">
    <meta name="description" content="{{ $seo_setting->description}}">
    <meta property="og:title" content="{{__('general.products')}}"/>
    <meta property="og:description" content="{{ $seo_setting->description}}"/>
@endsection
@section('content')
    <!-- Slider -->
    <div class="owl-carousel owl-theme category-carousel">
        <div class="item">
            <div class="slider-img">
                <img src="{{asset('assets/web/newface/images/asoggetti-qJjXwi2zNSE-unsplash.png')}}" alt="">
            </div>
        </div>
    </div>
    <!-- Categories -->
    <section>
        <div class="container">
            <ol class="breadcrumb">
                @php
                    if(isset($subcategory_id)){
                        $sub_cat = \App\SubCategory::find($subcategory_id);
                    }
                @endphp
                @if( isset($sub_cat) && $sub_cat->count() > 0)
                    <li>
                        <a href="{{ route('categories.all' ,['country' => get_country()->code])}}?id={{$sub_cat->category->id}}">{{$sub_cat->category['name_'.app()->getLocale()]}}</a>
                    </li>
                    <li class="active">{{$sub_cat['name_'.app()->getLocale()]}}</li>
                @endif
            </ol>
            <!-- Products-->
            <div class="  infinite-scroll">
            <div class="row">
                @foreach($productss as $product)
                    @include('frontend.partials.product')
                @endforeach
            </div>
                {{ $productss->links() }}
            </div>
        </div>
    </section>
@endsection

