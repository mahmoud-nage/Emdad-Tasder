@extends('layouts.app')

@section('content')

<div class="col-lg-6 col-lg-offset-3">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Brand Information')}}</h3>
        </div>

        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
            <input name="_method" type="hidden" value="PATCH">
        	@csrf
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">{{__('Name')}}
                                                            <span class='text-danger'>*</span>
</label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="{{__('Name')}}" id="name" name="name" class="form-control  @error("name") is-invalid @enderror" required value="{{ $brand->name }}">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">{{__('Logo')}}
                                        <span class='text-danger'>*</span>

                    <br><small class="text-danger text-xs">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</small>
                                                                            <br><small class="text-danger text-xs">Best Size: (200px*70px)</small>
</label>
                    <div class="col-lg-9">
                        <div id="photo">
                            @if($brand->logo)
                            <div class="col-md-12">
                                <div class="img-upload-preview">
                                    <img src="{{ asset($brand->logo) }}" alt="" class="img-responsive">
                                    <button type="button" class="btn btn-danger close-btn remove-files"><i
                                            class="fa fa-times"></i></button>
                                </div>
                            </div>
                            @endif
                        </div>
                        @error('logo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-2 control-label">{{__('Meta Title')}}</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control  @error("meta_title") is-invalid @enderror" name="meta_title" value="{{ $brand->meta_title }}" placeholder="{{__('Meta Title')}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">{{__('Description')}}</label>
                    <div class="col-sm-10">
                        <textarea name="meta_description" rows="8" class="form-control  @error("meta_title") is-invalid @enderror">{{ $brand->meta_description }}</textarea>
                        @error('meta_title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">{{__('Slug')}}</label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="{{__('Slug')}}" id="slug" name="slug" value="{{ $brand->slug }}" class="form-control @error("slug") is-invalid @enderror">
                        @error('slug')
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
  $(document).ready(function(){
    $('.remove-files').on('click', function(){
            $(this).parents(".col-md-4").remove();
        });

    $("#photo").spartanMultiImagePicker({
            fieldName:        'logo',
            maxCount:         1,
            rowHeight:        '200px',
            groupClassName:   'col-md-12 col-sm-9 col-xs-6 @error("logo") is-invalid @enderror',
            maxFileSize:      '',
            allowedExt:       'jpg|jpeg|png|tiff|webp|gif',
            dropFileLabel : "Drop Here",
            onExtensionErr : function(index, file){
                console.log(index, file,  'extension err');
                alert('Please only input png or jpg or jpeg or tiff or webp or gif type file')
            },
            onSizeErr : function(index, file){
                console.log(index, file,  'file size too big');
                alert('File size too big');
            }
        });
        });
</script>
@endsection
