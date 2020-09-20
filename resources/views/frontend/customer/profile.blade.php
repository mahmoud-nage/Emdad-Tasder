@extends('frontend.layouts.app')
@section('title' , __('general.profile') )
@section('meta')
    <meta name="keywords" content="{{ $seo_setting->keyword }}">
    <meta name="description" content="{{ $seo_setting->description}}">
<meta property="og:title" content="{{__('general.profile')}}" />
    <meta property="og:description" content="{{ $seo_setting->description}}"/>
@endsection
@section('content')
   <!--</div>-->
    <!-- Page Contents Wrapper-->
   <div class="container">
       <!-- Content -->
       <div class="page-wrap">
           <!-- Menu -->
       @include('frontend.inc.customer_side_nav')
       <!--  Content -->
           <div class="main-content">
               <!-- User Info -->
               <form class="form-style" action="{{ route('customer.profile.update', ['country' => get_country()->code]) }}" method="POST"
                     enctype="multipart/form-data">
                   @csrf
                   <div class="section-wrapper">
                       <div class="section-header">
                           {{__('general.personal_information')}}
                       </div>
                       <div class="section-body">

                           <div class="row">
                               <div class="form-group col-xs-12 col-md-6">
                                   <label> {{__('forms.name')}}</label>
                                   <input type="text" class="form-control" name="name"
                                          value="{{ Auth::user()->name }}">
                               </div>
                               <div class="form-group col-xs-12 col-md-6">
                                   <label>{{__('forms.email')}}</label>
                                   <input type="text" class="form-control" name="email"
                                          value="{{ Auth::user()->email }}" disabled>
                               </div>
                               <div class="form-group col-xs-12">
                                   <label class="color-main">{{__('forms.avatar')}}</label>
                                   <div class="file-upload">
                                       <div class="file-select">
                                           <input type="file" name="photo" class="chooseFile">
                                           <div class="file-select-name noFile">{{__('general.no_chosen')}}</div>
                                           <div class="file-select-button fileName">
                                               <i class="fa fa-photo"></i>
                                               {{__('general.upload')}}
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <div class="form-group col-xs-12 col-md-6">
                                   <label>{{__('general.enter_new_password')}}</label>
                                   <input type="password" class="form-control" name="new_password"
                                          placeholder="{{__('general.enter_new_password')}}">
                               </div>
                               <div class="form-group col-xs-12 col-md-6">
                                   <label>{{__('forms.confirm_password')}}</label>
                                   <input type="password" class="form-control" name="confirm_password"
                                          placeholder="{{__('forms.confirm_password')}}">
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
                                   <label>{{__('general.address')}}</label>
                                   <input type="text" class="form-control" name="address"
                                          value="{{ Auth::user()->address }}" placeholder="{{__('general.address')}}">
                               </div>
                               <div class="form-group col-xs-12 col-md-6">
                                   <label>{{__('general.country')}}</label>
                                   <select id="country" name="country" class="form-control">
                                       <option value="">{{__('general.country')}}</option>

                                   @foreach (\App\Country::all() as $key => $country)
                                           <option
                                               value="{{ $country->code }}" <?php if (Auth::user()->country == $country->code) echo "selected";?> >{{ app()->isLocale('ar') ? $country->name_ar : $country->name_en }}</option>
                                       @endforeach
                                   </select>
                               </div>
                               <div class="form-group col-xs-12 col-md-6">
                                   <label>{{__('general.city')}}</label>
                                   <select id="city" name="city" class="form-control">
                                       <option value="">{{__('general.city')}}</option>
                                   @foreach (\App\City::all() as $key => $city)
                                           <option
                                               value="{{ $city->id }}" <?php if (Auth::user()->city == $city->id) echo "selected";?> >{{ app()->isLocale('ar') ? $city->name_ar : $city->name_en }}</option>
                                       @endforeach
                                   </select>
                               </div>
                               <!--<div class="form-group col-xs-12 col-md-6">-->
                               <!--    <label>{{__('general.area')}}</label>-->
                               <!--    <select id="area" name="area" class="form-control">-->
                               <!--        <option value="">{{__('general.zone')}}</option>-->
                               <!--    @foreach (\App\Area::all() as $key => $area)-->
                               <!--            <option-->
                               <!--                value="{{ $area->id }}" <?php if (Auth::user()->area == $area->id) echo "selected";?> >{{ app()->isLocale('ar') ? $area->name_ar : $area->name_en }}</option>-->
                               <!--        @endforeach-->
                               <!--    </select>-->
                               <!--</div>-->
                               <div class="form-group col-xs-12 col-md-6">
                                   <label>{{__('general.zone')}}</label>
                                   <select id="zone" name="zone" class="form-control">
                                       <option value="">{{__('general.zone')}}</option>
                                       @foreach (\App\Zone::all() as $key => $zone)
                                           <option
                                               value="{{ $zone->id }}" <?php if (Auth::user()->zone == $zone->id) echo "selected";?> >{{ app()->isLocale('ar') ? $zone->name_ar : $zone->name_en }}</option>
                                       @endforeach
                                   </select>
                               </div>
                               <div class="form-group col-xs-12 col-md-6">
                                   <label>{{__('general.postal_code')}}</label>
                                   <input type="number" class="form-control" name="postal_code"
                                          value="{{ Auth::user()->postal_code }}" placeholder="{{__('general.postal_code')}}">
                               </div>
                               <div class="form-group col-xs-12 col-md-6">
                                   <label>{{__('forms.phone')}}</label>
                                   <input type="text" class="form-control" name="phone"
                                          value="{{ Auth::user()->phone }}" placeholder="{{__('forms.phone')}}">
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="form-group text-center margin-50">
                       <button type="submit" class="btn btn-main btn-lg input-lg">{{__('general.save')}}</button>
                   </div>
               </form>

           </div>

       </div>
   </div>


