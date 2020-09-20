@extends('frontend.layouts.app')
@section('title' , __('general.profile') )
@section('meta')
    <meta name="keywords" content="{{ $seo_setting->keyword }}">
    <meta name="description" content="{{ $seo_setting->description}}">
<meta property="og:title" content="{{__('general.profile')}}" />
    <meta property="og:description" content="{{ $seo_setting->description}}"/>
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

                <form class="form-style" action="{{ route('seller.profile.update', ['country' => get_country()->code]) }}" method="POST"
                      enctype="multipart/form-data">
                @csrf
                <!--  Personal information  -->
                    <div class="profile-title">
                        {{__('general.manage_profile')}}
                    </div>
                    <!-- User Info -->
                    <div class="section-wrapper">
                        <div class="section-header">
                            {{__('general.personal_information')}}
                        </div>
                        <div class="section-body">
                            <div class="row">
                                <div class="form-group col-xs-12 col-md-6">
                                    <label> {{__('forms.name')}}<span class="text-muted font-size-12">*</span></label>
                                    <input type="text" class="form-control mb-3" placeholder="{{__('forms.name')}}" name="name" value="{{ Auth::user()->name }}" required>
                                </div>
                                <div class="form-group col-xs-12 col-md-6">
                                    <label>{{__('forms.email')}}<span class="text-muted font-size-12">*</span></label>
                                    <input type="email" class="form-control mb-3" placeholder="{{__('forms.email')}}" name="email" value="{{ Auth::user()->email }}" required>
                                </div>
                                <div class="form-group col-xs-12">
                                    <label class="color-main">{{__('forms.avatar')}}
                                                                                                            <span class="text-muted font-size-12">*</span>
                                    <br><span class="text-muted font-size-12">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</span>
                                    <br><span class="text-muted font-size-12">Best Size: (100*100)</span></label>
                                    <div class="file-upload">
                                        <div class="file-select">
                                            <input type="file" name="photo" id="file-3" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" accept="image/*" />
                                            <div class="file-select-name noFile">{{__('general.no_chosen')}}</div>
                                            <div class="file-select-button fileName">
                                                <i class="fa fa-photo"></i>
                                                {{__('general.upload')}}
                                            </div>
                                        </div>
                                    </div>
                                                                        <div class="col-xs-12">
                                    <hr>
                                                @if (auth()->user()->avatar != null)
                                                    <div class="col-sm-3 col-xs-6">
                                                        <div class="img-upload-preview">
                                                            <img src="{{ asset(auth()->user()->avatar) }}" alt="" class="img-responsive">
                                                            <input type="hidden" name="previous_featured_img" value="{{ auth()->user()->avatar }}">
                                                            <button type="button" class="btn btn-danger close-btn remove-files"><i
                                                        class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                    @endif

                                                    </div>
                                </div>
                                <div class="form-group col-xs-12 col-md-6">
                                    <label>{{__('general.enter_new_password')}}</label>
                                    <input type="password" class="form-control mb-3" placeholder="{{__('general.enter_new_password')}}" name="new_password">
                                </div>
                                <div class="form-group col-xs-12 col-md-6">
                                    <label>{{__('forms.confirm_password')}}</label>
                                    <input type="password" class="form-control mb-3" placeholder="{{__('forms.confirm_password')}}" name="confirm_password">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Shopping info -->
                    <div class="section-wrapper">
                        <div class="section-header">
                            {{__('general.shipping_info')}}
                        </div>
                        <div class="section-body">
                            <div class="row">
                                <div class="form-group col-xs-12 ">
                                    <label>{{__('general.address')}}<span class="text-muted font-size-12">*</span></label>
                                    <textarea class="form-control textarea-autogrow mb-3" placeholder="{{__('general.address')}}" rows="1" name="address" required>{{ Auth::user()->address }}</textarea>
                                </div>
                                <div class="form-group col-xs-12 col-md-6">
                                    <label>{{__('general.country')}}<span class="text-muted font-size-12">*</span></label>
                                    <select class="form-control" data-placeholder="{{__('Select your country')}}" name="country" required>
                                        @foreach (\App\Country::all() as $key => $country)
                                            <option value="{{ $country->code }}" <?php if(Auth::user()->country == $country->code) echo "selected";?> >{{ app()->isLocale('ar') ? $country->name_ar : $country->name_en }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-xs-12 col-md-6">
                                    <label>{{__('general.city')}}<span class="text-muted font-size-12">*</span></label>
                                    <input type="text" class="form-control mb-3" placeholder="{{__('general.city')}}" name="city" value="{{ Auth::user()->city }}" required>
                                </div>
                                <div class="form-group col-xs-12 col-md-6">
                                    <label>{{__('general.postal_code')}}</label>
                                    <input type="text" class="form-control mb-3" placeholder="{{__('general.postal_code')}}" name="postal_code" value="{{ Auth::user()->postal_code }}">
                                </div>
                                <div class="form-group col-xs-12 col-md-6">
                                    <label>{{__('forms.phone')}}<span class="text-muted font-size-12">*</span></label>
                                    <input type="text" class="form-control mb-3" placeholder="{{__('forms.phone')}}" name="phone" value="{{ Auth::user()->phone }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Payment Settings  -->
                    <div class="section-wrapper payment-setting">
                        <div class="section-header">
                            {{__('general.payment')}}
                        </div>

                        <div class="section-body">
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6">
                                    <label>{{__('general.postal')}}</label>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <label class="switch">
                                        <input value="1" name="postal_status" type="checkbox" @if (Auth::user()->seller->postal_status == 1) checked @endif>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                                                         <div class="row form-group">
                                <div class="col-xs-12 col-sm-6">
                                    <label>{{__('general.full_name')}}</label>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <input type="text" class="form-control mb-3" placeholder="{{__('general.full_name')}}" value="{{ Auth::user()->seller->postal_client_name }}" name="postal_client_name">
                                </div>
                            </div>
                                                        <div class="row form-group">
                                <div class="col-xs-12 col-sm-6">
                                    <label>{{__('general.national_id')}}</label>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <input type="text" class="form-control mb-3" placeholder="{{__('general.national_id')}}" value="{{ Auth::user()->seller->postal_national_id }}" name="postal_national_id">
                                </div>
                            </div>
                           
                        <hr>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6">
                                    <label>{{__('general.vodafone_cache')}}</label>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <label class="switch">
                                        <input value="1" name="vodafone_status" type="checkbox" @if (Auth::user()->seller->vodafone_status == 1) checked @endif>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6">
                                    <label>{{__('general.vodafone_number')}}</label>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <input type="text" class="form-control mb-3" placeholder="{{__('general.vodafone_number')}}" value="{{ Auth::user()->seller->vodafone_number }}" name="vodafone_number">
                                </div>
                            </div>
                            <hr>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6">
                                    <label>{{__('general.bank')}}</label>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <label class="switch">
                                        <input value="1" name="bank_account_status" type="checkbox" @if (Auth::user()->seller->bank_account_status == 1) checked @endif>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6">
                                    <label>{{__('general.bank_name')}}</label>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <input type="text" class="form-control mb-3" placeholder="{{__('general.bank_name')}}" value="{{ Auth::user()->seller->bank_name }}" name="bank_name">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6">
                                    <label>{{__('general.branch_name')}}</label>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <input type="text" class="form-control mb-3" placeholder="{{__('general.branch_name')}}" value="{{ Auth::user()->seller->bank_branch }}" name="bank_branch">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6">
                                    <label>{{__('general.bank_account_username')}}</label>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <input type="text" class="form-control mb-3" placeholder="{{__('general.bank_account_username')}}" value="{{ Auth::user()->seller->bank_account_username }}" name="bank_account_username">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-xs-12 col-sm-6">
                                    <label>{{__('general.bank_account_number')}}</label>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <input type="text" class="form-control mb-3" placeholder="{{__('general.bank_account_number')}}" value="{{ Auth::user()->seller->bank_account_number }}" name="bank_account_number">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center margin-50">
                        <button type="submit" class="btn btn-main btn-lg input-lg"> {{__('general.save')}}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div style="position: relative;bottom: -40px;">
        @include('frontend.seller.footer_tabs')
    </div>
@endsection

@section('script')
<script>
                  $(document).ready(function(){
            $('.remove-files').on('click', function(){
                console.log('okkkk');
                $(this).parents(".col-sm-3").remove();
                $('#btn-add button').css('display', 'block');
            });
        });
</script>
@endsection
