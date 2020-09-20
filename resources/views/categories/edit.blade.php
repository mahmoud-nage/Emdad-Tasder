@extends('layouts.app')

@section('content')

<div class="col-lg-6 col-lg-offset-3">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Category Information')}}</h3>
        </div>

        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            <input name="_method" type="hidden" value="PATCH">
        	@csrf
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">{{__('Name Ar')}}
                                        <span class='text-danger'>*</span>
</label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="{{__('Name')}}" id="name_ar" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" required value="{{$category->name_ar}}">
                        @error('name_ar')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">{{__('Name En')}}
                                        <span class='text-danger'>*</span>
</label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="{{__('Name')}}" id="name_en" name="name_en" class="form-control @error('name_en') is-invalid @enderror" required value="{{$category->name_en}}">
                        @error('name_en')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">{{__('Banner')}}
                    <span class='text-danger'>*</span>
                        <small class="text-danger text-xs">Best Size: (1350*300)</small>

                        <br><small class="text-danger">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</small>
                    </label>
                    <div class="col-lg-9">
                        <div id="banner">
                            @if($category->banner)
                            <div class="col-md-9">
                                <div class="img-upload-preview">
                                    <img src="{{ asset($category->banner) }}" alt="" class="img-responsive">
                                    <input type="hidden" name="previous_photos[]" value="{{ $category->banner }}">
                                    <button type="button" class="btn btn-danger close-btn remove-files"><i
                                            class="fa fa-times"></i></button>
                                </div>
                            </div>
                            @endif
                        </div>
                        @error('banner')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">{{__('Icon')}}
                                        <span class='text-danger'>*</span>
                        <small class="text-danger text-xs">Best Size: (250*300)</small>

                        <br><small class="text-danger">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</small></label>
                    <div class="col-lg-9">
                        <div id="icon">
                            @if($category->icon)
                            <div class="col-md-9">
                                <div class="img-upload-preview">
                                    <img src="{{ asset($category->icon) }}" alt="" class="img-responsive">
                                    <input type="hidden" name="previous_photos[]" value="{{ $category->icon }}">
                                    <button type="button" class="btn btn-danger close-btn remove-files"><i
                                            class="fa fa-times"></i></button>
                                </div>
                            </div>
                            @endif
                        </div>
                        @error('icon')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">{{__('Meta Title')}}</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('meta_title') is-invalid @enderror" name="meta_title" value="{{ $category->meta_title }}" placeholder="{{__('Meta Title')}}">

                        @error('meta_title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">{{__('Description')}}</label>
                    <div class="col-sm-10">
                        <textarea name="meta_description" rows="8" class="form-control @error('meta_description') is-invalid @enderror">{{ $category->meta_description }}</textarea>
                        @error('meta_description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">{{__('Slug')}}</label>
                    <div class="col-sm-10">
                        <input type="text" placeholder="{{__('Slug')}}" id="slug" name="slug" value="{{ $category->slug }}" class="form-control">
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
    $(document).ready(function () {
    $('.remove-files').on('click', function(){
            $(this).parents(".col-md-9").remove();
        });

    $("#banner").spartanMultiImagePicker({
            fieldName:        'banner',
            maxCount:         1,
            rowHeight:        '200px',
            groupClassName:   'col-md-12 col-sm-9 col-xs-6 @error("photo") is-invalid @enderror',
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
    $("#icon").spartanMultiImagePicker({
            fieldName:        'icon',
            maxCount:         1,
            rowHeight:        '200px',
            groupClassName:   'col-md-12 col-sm-9 col-xs-6 @error("photo") is-invalid @enderror',
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

