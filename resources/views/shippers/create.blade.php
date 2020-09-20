@extends('layouts.app')

@section('content')

    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Create Shipper')}}</h3>
            </div>

            <!--Horizontal Form-->
            <!--===================================================-->
            <form class="form-horizontal" action="{{ route('shippers.store') }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="name_en">{{__('Name EN')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="{{__('Name EN')}}" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}"  required>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="name_ar">{{__('Contact Name')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="{{__('Contact Name')}}" id="contact_name" name="contact_name" class="form-control @error('contact_name') is-invalid @enderror" value="{{old('contact_name')}}"  required>
                            @error('contact_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="email">{{__('Email')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="{{__('Email')}}" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}"  required>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="code">{{__('Address')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="{{__('Address')}}" id="address" name="address" class="form-control @error('address') is-invalid @enderror" value="{{old('address')}}"  required>
                            @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="address2">{{__('Other Address')}}
                        </label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="{{__('Other Address')}}" id="address2" name="address2" class="form-control @error('address2') is-invalid @enderror" value="{{old('address2')}}">
                            @error('address2')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="phone">{{__('Phone')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="{{__('Phone')}}" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{old('phone')}}"  required>
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="phone2">{{__('Other Phone')}}
                        </label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="{{__('Other Phone')}}" id="phone2" name="phone2" class="form-control @error('phone2') is-invalid @enderror" value="{{old('phone2')}}" >
                            @error('phone2')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    
                          <div class="form-group">
                                <label class="col-sm-2 control-label" for="country">{{__('Countries')}}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                <select id="country" name="country_id" class="form-control @error('country_id') is-invalid @enderror"  required>
                                    <option value="">{{__('Countries')}}</option>
                                    @foreach (\App\Country::all() as $key => $country)
                                    <option value="{{ $country->code }}">
                                        {{ $country->name_en }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="city">{{__('City')}}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <select id="city" name="city_id" class="form-control @error('city_id') is-invalid @enderror"  required>
                                        <option value="">{{__('City')}}</option>
                                    </select>
                                    @error('city_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                        </div>
                </div>
                <div class="panel-footer text-right">
                    <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
                </div>
            </form>
            <!--===================================================-->
            <!--End Horizontal Form-->

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
            if ($(this).val() && $("#area").val()) {
                $("#home_btn").attr("disabled", false);
            }
        });
    </script>
@stop
