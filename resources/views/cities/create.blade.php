@extends('layouts.app')

@section('content')

    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Create City')}}</h3>
            </div>

            <!--Horizontal Form-->
            <!--===================================================-->
            <form class="form-horizontal" action="{{ route('cities.store') }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="panel-body">
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="name_en">{{__('Name En')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{__('Name En')}}" id="name_en" name="name_en" class="form-control @error("name_en") is-invalid @enderror"
                                   required >
                                   @error('name_en')
                                   <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                   </span>
                                   @enderror
                        </div>
                    </div>      
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="name_ar">{{__('Name AR')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{__('Name AR')}}" id="name_ar" name="name_ar" class="form-control @error("name_ar") is-invalid @enderror"
                                   required >
                                   @error('name_ar')
                                   <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                   </span>
                                   @enderror
                        </div>
                    </div>
                    
                                        
                        <div class="form-group">
                        <label class="col-sm-3 control-label" for="currency_id">{{__('Country')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <select class="form-control select2 @error("country_id") is-invalid @enderror" name="country_id" id="country_id">
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name_en }}</option>
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
                                    <label class="col-lg-3 control-label">{{__('Delivery Price')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="number" min="0" step="0.1" class="form-control @error('delivery_price') is-invalid @enderror"
                                             name="delivery_price" placeholder="Delivery Price"
                                            required>
                                        @error('delivery_price')
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
        $('document').ready(function () {
            $('.demo-select2').select2();
        });
    </script>
@stop
