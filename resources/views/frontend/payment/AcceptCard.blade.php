@extends('frontend.layouts.app')
@section('title' , __('general.payment') )
@section('meta')
    <meta name="keywords" content="{{ $seo_setting->keyword }}">
    <meta name="description" content="{{ $seo_setting->description}}">
<meta property="og:title" content="{{__('general.payment')}}" />
    <meta property="og:description" content="{{ $seo_setting->description}}"/>
@endsection
@section('content')
<div class="row">
<div class="col-md-2"></div>
<div class="col-md-8"></div>
<iframe width="100%" height="600px" style="margin:20px" src="https://accept.paymobsolutions.com/api/acceptance/iframes/6614?payment_token={{$token}}"></iframe>
<div class="col-md-2"></div>
</div>
@endsection
