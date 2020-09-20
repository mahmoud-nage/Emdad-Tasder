@extends('frontend.layouts.app')
@section('title' , __('general.blogs'))
@section('meta')
<meta name="keywords" content="{{ $seo_setting->keyword }}">
<meta name="description" content="{{ $seo_setting->description}}">
<meta property="og:title" content="{{__('general.blogs')}}" />
<meta property="og:description" content="{{ $seo_setting->description}}" />
@endsection
@section('content')

    <div class="articles-container">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-8 col-lg-9">
                    <!--  Main Slider  -->
                    <div class="owl-carousel owl-theme articles-slider">
                        @foreach($blogSliders as $index=>$blog)
                            <div class="item">
                                <a href="{{route('blogShow', ['country' => get_country()->code, 'id'=>$blog->id])}}" class="article-slider-item">
                                    <div class="article-slider-img">
                                        <img src="{{ asset($blog->image) }}" alt="">
                                    </div>
                                    <div class="article-slider-content">
                                        <div class="article-slider-title">
                                            {{ app()->isLocale('ar') ? $blog->title_ar : $blog->title }}
                                        </div>
                                        <div class="article-slider-text">
                                            {{ app()->isLocale('ar') ? $blog->article_ar : $blog->article }}
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                @foreach($blogDepartments as $blogDepartment)
                    <!--  Section title  -->
                        <div class="articles-section-title">
                <span>
                                            {{ app()->isLocale('ar') ? $blogDepartment->name_ar : $blogDepartment->name_en }}
                </span>
                            <a href="#">المزيد</a>
                        </div>
                        <!--  Articles  -->
                        <div class="row">
                            @foreach($blogDepartment->blogs as $blog)
                                <div class="col-xs-12 col-sm-6 wow fadeInUp" data-wow-delay="0.2s">
                                    <a href="{{route('blogShow', ['country' => get_country()->code, 'id'=>$blog->id])}}" class="article-item">
                                        <div class="article-img">
                                            <img src="{{ asset($blog->image)}}" alt="">
                                        </div>
                                        <div class="article-details">
                                            <div class="article-category"></div>
                                            <div>
                                                <span
                                                    class="article-date"> {{Carbon\Carbon::parse($blog->created_at)->diffForHumans()}} </span>
                                            </div>
                                        </div>
                                        <div class="article-title">
                                            {{ app()->isLocale('ar') ? $blog->title_ar : $blog->title }}
                                        </div>
                                        <div class="article-text">
                                            {{ app()->isLocale('ar') ? $blog->article_ar : $blog->article }}
                                        </div>
                                    </a>
                                </div>
                            @endforeach

                        </div>

                        <!--  Ad 728 * 90  -->
                        {{--                            <div class="ad-728-90 visible-lg">--}}
                        {{--                                <img src="{{ asset('assets/web/newface/images/12339668779209334709.png') }}" alt="">--}}
                        {{--                            </div>--}}
                    @endforeach

                </div>
                <div class="col-xs-12 col-md-4 col-lg-3">
                    <!--  Section title  -->
                    <div class="articles-section-title articles-side">
                <span>
                     {{__('general.most_read')}}
                </span>
                    </div>
                    <!--  Articles  -->
                    <div class="row">
                        @foreach($moreReads as $blog)
                            <div class="col-xs-12">
                                <a href="{{route('blogShow', ['country' => get_country()->code, 'id'=>$blog->id])}}" class="article-side">
                                    <div class="article-img">
                                        <img src="{{ asset($blog->image) }}" alt="">
                                    </div>
                                    <div class="article-text">
                                        {{ app()->isLocale('ar') ? $blog->article_ar : $blog->article }}
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                {{--                    <!--  Ad 300 * 250  -->--}}
                {{--                    <div class="ad-300-250">--}}
                {{--                        <img src="{{ asset('assets/web/newface/images/13020462563165376058.png') }}" alt="">--}}
                {{--                    </div>--}}

                <!--  Section title  -->
                    <div class="articles-section-title articles-side">
                <span>
                    {{__('general.other_blog')}}
                </span>
                    </div>
                    <!--  Articles  -->
                    <div class="row">
                        @foreach($otherBlogs as $blog)
                            <div class="col-xs-12">
                                <a href="{{route('blogShow', ['country' => get_country()->code, 'id'=>$blog->id])}}" class="article-side">
                                    <div class="article-img">
                                        <img src="{{ asset($blog->image) }}" alt="">
                                    </div>
                                    <div class="article-text">
                                        {{ app()->isLocale('ar') ? $blog->article_ar : $blog->article }}
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <!--  Ad 300 * 250  -->
                    <div class="ad-300-250">
                        <img src="{{ asset('assets/web/newface/images/13020462563165376058.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
