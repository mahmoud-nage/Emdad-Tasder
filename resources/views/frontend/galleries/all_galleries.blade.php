@extends('frontend.layouts.app')
@section('title' , __('general.galleries') )
@section('meta')
    <meta name="keywords" content="{{ $seo_setting->keyword }}">
    <meta name="description" content="{{ $seo_setting->description}}">
    <meta property="og:title" content="{{__('general.galleries')}}"/>
    <meta property="og:description" content="{{ $seo_setting->description}}"/>
@endsection
@section('content')
    <!-- Contact -->
    <div class="container">
        <div class="page-title">{{__('general.galleries')}}</div>
    </div>
    <!---->
    <div class="container">
        <div class="gallery-row">
            @foreach($galleries as $item)
            <div class="gallery-column">
                <div class="gallery-item">
                    <div class="gallery-img">
                        <img src="{{asset(json_decode($item->photos)[0])}}" alt="">
                    </div>
                    <div class="gallery-title">
                        {{$item['name_'.app()->getLocale()]}}
                    </div>
                    <a href="{{route('singel_gallery', ['id'=>$item->id, 'country'=>get_country()->id])}}">{{__('general.open')}}</a>
                </div>
{{--                <div class="gallery-item">--}}
{{--                    <div class="gallery-img">--}}
{{--                        <img src="assets/images/marta-jastrzebska-tF4SUj74Sb0-unsplash.png" alt="">--}}
{{--                    </div>--}}
{{--                    <div class="gallery-title">--}}
{{--                        Exporting--}}
{{--                    </div>--}}
{{--                    <a href="gallery-details.html">open</a>--}}
{{--                </div>--}}
{{--                <div class="gallery-item">--}}
{{--                    <div class="gallery-img">--}}
{{--                        <img src="assets/images/jason-leung-cUwd97yz2Bg-unsplash.png" alt="">--}}
{{--                    </div>--}}
{{--                    <div class="gallery-title">--}}
{{--                        Exporting--}}
{{--                    </div>--}}
{{--                    <a href="gallery-details.html">open</a>--}}
{{--                </div>--}}
{{--                <div class="gallery-item">--}}
{{--                    <div class="gallery-img">--}}
{{--                        <img src="assets/images/kelly-sikkema-94_X77ZnRRo-unsplash.png" alt="">--}}
{{--                    </div>--}}
{{--                    <div class="gallery-title">--}}
{{--                        Exporting--}}
{{--                    </div>--}}
{{--                    <a href="gallery-details.html">open</a>--}}
{{--                </div>--}}
            </div>
            @endforeach
{{--            <div class="gallery-column">--}}
{{--                <div class="gallery-item">--}}
{{--                    <div class="gallery-img">--}}
{{--                        <img src="assets/images/marta-jastrzebska-tF4SUj74Sb0-unsplash.png" alt="">--}}
{{--                    </div>--}}
{{--                    <div class="gallery-title">--}}
{{--                        Exporting--}}
{{--                    </div>--}}
{{--                    <a href="gallery-details.html">open</a>--}}
{{--                </div>--}}
{{--                <div class="gallery-item">--}}
{{--                    <div class="gallery-img">--}}
{{--                        <img src="assets/images/jason-leung-cUwd97yz2Bg-unsplash.png" alt="">--}}
{{--                    </div>--}}
{{--                    <div class="gallery-title">--}}
{{--                        Exporting--}}
{{--                    </div>--}}
{{--                    <a href="gallery-details.html">open</a>--}}
{{--                </div>--}}
{{--                <div class="gallery-item">--}}
{{--                    <div class="gallery-img">--}}
{{--                        <img src="assets/images/asoggetti-qJjXwi2zNSE-unsplash.png" alt="">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="gallery-item">--}}
{{--                    <div class="gallery-img">--}}
{{--                        <img src="assets/images/kelly-sikkema-94_X77ZnRRo-unsplash.png" alt="">--}}
{{--                    </div>--}}
{{--                    <div class="gallery-title">--}}
{{--                        Exporting--}}
{{--                    </div>--}}
{{--                    <a href="gallery-details.html">open</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="gallery-column">--}}
{{--                <div class="gallery-item">--}}
{{--                    <div class="gallery-img">--}}
{{--                        <img src="assets/images/kelly-sikkema-94_X77ZnRRo-unsplash.png" alt="">--}}
{{--                    </div>--}}
{{--                    <div class="gallery-title">--}}
{{--                        Exporting--}}
{{--                    </div>--}}
{{--                    <a href="gallery-details.html">open</a>--}}
{{--                </div>--}}
{{--                <div class="gallery-item">--}}
{{--                    <div class="gallery-img">--}}
{{--                        <img src="assets/images/asoggetti-qJjXwi2zNSE-unsplash.png" alt="">--}}
{{--                    </div>--}}
{{--                    <div class="gallery-title">--}}
{{--                        Exporting--}}
{{--                    </div>--}}
{{--                    <a href="gallery-details.html">open</a>--}}
{{--                </div>--}}
{{--                <div class="gallery-item">--}}
{{--                    <div class="gallery-img">--}}
{{--                        <img src="assets/images/marta-jastrzebska-tF4SUj74Sb0-unsplash.png" alt="">--}}
{{--                    </div>--}}
{{--                    <div class="gallery-title">--}}
{{--                        Exporting--}}
{{--                    </div>--}}
{{--                    <a href="gallery-details.html">open</a>--}}
{{--                </div>--}}
{{--                <div class="gallery-item">--}}
{{--                    <div class="gallery-img">--}}
{{--                        <img src="assets/images/jason-leung-cUwd97yz2Bg-unsplash.png" alt="">--}}
{{--                    </div>--}}
{{--                    <div class="gallery-title">--}}
{{--                        Exporting--}}
{{--                    </div>--}}
{{--                    <a href="gallery-details.html">open</a>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
    <!-- Footer -->
@endsection
