@extends('frontend.layouts.app')
@section('title' ,\App\Policy::where('name', 'seller_policy')->first()['name_'.app()->getLocale()] )
@section('meta')
    <meta name="keywords" content="{{ $seo_setting->keyword }}">
    <meta name="description" content="{{ $seo_setting->description}}">
<meta property="og:title" content="{{\App\Policy::where('name', 'seller_policy')->first()['name_'.app()->getLocale()]}}" />
    <meta property="og:description" content="{{ $seo_setting->description}}"/>
@endsection
@section('content')

    <section class="gry-bg py-4">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="p-4 bg-white">
                        @php
                            echo \App\Policy::where('name', 'seller_policy')->first()['content_'.app()->getLocale()];
                        @endphp
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
