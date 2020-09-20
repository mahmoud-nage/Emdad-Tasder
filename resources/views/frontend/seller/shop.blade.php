@extends('frontend.layouts.app')
@section('title' , __('general.shop_setting') )
@section('meta')
<meta name="keywords" content="{{ $seo_setting->keyword }}">
<meta name="description" content="{{ $seo_setting->description}}">
<meta property="og:title" content="{{__('general.shop_setting')}}" />
<meta property="og:description" content="{{ $seo_setting->description}}" />
@endsection
@section('content')

<div class="container-fluid">
    <!-- Content -->

    <div class="page-wrap profile-page">
        <!-- Menu -->
        @include('frontend.inc.seller_side_nav')
        <!--  Content -->
        <div class="main-content">
            @include('partials.message')

            <!--  Personal information  -->
            <div class="profile-title">
                {{__('general.shop_setting')}}
            </div>

            <form class="form-style" action="{{ route('shops.update', ['country' => get_country()->code, 'id'=>$shop->id]) }}" method="POST"
                enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PATCH">
                @csrf
                <div class="section-wrapper">
                    <div class="section-header">
                        {{__('general.basic_info')}}
                    </div>
                    <div class="section-body">
                        <div class="row">
                            <div class="form-group col-xs-12 ">
                                <label>{{__('general.shop_name')}}<span class="text-muted font-size-12">*</span></label>
                                <input type="text" class="form-control mb-3" placeholder="{{__('general.shop_name')}}"
                                    name="name" value="{{ $shop->name }}" required>
                            </div>
                            <div class="form-group col-xs-12">
                                <label class="color-main">{{__('general.image')}}
                                    <span class="text-muted font-size-12">*</span>
                                    <br><span class="text-muted font-size-12">Ext Only:
                                        (jpg|jpeg|png|tiff|webp|gif)</span>
                                    <br><span class="text-muted font-size-12">Best Size: (100*100)</span>
                                </label>
                                <div class="file-upload">
                                    <div class="file-select">
                                        <input type="file" name="logo" id="file-2"
                                            class="custom-input-file custom-input-file--4"
                                            data-multiple-caption="{count} files selected" accept="image/*" />
                                        <div class="file-select-name noFile">{{__('general.no_chosen')}}</div>
                                        <div class="file-select-button fileName">
                                            <i class="fa fa-photo"></i>
                                            Upload
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-xs-12">
                                <label>{{__('general.address')}}<span class="text-muted font-size-12">*</span></label>
                                <input type="text" class="form-control mb-3" placeholder="{{__('general.address')}}"
                                    name="address" value="{{ $shop->address }}" required>
                            </div>
                            <div class="form-group col-xs-12 ">
                                <label>{{__('general.country')}}<span class="text-muted font-size-12">*</span></label>
                                <div class="form-group">
                                    <select name="country_code" class="form-control">
                                        <option value="{{get_country()->code}}">
                                            {{get_country()['name_'.app()->getLocale()]}}</option>
                                    </select required>
                                    @error('country_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-xs-12">
                                <label>{{__('general.meta_title')}}</label>
                                <input type="text" class="form-control mb-3" placeholder="{{__('general.meta_title')}}"
                                    name="meta_title" value="{{ $shop->meta_title }}" required>
                            </div>
                            <div class="form-group col-xs-12">
                                <label>{{__('general.meta_description')}}</label>
                                <textarea name="meta_description" rows="6" class="form-control mb-3"
                                    required>{{ $shop->meta_description }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-main btn-lg input-lg"> {{__('general.save')}}</button>
                </div>
                <!-- Slider Settings  -->
            </form>

            <form class="form-style" action="{{ route('shops.update', ['country' => get_country()->code, 'id'=>$shop->id]) }}" method="POST"
                enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PATCH">
                @csrf
                <div class="section-wrapper">
                    <div class="section-header">
                        {{__('general.slider_setting')}}
                    </div>

                    <div class="section-body">
                        <div class="row">
                            <div class="form-group col-xs-12">
                                <label class="color-main">{{__('general.slider_setting')}} <span
                                        class="d-inline-block color-gray font-size-10">1400*400 </span></label>
                                <div class="offset-2 offset-md-0 col-10 col-md-10">
                                    <div class="row">
                                        @if ($shop->sliders != null)
                                        @foreach (json_decode($shop->sliders) as $key => $sliders)
                                        <div class="col-md-6">
                                            <div class="img-upload-preview">
                                                <img src="{{ asset($sliders) }}" alt="" class="img-fluid" width="200">
                                                <input type="hidden" name="previous_sliders[]" value="{{ $sliders }}">
                                                <button type="button" class="btn btn-danger close-btn remove-files"><i
                                                        class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                    <div class="row images-slider">
                                        <div class="col-md-3">
                                            <input type="file" name="sliders[]" id="slide-0" class="dropify"
                                                data-multiple-caption="{count} files selected" multiple
                                                accept="image/*" />
                                        </div>

                                    </div>
                                    <button type="button" class="btn btn-primary" onclick="add_more_slider_image()">
                                        <i class="fa fa-plus"></i></button>

                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="form-group text-center margin-50">
                    <button type="submit" class="btn btn-main btn-lg input-lg"> {{__('general.save')}}</button>
                </div>
            </form>
            <!--<form class="form-style" action="{{ route('shops.update', ['country' => get_country()->code, 'id'=>$shop->id]) }}" method="POST" enctype="multipart/form-data">-->
            <!--    <input type="hidden" name="_method" value="PATCH">-->
            <!--    @csrf-->
            <!--    <div class="section-wrapper">-->
            <!--        <div class="section-header">-->
            <!--            {{__('Social Media Link')}}-->
            <!--        </div>-->
            <!--        <div class="section-body">-->
            <!--            <div class="row">-->
            <!--                <div class="form-group">-->
            <!--                    <label ><i class="line-height-1_8 size-24 mr-2 fa fa-facebook bg-facebook c-white text-center"></i>{{__('Facebook')}} </label>-->
            <!--                    <input type="text" class="form-control mb-3" placeholder="{{__('Facebook')}}" name="facebook" value="{{ $shop->facebook }}">-->
            <!--                </div>-->
            <!--                <div class="form-group">-->
            <!--                    <label><i class="line-height-1_8 size-24 mr-2 fa fa-twitter bg-twitter c-white text-center"></i>{{__('Twitter')}} </label>-->
            <!--                    <input type="text" class="form-control mb-3" placeholder="{{__('Twitter')}}" name="twitter" value="{{ $shop->twitter }}">-->
            <!--                </div>-->
            <!--                <div class="form-group">-->
            <!--                    <label><i class="line-height-1_8 size-24 mr-2 fa fa-instagram bg-instagram c-white text-center"></i>{{__('Instagram')}} </label>-->
            <!--                    <input type="text" class="form-control mb-3" placeholder="{{__('Instagram')}}" name="instagram" value="{{ $shop->instagram }}">-->
            <!--                </div>-->
            <!--                <div class="form-group">-->
            <!--                    <label><i class="line-height-1_8 size-24 mr-2 fa fa-google bg-google c-white text-center"></i>{{__('Google')}} </label>-->
            <!--                    <input type="text" class="form-control mb-3" placeholder="{{__('Google')}}" name="google" value="{{ $shop->google }}">-->
            <!--                </div>-->
            <!--                <div class="form-group">-->
            <!--                    <label><i class="line-height-1_8 size-24 mr-2 fa fa-instagram bg-instagram c-white text-center"></i>{{__('Instagram')}} </label>-->
            <!--                    <input type="text" class="form-control mb-3" placeholder="{{__('Instagram')}}" name="instagram" value="{{ $shop->instagram }}">-->
            <!--                </div>-->
            <!--                <div class="form-group">-->
            <!--                    <label><i class="line-height-1_8 size-24 mr-2 fa fa-google bg-google c-white text-center"></i>{{__('Google')}} </label>-->
            <!--                    <input type="text" class="form-control mb-3" placeholder="{{__('Google')}}" name="google" value="{{ $shop->google }}">-->
            <!--                </div>-->
            <!--                <div class="form-group">-->
            <!--                    <label><i class="line-height-1_8 size-24 mr-2 fa fa-youtube bg-youtube c-white text-center"></i>{{__('Youtube')}} </label>-->
            <!--                    <input type="text" class="form-control mb-3" placeholder="{{__('Youtube')}}" name="youtube" value="{{ $shop->youtube }}">-->
            <!--                </div>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--    <div class="form-group text-center margin-50">-->
            <!--        <button type="submit" class="btn btn-main btn-lg input-lg"> Save</button>-->
            <!--    </div>-->
            <!--</form>-->
        </div>
    </div>
</div>
<div style="position: relative;bottom: -40px;">
    @include('frontend.seller.footer_tabs')
</div>
@endsection

@section('script')
<script>
    function add_more_slider_image(){
            var shopSliderAdd =  '<div class="col-md-3">\n' +
                '<input type="file" name="sliders[]" id="slide-0" class="dropify" data-multiple-caption="{count} files selected" multiple accept="image/*" />\n' +
                '</div>';
            $('.images-slider').append(shopSliderAdd);

            $('.dropify').dropify();
        }
        function delete_this_row(em){
            $(em).closest('.row').remove();
        }


        $(document).ready(function(){
            $('.remove-files').on('click', function(){
                $(this).parents(".col-md-6").remove();
            });
        });
</script>
@endsection