@endsection
@section('script')
    <script>
        $("#country").change(function () {
            var options = '<option value="">{{__("general.city")}}</option>';
            var x;
            $.ajax({
                url: "{!! route('api.cities.web') !!}",
                type: 'GET',
                data: {
                    country: $("#country").val(),
                    locale: "{{ \App::getLocale() }}"
                }
            }).then((response) => {
                for (x = 0; x < response.data.length; x++) {
                    options += '<option value="' + response.data[x].id + '">' + response.data[x].name + '</option>'
                }
                $("#city").html(options);
            });
            if ($(this).val() && $("#area").val() && $("#zone").val()) {
                $("#home_btn").attr("disabled", false);
            }
        });
        $("#city").change(function () {
            var options = '<option value="">{{__("general.area")}}</option>';
            var x;
            $.ajax({
                url: "{!! route('api.areas.web') !!}",
                type: 'GET',
                data: {
                    city_id: $("#city").val(),
                    locale: "{{ \App::getLocale() }}"
                }
            }).then((response) => {
                for (x = 0; x < response.data.length; x++) {
                    options += '<option value="' + response.data[x].id + '">' + response.data[x].name + '</option>'
                }
                $("#area").html(options);
            });
            if ($(this).val() && $("#area").val() && $("#zone").val()) {
                $("#home_btn").attr("disabled", false);
            }
        });
        $("#area").change(function () {
            var options = '<option value="">{{__("general.zone")}}</option>';
            var x;
            $.ajax({
                url: "{!! route('api.zones.web') !!}",
                type: 'GET',
                data: {
                    area_id: $("#area").val(),
                    locale: "{{ \App::getLocale() }}"
                }
            }).then((response) => {
                for (x = 0; x < response.data.length; x++) {
                    options += '<option value="' + response.data[x].id + '">' + response.data[x].name + '</option>'
                }
                $("#zone").html(options);
            })
            if ($(this).val() && $("#city").val() && $("#zone").val()) {
                $("#home_btn").attr("disabled", false);
            }
        });
    </script>
@stop
