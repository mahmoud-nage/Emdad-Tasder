@extends('layouts.app')

@section('content')

    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Edit City')}}</h3>
            </div>

            <!--Horizontal Form-->
            <!--===================================================-->
            <form class="form-horizontal" action="{{ route('cities.update', $city->id) }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="panel-body">
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="name_en">{{__('Name En')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{__('Name En')}}" id="name_en" name="name_en" class="form-control @error("name_en") is-invalid @enderror"
                                   required disabled value="{{$city->name_en}}">
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
                                   required value="{{$city->name_ar}}">
                                   @error('name_ar')
                                   <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                   </span>
                                   @enderror
                        </div>
                    </div>

                            @if($city->aramex == 0)
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">{{__('Delivery Price')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="number" min="0" step="0.1" class="form-control @error('delivery_price') is-invalid @enderror"
                                             name="delivery_price" placeholder="Delivery Price"
                                            required value="{{$city->delivery_price}}">
                                        @error('delivery_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            
                    
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
            $("#icon").spartanMultiImagePicker({
                fieldName: 'icon',
                maxCount: 1,
                rowHeight: '200px',
                groupClassName:   'col-md-6 @error("icon") is-invalid @enderror',
            maxFileSize:      '',
            allowedExt:       'jpg|jpeg|png|tiff|webp|gif',
            dropFileLabel : "Drop Here",
            onExtensionErr : function(index, file){
                console.log(index, file,  'extension err');
                alert('Please only input png or jpg or jpeg or tiff or webp or gif type file')
            },
                onSizeErr: function (index, file) {
                    console.log(index, file, 'file size too big');
                    alert('File size too big');
                }
            });
            $('.remove-files').on('click', function () {
                $(this).parents(".col-md-6").remove();
            });
        });
    </script>
@stop
