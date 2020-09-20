@extends('layouts.app')

@section('content')

<div class="col-lg-6 col-lg-offset-3">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Sub Subcategory Information')}}</h3>
        </div>

        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('subsubcategories.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Name Ar')}}
                                        <span class='text-danger'>*</span>
</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('Name Ar')}}" id="name_ar" name="name_ar"
                            class="form-control @error('name_ar') is-invalid @enderror" value="{{old('name_ar')}}"
                            required>
                        @error('name_ar')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Name En')}}
                                        <span class='text-danger'>*</span>
</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('Name En')}}" id="name_en" name="name_en"
                            class="form-control @error('name_en') is-invalid @enderror"
                            value="{{old('name_en')}}" required>
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
                        <select name="category_id" id="category_id"
                            class="form-control select2 @error('category_id') is-invalid @enderror"
                            value="{{old('category_id')}}" required>
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
                        <select name="sub_category_id" id="sub_category_id"
                            class="form-control select2 @error('sub_category_id') is-invalid @enderror"
                            value="{{old('sub_category_id')}}" required>
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
                        <select name="brands[]" id="brands"
                            class="form-control select2 @error('brands') is-invalid @enderror" multiple
                            required data-placeholder="Choose Brands">
                            @foreach($brands as $brand)
                            <option value="{{$brand->id}}">{{$brand->name}}</option>
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
                    <label class="col-sm-3 control-label">{{__('Image')}}
                    <span class='text-danger'>*</span>
                    <br><small class="text-danger">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</small>
                    </label>
                    <div class="col-lg-7">
                        <div id="image">

                        </div>
                        @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-3 control-label">{{__('Meta Title')}}</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                            name="meta_title" value="{{old('meta_title')}}" placeholder="{{__('Meta Title')}}">
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
                        <textarea name="meta_description" rows="8"
                            class="form-control @error('meta_description') is-invalid @enderror">{{old('meta_description')}}</textarea>
                        @error('meta_description')
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

    $(document).ready(function(){
        get_subcategories_by_category();

        // $(".add-colors").click(function(){
        //     console.log('test');
        //     var html = $(".clone-color").html();
        //     $(".increment").after(html);
        // });

        // $("body").on("click",".remove-colors",function(){
        //     $(this).parents(".control-group").remove();
        // });
    });

    $('#category_id').on('change', function() {
        get_subcategories_by_category();
    });

    
    $("#image").spartanMultiImagePicker({
            fieldName:        'image',
            maxCount:         1,
            rowHeight:        '200px',
            groupClassName:   'col-md-4 col-sm-4 col-xs-6 @error("image") is-invalid @enderror',
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


</script>

@endsection