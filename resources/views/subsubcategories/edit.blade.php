@extends('layouts.app')

@section('content')

<div class="col-lg-6 col-lg-offset-3">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Sub Subcategory Information')}}</h3>
        </div>

        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('subsubcategories.update', $subsubcategory->id) }}" method="POST" enctype="multipart/form-data">
            <input name="_method" type="hidden" value="PATCH">
            @csrf
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Name Ar')}}
                                        <span class='text-danger'>*</span>
</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('Name Ar')}}" id="name_ar" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" required value="{{$subsubcategory->name_ar}}">
                        @error('name_ar')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Name')}}
                                        <span class='text-danger'>*</span>
</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('Name En')}}" id="name_en" name="name_en" class="form-control @error('name_en') is-invalid @enderror" required value="{{$subsubcategory->name_en}}">
                        @error('name_en')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Category')}}
                                        <span class='text-danger'>*</span>
</label>
                    <div class="col-sm-9">
                        <select name="category_id" id="category_id" class="form-control select2 @error('category_id') is-invalid @enderror" required>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{__($category->name_en)}}</option>
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
                    <label class="col-sm-3 control-label" for="name">{{__('Subcategory')}}
                                        <span class='text-danger'>*</span>
</label>
                    <div class="col-sm-9">
                        <select name="sub_category_id" id="sub_category_id" class="form-control select2 @error('sub_category_id') is-invalid @enderror" required>

                        </select>
                        @error('sub_category_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Brands')}}
                                        <span class='text-danger'>*</span>
</label>
                    <div class="col-sm-9">
                        <select name="brands[]" id="brands" class="form-control select2 @error('brands') is-invalid @enderror" multiple required data-placeholder="Choose Brands">
                            @foreach($brands as $brand)
                                <option value="{{$brand->id}}" <?php if(in_array($brand->id, json_decode($subsubcategory->brands))) echo "selected";?> >{{$brand->name}}</option>
                            @endforeach
                        </select>
                        @error('brands')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">{{__('Meta Title')}}
                                        <span class='text-danger'>*</span>
</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control @error('meta_title') is-invalid @enderror" name="meta_title" value="{{ $subsubcategory->meta_title }}" placeholder="{{__('Meta Title')}}">
                        @error('meta_title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">{{__('Description')}}
                                        <span class='text-danger'>*</span>
</label>
                    <div class="col-sm-9">
                        <textarea name="meta_description" rows="8" class="form-control @error('meta_description') is-invalid @enderror">{{ $subsubcategory->meta_description }}</textarea>
                        @error('meta_description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                </div>

                                <div class="form-group">
                                    <label class="col-lg-3 control-label">{{__('Image')}}
                                    <br><small class="text-danger text-xs">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</small>
                                                        <span class='text-danger'>*</span>

                                    </label>
                                    <div class="col-lg-9">
                                        <div id="image">
                                            @if($subsubcategory->image)
                                            <div class="col-md-9">
                                                <div class="img-upload-preview">
                                                    <img src="{{ asset($subsubcategory->image) }}" alt="" class="img-responsive">
                                                    <input type="hidden" name="previous_photos[]" value="{{ $subsubcategory->image }}">
                                                    <button type="button" class="btn btn-danger close-btn remove-files"><i
                                                            class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Slug')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('Slug')}}" id="slug" name="slug" value="{{ $subsubcategory->slug }}" class="form-control">
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

<script type="text/javascript">

    function get_subcategories_by_category(){
        var category_id = $('#category_id').val();
        $.post('{{ route('subcategories.get_subcategories_by_category') }}',{_token:'{{ csrf_token() }}', category_id:category_id}, function(data){
            $('#sub_category_id').html(null);
            for (var i = 0; i < data.length; i++) {
                $('#sub_category_id').append($('<option>', {
                    value: data[i].id,
                    text: data[i].name
                }));
                $('.demo-select2').select2();
            }
        });
    }

    $('.demo-select2').select2();

    $(document).ready(function(){

        $("#category_id > option").each(function() {
            if(this.value == '{{$subsubcategory->subcategory->category_id}}'){
                $("#category_id").val(this.value).change();
            }
        });

        get_subcategories_by_category();
    });

    $('#category_id').on('change', function() {
        get_subcategories_by_category();
    });
    
    $("#image").spartanMultiImagePicker({
            fieldName:        'image',
            maxCount:         1,
            rowHeight:        '200px',
            groupClassName:   'col-md-12 col-sm-9 col-xs-6 @error("image") is-invalid @enderror',
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
