@extends('layouts.app')

@section('content')

    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Create Country')}}</h3>
            </div>

            <!--Horizontal Form-->
            <!--===================================================-->
            <form class="form-horizontal" action="{{ route('countries.store') }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="panel-body">
                        <div class="form-group">
                        <label class="col-sm-3 control-label" for="currency_id">{{__('Name EN')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <select class="form-control select2 @error("name_en") is-invalid @enderror" name="name_en" id="name_en">
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency->name }}">{{ $currency->name }}</option>
                                @endforeach
                            </select>
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
                            <input type="text" placeholder="{{__('Name AR')}}" id="name_ar" name="name_ar" class="form-control @error("name_ar") is-invalid @enderror" value="{{old('name_ar')}}" required>
                            @error('name_ar')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    
                                        <div class="form-group">
                        <label class="col-sm-3 control-label" for="currency_id">{{__('Code')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <select class="form-control select2 @error("code") is-invalid @enderror" name="code" id="code">
                            </select>
                            @error('code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-lg-3 control-label @error("meta_title") is-invalid @enderror">{{__('Icon')}}
                            <span class="text-danger">*</span>
                            <br><small class="text-danger text-xs">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</small>
                            <br><small class="text-danger text-xs">Best Size: (24*16)</small>
                        </label>
                        <div class="col-lg-7">
                            <div id="icon">
    
                            </div>
                            @error('icon')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="currency_id">{{__('Currency')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <select class="form-control select2 @error("currency_id") is-invalid @enderror" name="currency_id" id="currency_id">
                            </select>
                            @error('currency_id')
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
            $("#icon").spartanMultiImagePicker({
                fieldName: 'icon',
                maxCount: 1,
                rowHeight: '200px',
                groupClassName:   'col-md-12 col-sm-9 col-xs-6 @error("icon") is-invalid @enderror',
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
        });
        
        
            $('#name_en').on('change', function(){
                var currency_name = $('#name_en').val();
                    $.get('{{ route('currency.get_currency') }}', {currency_name:currency_name}, function(data){
                        console.log(data);
                                $('#code').find('option').remove().end();
                                $('#currency_id').find('option').remove().end();
                                // $.each(data.data, function(k, v) {
                                    $('#code').append('<option value='+ data.data.country_code +'>'+ data.data.country_code +'</option>');
                                    $('#currency_id').append('<option value='+ data.data.id +'>'+ data.data.code +'</option>');
                                // });                         
                    });
            });
        
    </script>
@stop
