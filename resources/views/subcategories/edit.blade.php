@extends('layouts.app')

@section('content')

<div class="col-lg-6 col-lg-offset-3">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Subcategory Information')}}</h3>
        </div>

        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('subcategories.update', $subcategory->id) }}" method="POST" enctype="multipart/form-data">
            <input name="_method" type="hidden" value="PATCH">
        	@csrf
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Name Ar')}}
                                                        <span class="text-danger">*</span>
</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('Name')}}" id="name_ar" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" value="{{$subcategory->name_ar}}" required>
                        @error('name_ar')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Name En')}}
                                                        <span class="text-danger">*</span>
</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('Name')}}" id="name_en" name="name_en" class="form-control @error('name_en') is-invalid @enderror" value="{{$subcategory->name_en}}" required>
                        @error('name_en')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Category')}}
                                                        <span class="text-danger">*</span>
</label>
                    <div class="col-sm-9">
                        <select name="category_id" required class="form-control select2 @error('category_id') is-invalid @enderror">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}" <?php if($subcategory->category_id == $category->id) echo "selected";?> >{{__($category->name_en)}}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                </div>
                   <div class="form-group">
                                    <label class="col-lg-3 control-label">{{__('Icon')}}
                                    <span class="text-danger">*</span>
                                        <small class="text-danger text-xs">Best Size: (250*300)</small>
                                        <br><small class="text-danger text-xs">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</small>
                                    </label>
                                    <div class="col-lg-9">
                                        <div id="icon">
                                            @if($subcategory->icon)
                                            <div class="col-md-9">
                                                <div class="img-upload-preview">
                                                    <img src="{{ asset($subcategory->icon) }}" alt="" class="img-responsive">
                                                    <input type="hidden" name="previous_photos[]" value="{{ $subcategory->icon }}">
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
                                    <label class="col-lg-3 control-label">{{__('Banner')}}
                                    <span class="text-danger">*</span>
                                        <small class="text-danger text-xs">Best Size: (1350*300)</small>
                                        <br><small class="text-danger text-xs">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</small>
                                    </label>
                                    <div class="col-lg-9">
                                        <div id="banner">
                                            @if($subcategory->banner)
                                            <div class="col-md-9">
                                                <div class="img-upload-preview">
                                                    <img src="{{ asset($subcategory->banner) }}" alt="" class="img-responsive">
                                                    <input type="hidden" name="previous_photos[]" value="{{ $subcategory->banner }}">
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
                    <label class="col-sm-3 control-label">{{__('Meta Title')}}</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control @error('meta_title') is-invalid @enderror" name="meta_title" value="{{ $subcategory->meta_title }}" placeholder="{{__('Meta Title')}}">
                        @error('meta_title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                     </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">{{__('Description')}}</label>
                    <div class="col-sm-9">
                        <textarea name="meta_description" rows="8" class="form-control @error('meta_description') is-invalid @enderror">{{ $subcategory->meta_description }}</textarea>
                        @error('meta_description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                </div>




                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Slug')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('Slug')}}" id="slug" name="slug" value="{{ $subcategory->slug }}" class="form-control">
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
     $("#banner").spartanMultiImagePicker({
            fieldName:        'banner',
            maxCount:         1,
            rowHeight:        '200px',
            groupClassName:   'col-md-12 col-sm-9 col-xs-6 @error("banner") is-invalid @enderror',
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
            groupClassName:   'col-md-12 col-sm-9 col-xs-6 @error("icon") is-invalid @enderror',
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

        $(document).ready(function () {
            $('.remove-files').on('click', function () {
            $(this).parents(".col-md-9").remove();
            });
        });

</script>
@endsection
