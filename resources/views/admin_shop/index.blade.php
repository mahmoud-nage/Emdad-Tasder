@extends('layouts.app')

@section('content')

    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Shop Settings')}}</h3>
            </div>

            <!--Horizontal Form-->
            <!--===================================================-->
            <form class="form-horizontal" action="{{ route('shop.settings.save') }}" method="post" enctype="multipart/form-data">
                
            	
            	@csrf
        <input name="_method" type="hidden" value="PUT">
        <input name="id" type="hidden" value="{{$shop->id}}">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="name">{{__('forms.shop_name')}}</label>
                        <div class="col-sm-9">
                            <input type="text" id="name" name="name" value="{{ $shop->name }}" class="form-control  @error('name') is-invalid @enderror" required>
                                                                   @error('name')
                                       <span class="invalid-feedback" role="alert">
                                           <strong>{{ $message }}</strong>
                                       </span>
                                     @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="address">{{__('Address')}}</label>
                        <div class="col-sm-9">
                            <input type="text" id="address" name="address" value="{{ $shop->address }}" class="form-control @error('address') is-invalid @enderror" required>
                                                                                               @error('address')
                                       <span class="invalid-feedback" role="alert">
                                           <strong>{{ $message }}</strong>
                                       </span>
                                     @enderror
                        </div>
                    </div>
                    
                            <div class="form-group">
                                <label class="col-lg-3 control-label">{{__('Slider')}}
                                    <span class="text-danger">*</span>
                                    <br><small class="text-danger text-xs">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</small>
                                    <br><small class="text-danger text-xs">Best Size: (1400*400)</small></label>
                                <div class="col-lg-9">
                                    <div id="sliders">
                                        @if(is_array(json_decode($shop->sliders)))
                                        @foreach (json_decode($shop->sliders) as $key => $slider)
                                        <div class="col-md-6 col-sm-4 col-xs-6">
                                            <div class="img-upload-preview">
                                                <img src="{{ asset($slider) }}" alt="" class="img-responsive">
                                                <input type="hidden" name="previous_sliders[]" value="{{ $slider }}">
                                                <button type="button" class="btn btn-danger close-btn remove-files"><i
                                                        class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                                @error('sliders')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">{{__('Logo')}}
                                    <span class="text-danger">*</span>
                                    <br><small class="text-danger text-xs">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</small>
                                    <br><small class="text-danger text-xs">Best Size: (100*100)</small>                                
                                </label>
                                <div class="col-lg-9">
                                    <div id="logo">
                                        @if ($shop->logo != null)
                                        <div class="col-md-6 col-sm-4 col-xs-6">
                                            <div class="img-upload-preview">
                                                <img src="{{ asset($shop->logo) }}" alt=""
                                                    class="img-responsive">
                                                <input type="hidden" name="previous_logo"
                                                    value="{{ $shop->logo }}">
                                                <button type="button" class="btn btn-danger close-btn remove-files"><i
                                                        class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @error('logo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
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
    $(document).ready(function(){
            $('.remove-files').on('click', function(){
                $(this).parents(".col-md-6").remove();
            });
        });
        
                    $("#logo").spartanMultiImagePicker({
                fieldName: 'logo',
                maxCount: 1,
                rowHeight: '200px',
                groupClassName:   'col-md-6 col-sm-4 col-xs-6 @error("logo") is-invalid @enderror',
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
            
            $("#sliders").spartanMultiImagePicker({
                fieldName: 'sliders[]',
                maxCount: 10,
                rowHeight: '200px',
                groupClassName:   'col-md-6 col-sm-4 col-xs-6 @error("sliders") is-invalid @enderror',
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
            
</script>
@endsection