@extends('frontend.layouts.app')
@section('title' , __('forms.shop_info'))
@section('meta')
<meta name="keywords" content="{{ $seo_setting->keyword }}">
<meta name="description" content="{{ $seo_setting->description}}">
<meta property="og:title" content="{{__('forms.shop_info')}}" />
<meta property="og:description" content="{{ $seo_setting->description}}" />
@endsection
@section('content')
    <div class="container" style="padding-top: 50px">
                @include('partials.message')

        <!-- Content -->
        <!--  Personal information  -->
        <div class="profile-title">
            <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                {{__('forms.shop_info')}}
            </h2>
        </div>
        <!-- User Info -->
        <form action="{{ route('shops.store',['country' => get_country()->code]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @if (!Auth::check())
                <div class="section-wrapper">
                    <div class="section-header">
                        {{__('forms.user_info')}}
                    </div>
                    <div class="section-body">
                        <div class="form-style">
                            <div class="row">
                                <div class="form-group col-xs-12 col-md-6">
                                    <div class="input-group">
                                <span class="input-group-addon">
                                    <img src="{{ asset('assets/seller/images/user1.png') }}" alt="">
                                </span>
                                        <input type="text"
                                               class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                               value="{{ old('name') }}" placeholder="{{ __('forms.name') }}"
                                               name="name">
                                    </div>
                                </div>
                                <div class="form-group col-xs-12 col-md-6">
                                    <div class="input-group">
                                <span class="input-group-addon">
                                    <img src="{{ asset('assets/seller/images/envelope.png') }}" alt="">
                                </span>
                                        <input type="email"
                                               class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                               value="{{ old('email') }}" placeholder="{{ __('forms.email') }}"
                                               name="email">
                                    </div>
                                </div>
                                <div class="form-group col-xs-12 col-md-6">
                                    <div class="input-group">
                                <span class="input-group-addon">
                                    <img src="{{ asset('assets/seller/images/lock.png') }}" alt="">
                                </span>
                                        <input type="password"
                                               class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                               placeholder="{{ __('forms.password') }}" name="password">
                                    </div>
                                </div>
                                <div class="form-group col-xs-12 col-md-6">
                                    <div class="input-group">
                                <span class="input-group-addon">
                                    <img src="{{ asset('assets/seller/images/lock.png') }}" alt="">
                                </span>
                                        <input type="password" class="form-control"
                                               placeholder="{{ __('forms.conf_pass') }}"
                                               name="password_confirmation">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="section-wrapper">
                <div class="section-header">
                    {{__('forms.basic_info')}}
                </div>
                <div class="section-body">
                    <div class="form-style">
                        <div class="row">
                            <div class="form-group col-xs-12 ">
                                <label>{{__('forms.shop_name')}}<span class="text-muted font-size-12">*</span></label>
                                <input type="text" class="form-control mb-3 @error('name') is-invalid @enderror" placeholder="{{__('forms.shop_name')}}"
                                       name="name" required>
                                    @error('name')
                                       <span class="invalid-feedback" role="alert">
                                           <strong>{{ $message }}</strong>
                                       </span>
                                     @enderror
                            </div>
                            <div class="form-group col-xs-12 ">
                                <label>{{__('forms.shop_address')}}<span class="text-muted font-size-12">*</span></label>
                                <input type="text" class="form-control mb-3 @error('address') is-invalid @enderror" placeholder="{{__('forms.shop_address')}}"
                                       name="address" required>
                                       @error('address')
                                       <span class="invalid-feedback" role="alert">
                                           <strong>{{ $message }}</strong>
                                       </span>
                                     @enderror
                            </div>
                            <div class="form-group col-xs-12 ">
                                <label>{{__('general.country')}}<span class="text-muted font-size-12">*</span></label>
                                <div class="form-group">
                                    <select name="country_code" class="form-control">
                                        @foreach ($countries as $item) 
                                            <option value="{{$item->code}}">{{$item['name_'.app()->getLocale()]}}</option>
                                        @endforeach
                                    </select required>
                                       @error('country_code')
                                       <span class="invalid-feedback" role="alert">
                                           <strong>{{ $message }}</strong>
                                       </span>
                                     @enderror
                            </div>
                            </div>
                            <div class="form-group col-xs-12">
                                <label class="color-main">{{__('forms.upload_logo')}}
                                    <span class="text-muted font-size-12">*</span>
                                    <br><span class="text-muted font-size-12">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</span>
                                    <br><span class="text-muted font-size-12">Best Size: (100*100)</span>
                                    </label>
                                <div class="file-upload">
                                    <div class="file-select">
                                        <input type="file" name="logo" id="file-2" id="photos_image_file"
                                               class="custom-input-file custom-input-file--4 @error('logo') is-invalid @enderror"
                                               data-multiple-caption="{count} files selected" accept="image/*" onchange="update_file('photos_image_file','photos_msg')"  required/>
                                               @error('logo')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                                        <div class="file-select-name noFile" id="photos_msg">{{__('general.no_chosen')}}</div>
                                        <div class="file-select-button fileName">
                                            <img src="{{ asset('assets/seller/images/upload-logo.png') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group text-center margin-50">
                <button type="submit" class="btn btn-main btn-lg input-lg"> {{__('general.register')}}</button>
            </div>
            <!-- pharmacy info -->
        </form>
    </div>


@endsection

@section('script')
<script>
        function update_file(upload_id,msg_id){
                var filename = $('#'+upload_id).val();
                filename = filename.substr(12);
                console.log(filename);
                $('#'+msg_id).html(filename);
    }
</script>
@endsection
