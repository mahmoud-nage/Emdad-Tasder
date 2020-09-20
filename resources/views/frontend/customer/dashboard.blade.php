@extends('frontend.layouts.app')
@section('title' , __('general.dashboard') )
@section('meta')
    <meta name="keywords" content="{{ $seo_setting->keyword }}">
    <meta name="description" content="{{ $seo_setting->description}}">
<meta property="og:title" content="{{__('general.dashboard')}}" />
    <meta property="og:description" content="{{ $seo_setting->description}}"/>
@endsection
@section('content')
    <!-- Page Contents Wrapper-->
    <div class="container">
        <!-- Content -->
        <div class="page-wrap">
            <!-- Menu -->
            @include('frontend.inc.customer_side_nav')
            <!--  Content -->
            <div class="main-content">
                @include('partials.message')

                <!--  Dashboard  -->
                <div class="profile-title">
                    {{__('general.dashboard')}}
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-lg-4">
                        <a href="{{ route('cart', ['country' => get_country()->code]) }}" class="" type="button">
                        <div class="dashboard-user dashboard-stat stat-products">
                            <div class="stat-number">
                                @if(Session::has('cart_'.session()->get('country')))
                                    <span class="d-block title">{{ count(Session::get('cart_'.session()->get('country')))}} </span>
                                @else
                                    <span class="d-block title">0 </span>
                                @endif
                            </div>
                            <div class="stat-title">
                                <img src="{{ asset('assets/web/images/cart.png') }}" alt="">
                                {{__('general.products_in_cart')}}
                            </div>

                        </div>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-lg-4">
                        <a href="{{ route('wishlists.index', ['country' => get_country()->code]) }}">
                        <div class="dashboard-user dashboard-stat stat-favorites">
                            <div class="stat-number">
                                <span class="counter">{{ count(Auth::user()->wishlists)}}</span>
                            </div>
                            <div class="stat-title">
                                <img src="{{ asset('assets/web/images/heart.svg') }}" alt="">
                                {{__('general.products_in_fav')}}
                            </div>

                        </div>
                    </a>
                    </div>
                    @php
                        $orders = \App\Order::where('user_id', Auth::user()->id)->pluck('id')->toArray();
                        $order_products = \App\OrderDetail::whereIn('order_id' , $orders)->count();
                    @endphp
                    <div class="col-xs-12 col-sm-6 col-lg-4">
                        <a href="{{ route('purchase_history.index', ['country' => get_country()->code]) }}">
                        <div class="dashboard-user dashboard-stat stat-orders2">
                            <div class="stat-number">
                                <span class="counter">{{ $order_products }}</span>
                            </div>
                            <div class="stat-title">
                                <img src="{{ asset('assets/web/images/your-order.svg') }}" alt="">
                                {{__('general.your_orders')}}
                            </div>

                        </div>
                    </a>
                    </div>
                </div>




                <br><br>
                @if(Auth::user()->addresses()->where('country_id', get_country()->id)->count()==0)

                <div class="no-address">
                    <img src="{{ asset('assets/web/newface/images/address.png') }}" alt="No Address">
                    <div class="margin-10">
                        No Address
                    </div>
                </div>
                <div class="form-group text-center">
                    <a class="btn btn-success "
                        type="button" data-toggle="modal" data-target="#addressModal">{{__('general.add_new_address')}}</a>
                </div>
                @else
                
                <div class="clearfix"></div>
                <div class="col-sm-6 col-xs-12">
                    <h4 style="color: #aaa">{{__('general.saved_address')}}</h4>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <a class="btn btn-success " style="@if(app()->getLocale() == 'ar') float:left @else float:right @endif"
                        type="button" data-toggle="modal" data-target="#addressModal">{{__('general.add_new_address')}}</a>
                </div>
                <div class="clearfix"></div>
                
                <div class="margin-10">
                    @if(Auth::user()->addresses->where('country_id', get_country()->id)->count()>0)
                    @foreach (Auth::user()->addresses()->where('country_id', get_country()->id)->orderBy('id','desc')->get() as $Address)
                
                <label class="delivery-address-container" id="address{{$Address->id}}">
                        <div class="order-summery">
                            <div class="title">{{__('general.address')}}</div>
                            <div class="price">{{ $Address->address_details }}</div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="order-summery">
                                    <div class="title">{{__('general.country')}}</div>
                                    <div class="price">
                                        {{$Address->city_id?$Address->City->country['name_'.app()->getLocale()]:'' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="order-summery">
                                    <div class="title">{{__('general.city')}}</div>
                                    <div class="price">{{ $Address->city_id?$Address->City['name_'.app()->getLocale()]:'' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="order-summery">
                                    <div class="title">{{__('general.building_no')}}</div>
                                    <div class="price">{{ $Address->building_no }}</div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="order-summery">
                                    <div class="title">{{__('general.floor_no')}}</div>
                                    <div class="price">{{ $Address->floor_no }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="order-summery">
                                    <div class="title">{{__('general.apartment_no')}}</div>
                                    <div class="price">{{ $Address->apartment_no }}</div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="order-summery">
                                    <div class="title">{{__('forms.phone')}}</div>
                                    <div class="price">{{ $Address->phone }}</div>
                                </div>
                            </div>
                        </div>
                        
                        
                
                        
                
                        <!--<div class="order-summery">-->
                        <!--    <div class="title">{{__('general.area')}}</div>-->
                        <!--    <div class="price">{{ $Address->area_id?$Address->Area['name_'.app()->getLocale()]:'' }}</div>-->
                        <!--</div>-->
                
                        <!--<div class="order-summery">-->
                        <!--    <div class="title">{{__('general.zone')}}</div>-->
                        <!--    <div class="price">{{ $Address->zone_id?$Address->Zone['name_'.app()->getLocale()]:'' }}</div>-->
                        <!--</div>-->
                
                        
                        
                        
                
                        <!--<div class="order-summery">-->
                        <!--    <div class="title">{{__('general.postal_code')}}</div>-->
                        <!--    <div class="price">{{ $Address->postal_code }}</div>-->
                        <!--</div>-->
                        
                        <a href="#" class="pull-right edit-address" data-toggle="modal" data-target="#addressModal{{$Address->id}}"
                            data-dismiss="modal">
                            {{__('forms.edit')}}
                            <span class="fa fa-edit"></span>
                        </a>
                        <div class="clearfix"></div>
                        <input type="radio" checked="checked" onclick="set_add({{$Address->id}})" name="radio">
                        <span class="checkmark"></span>
                    </label>
                    <!-- Modals -->
                    <div class="modal fade" id="addressModal{{$Address->id}}" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title color-main">{{__('general.edit_address')}}</h4>
                                </div>
                                <div class="modal-body">
                                    <!-- Shopping info -->
                                    <div class="container-fluid">
                                        <form action="{{route('address.update', ['country' => get_country()->code, 'id' => $Address->id])}}" method="post" class="form-style">
                                            {{ method_field('PUT') }}
                                            @csrf
                                            <div class="row">
                                                
                                                        <div class="col-md-6">
            <div class="form-group has-feedback">
                <label class="control-label">{{__('forms.name')}}
                <span class="text-muted font-size-12">*</span>
                </label>
                <input type="text" class="form-control" value="{{ auth()->user()->name }}" name="name" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group has-feedback">
                <label class="control-label">{{__('forms.email')}}<span class="text-muted font-size-12">*</span></label>
                <input type="email" class="form-control" value="{{ auth()->user()->email }}" name="email" required>
            </div>
        </div>
        
                                                <div class="form-group col-xs-12">
                                                    <div class="form-group has-feedback">
                                                        <label class="control-label">{{__('general.address_details')}}<span class="text-muted font-size-12">*</span></label>
                                                        <input type="text" class="form-control" value="{{$Address->address_details}}"
                                                            name="address_details" required>
                                                    </div>
                                                </div>
                
                                                <div class="form-group col-xs-12 col-md-6">
                                                    <label>{{__('general.country')}}<span class="text-muted font-size-12">*</span></label>
                                                    <select id="country" name="country_id" class="form-control" required>
                                                        <option value="">{{__('general.country')}}</option>
                
                                                        @foreach ($countries->where('id', get_country()->id) as $key => $country)
                                                        <option value="{{ $country->code }}"
                                                            <?php if ($Address->City->country->id == $country->id) echo "selected"; ?>>
                                                            {{ app()->isLocale('ar') ? $country->name_ar : $country->name_en }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                
                                                <div class="form-group col-xs-12 col-md-6">
                                                    <label>{{__('general.city')}}<span class="text-muted font-size-12">*</span></label>
                                                    <select id="city" name="city_id" class="form-control" required>
                                                        <option value="{{$Address->city_id?$Address->city_id:''}}">
                                                            {{$Address->city_id? \App\City::find($Address->city_id)['name_'.app()->getLocale()] :__('general.city')}}
                                                        </option>
                                                    </select>
                                                </div>
                
                                                <!--<div class="form-group col-xs-12 col-md-6">-->
                                                <!--    <label>{{__('general.area')}}</label>-->
                                                <!--    <select id="area" name="area_id" class="form-control">-->
                                                <!--        <option value="{{$Address->area_id?$Address->area_id:''}}">-->
                                                <!--            {{$Address->area_id? \App\Area::find($Address->area_id)['name_'.app()->getLocale()] :__('general.area')}}-->
                                                <!--        </option>-->
                                                <!--    </select>-->
                                                <!--</div>-->
                
                                                <!--<div class="form-group col-xs-12 col-md-6">-->
                                                <!--    <label>{{__('general.zone')}}</label>-->
                                                <!--    <select id="zone" name="zone_id" class="form-control">-->
                                                <!--        <option value="">{{__('general.zone')}}</option>-->
                                                <!--        <option value="{{$Address->zone_id?$Address->zone_id:''}}">-->
                                                <!--            {{$Address->zone_id? \App\Zone::find($Address->zone_id)['name_'.app()->getLocale()] :__('general.zone')}}-->
                                                <!--        </option>-->
                                                <!--    </select>-->
                                                <!--</div>-->
                
                
                
                                                <div class="form-group col-xs-12 col-md-6">
                                                    <div class="form-group has-feedback">
                                                        <label class="control-label">{{__('general.building_no')}}<span class="text-muted font-size-12">*</span></label>
                                                        <input type="number" class="form-control" value="{{$Address->building_no}}"
                                                            name="building_no" required>
                                                    </div>
                                                </div>
                
                                                <div class="form-group col-xs-12 col-md-6">
                                                    <div class="form-group has-feedback">
                                                        <label class="control-label">{{__('general.floor_no')}}<span class="text-muted font-size-12">*</span></label>
                                                        <input type="number" class="form-control" value="{{$Address->floor_no}}"
                                                            name="floor_no" required>
                                                    </div>
                                                </div>
                
                                                <div class="form-group col-xs-12 col-md-6">
                                                    <div class="form-group has-feedback">
                                                        <label class="control-label">{{__('general.apartment_no')}}<span class="text-muted font-size-12">*</span></label>
                                                        <input type="number" class="form-control" value="{{$Address->apartment_no}}"
                                                            name="apartment_no" required>
                                                    </div>
                                                </div>
                
                                                <div class="form-group col-xs-12 col-md-6">
                                                    <div class="form-group has-feedback">
                                                        <label class="control-label">{{__('general.postal_code')}}</label>
                                                        <input type="number" min="0" class="form-control"
                                                            value="{{$Address->postal_code}}" name="postal_code">
                                                    </div>
                                                </div>
                
                                                <div class="form-group col-xs-12 col-md-6">
                                                    <div class="form-group has-feedback">
                                                        <label class="control-label">{{__('forms.phone')}}<span class="text-muted font-size-12">*</span></label>
                                                        <input type="number" min="0" class="form-control" value="{{ $Address->phone }}"
                                                            name="phone" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-main">{{__('general.save')}}</button>
                                            </div>
                                        </form>
                                    </div>
                
                                </div>
                
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    @endforeach
                    @endif
                </div>
                
                                @endif



                
<div class="modal fade" id="addressModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title color-main">{{__('general.add_new_address')}}</h4>
            </div>
            <div class="modal-body">
                <!-- Shopping info -->
                <div class="container-fluid">
                    <form action="{{route('address.create', ['country' => get_country()->code])}}" method="post" class="form-style">
                        @csrf
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                    <label class="control-label">{{__('forms.name')}}<span class="text-muted font-size-12">*</span></label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->name }}" name="name" required>
                                </div>
                            </div>
                    
                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                    <label class="control-label">{{__('forms.email')}}<span class="text-muted font-size-12">*</span></label>
                                    <input type="email" class="form-control" value="{{ auth()->user()->email }}" name="email" required>
                                </div>
                            </div>

                            <div class="form-group col-xs-12">
                                <div class="form-group has-feedback">
                                    <label class="control-label">{{__('general.address_details')}}<span class="text-muted font-size-12">*</span></label>
                                    <input type="text" class="form-control" value="" name="address_details" required>
                                </div>
                            </div>


                            <div class="form-group col-xs-12 col-md-6">
                                <label>{{__('general.country')}}<span class="text-muted font-size-12">*</span></label>
                                <select id="country1" name="country_id" class="form-control" required>
                                    <option value="">{{__('general.country')}}</option>

                                    @foreach ($countries->where('id', get_country()->id) as $key => $country)
                                    <option value="{{ $country->code }}">
                                        {{ app()->isLocale('ar') ? $country->name_ar : $country->name_en }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-xs-12 col-md-6">
                                <label>{{__('general.city')}}<span class="text-muted font-size-12">*</span></label>
                                <select id="city1" name="city_id" class="form-control" required>
                                    <option value="">{{__('general.city')}}</option>
                                </select>
                            </div>

                            <!--<div class="form-group col-xs-12 col-md-6">-->
                            <!--    <label>{{__('general.area')}}</label>-->
                            <!--    <select id="area1" name="area_id" class="form-control" required>-->
                            <!--        <option value="">{{__('general.area')}}</option>-->
                            <!--    </select>-->
                            <!--</div>-->

                            <!--<div class="form-group col-xs-12 col-md-6">-->
                            <!--    <label>{{__('general.zone')}}</label>-->
                            <!--    <select id="zone1" name="zone_id" class="form-control">-->
                            <!--        <option value="">{{__('general.zone')}}</option>-->
                            <!--    </select>-->
                            <!--</div>-->



                            <div class="form-group col-xs-12 col-md-6">
                                <div class="form-group has-feedback">
                                    <label class="control-label">{{__('general.building_no')}}<span class="text-muted font-size-12">*</span></label>
                                    <input type="number" class="form-control" value="" name="building_no" required>
                                </div>
                            </div>

                            <div class="form-group col-xs-12 col-md-6">
                                <div class="form-group has-feedback">
                                    <label class="control-label">{{__('general.floor_no')}}<span class="text-muted font-size-12">*</span></label>
                                    <input type="number" class="form-control" value="" name="floor_no" required>
                                </div>
                            </div>

                            <div class="form-group col-xs-12 col-md-6">
                                <div class="form-group has-feedback">
                                    <label class="control-label">{{__('general.apartment_no')}}<span class="text-muted font-size-12">*</span></label>
                                    <input type="number" class="form-control" value="" name="apartment_no" required>
                                </div>
                            </div>

                            <div class="form-group col-xs-12 col-md-6">
                                <div class="form-group has-feedback">
                                    <label class="control-label">{{__('general.postal_code')}}</label>
                                <input type="number" min="0" class="form-control" value="{{auth()->user()->postal_code}}" name="postal_code">
                                </div>
                            </div>

                            <div class="form-group col-xs-12 col-md-6">
                                <div class="form-group has-feedback">
                                    <label class="control-label">{{__('forms.phone')}}<span class="text-muted font-size-12">*</span></label>
                                    <input type="number" min="0" class="form-control" value="{{auth()->user()->phone}}" name="phone" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-main">{{__('general.save')}}</button>
                        </div>
                    </form>
                </div>

            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

</div><!-- /.modal -->



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
            if ($(this).val() && $("#area").val()) {
                $("#home_btn").attr("disabled", false);
            }
        });
        // $("#area").change(function () {
        //     var options = '<option value="">{{__("general.zone")}}</option>';
        //     var x;
        //     $.ajax({
        //         url: "{!! route('api.zones.web') !!}",
        //         type: 'GET',
        //         data: {
        //             area_id: $("#area").val(),
        //             locale: "{{ \App::getLocale() }}"
        //         }
        //     }).then((response) => {
        //         for (x = 0; x < response.data.length; x++) {
        //             options += '<option value="' + response.data[x].id + '">' + response.data[x].name + '</option>'
        //         }
        //         $("#zone").html(options);
        //     })
        //     if ($(this).val() && $("#city").val() && $("#zone").val()) {
        //         $("#home_btn").attr("disabled", false);
        //     }
        // });
</script>   
<script>
    $("#country1").change(function () {
            var options = '<option value="">{{__("general.city")}}</option>';
            var x;
            $.ajax({
                url: "{!! route('api.cities.web') !!}",
                type: 'GET',
                data: {
                    country: $("#country1").val(),
                    locale: "{{ \App::getLocale() }}"
                }
            }).then((response) => {
                for (x = 0; x < response.data.length; x++) {
                    options += '<option value="' + response.data[x].id + '">' + response.data[x].name + '</option>'
                }
                $("#city1").html(options);
            });
            if ($(this).val() && $("#area1").val()) {
                $("#home_btn").attr("disabled", false);
            }
        });
        $("#city1").change(function () {
            var options = '<option value="">{{__("general.area")}}</option>';
            var x;
            $.ajax({
                url: "{!! route('api.areas.web') !!}",
                type: 'GET',
                data: {
                    city_id: $("#city1").val(),
                    locale: "{{ \App::getLocale() }}"
                }
            }).then((response) => {
                for (x = 0; x < response.data.length; x++) {
                    options += '<option value="' + response.data[x].id + '">' + response.data[x].name + '</option>'
                }
                $("#area1").html(options);
            });
            if ($(this).val() && $("#area1").val()) {
                $("#home_btn").attr("disabled", false);
            }
        });
        // $("#area1").change(function () {
        //     var options = '<option value="">{{__("general.zone")}}</option>';
        //     var x;
        //     $.ajax({
        //         url: "{!! route('api.zones.web') !!}",
        //         type: 'GET',
        //         data: {
        //             area_id: $("#area1").val(),
        //             locale: "{{ \App::getLocale() }}"
        //         }
        //     }).then((response) => {
        //         for (x = 0; x < response.data.length; x++) {
        //             options += '<option value="' + response.data[x].id + '">' + response.data[x].name + '</option>'
        //         }
        //         $("#zone1").html(options);
        //     })
        //     if ($(this).val() && $("#city1").val() && $("#zone1").val()) {
        //         $("#home_btn").attr("disabled", false);
        //     }
        // });
</script>  
@endsection
