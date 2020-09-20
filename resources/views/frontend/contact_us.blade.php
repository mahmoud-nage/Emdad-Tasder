@extends('frontend.layouts.app')
@section('title' , __('general.about_us') )
@section('meta')
    <meta name="keywords" content="{{ $seo_setting->keyword }}">
    <meta name="description" content="{{ $seo_setting->description}}">
    <meta property="og:title" content="{{__('general.about_us')}}" />
    <meta property="og:description" content="{{ $seo_setting->description}}" />
@endsection
@section('content')
    @php
        $locale = app()->getLocale();
    @endphp
    <!-- Contact -->
    <div class="container">
        <div class="page-title">{{__('general.locate_us')}}</div>
        <div id="map"></div>
        <div class="page-title">{{__('general.contact_us')}}</div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-xs-12 col-md-4 text-center">
                <div class="logo">
                    <img src="{{asset('assets/web/newface/images/logo-2.png')}}" alt="">
                </div>
                <div class="socials">
                    <a href="{{$general_setting->facebook}}" target="_blank"><span class="facebook"><i class="fa fa-facebook"></i></span></a>
                    <a href="{{$general_setting->twitter}}" target="_blank"><span class="twitter"><i class="fa fa-twitter"></i></span></a>
                    <a href="{{$general_setting->instagram}}" target="_blank"><span class="instagram"><i class="fa fa-instagram"></i></span></a>
                </div>
                <ul class="contact-menu">
                    <li>
                        <i class="fa fa-phone"></i>
                        <a href="tel:{{$general_setting->phone}}">{{$general_setting->phone}}</a>
                    </li>
                    <li>
                        <i class="fa fa-envelope"></i>
                        <a href="mailto:{{$general_setting->email}}">{{$general_setting->email}}</a>
                    </li>
                    <li>
                        <i class="fa fa-map-marker"></i>
                        <a href="#;">{{app()->getLocale() == 'ar' ? $general_setting->address_ar : $general_setting->address}}</a>
                    </li>
                </ul>            </div>
            <div class="col-xs-12 col-md-8">
                <form action="" >
                    <div class="contactUs-form">
                        <div class="form-group col-xs-12 col-sm-6">
                            <input type="text" class="form-control" name="name" placeholder="Name">
                        </div>
                        <div class="form-group col-xs-12 col-sm-6">
                            <input type="text" class="form-control" name="email" placeholder="Email">
                        </div>
                        <div class="form-group col-xs-12 col-sm-6">
                            <input type="text" class="form-control" name="phone" placeholder="Phone">
                        </div>
                        <div class="form-group col-xs-12 col-sm-6">
                            <select class="form-control" name="" >
                                <option value="" selected disabled>Are you a new client</option>
                                <option value="">Yes</option>
                                <option value="">No</option>
                            </select>
                        </div>
                        <div class="form-group col-xs-12 ">
                            <textarea class="form-control" placeholder="Message" name="message"  rows="4"></textarea>
                        </div>
                    </div>
                    <div class="text-right margin-bottom-50">
                        <button type="submit" class="btn btn-send">Send <i class="fa fa-send"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBquDo_Py_LXm6FtPQEo-LXeLjFzIopLSg&callback=myMap"></script>
@endsection
