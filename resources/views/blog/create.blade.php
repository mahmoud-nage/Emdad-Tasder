@extends('layouts.app')

@section('content')

<div class="col-lg-6 col-lg-offset-3">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Blog Information')}}</h3>
        </div>
        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Department')}}
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9">
                        <select name="blog_department_id" class="form-control @error("blog_department_id") is-invalid @enderror" required>
                            @foreach(\App\ BlogDepartment::orderBy('created_at', 'desc')->get() as $department)
                            <option value="{{$department->id}}">
                                {{ app()->isLocale('ar') ? $department->name_ar : $department->name_en }}
                            </option>
                            @endforeach
                        </select>
                        @error('blog_department_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Author Name En')}}
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('Author Name En')}}" name="author_name_en"
                            class="form-control @error("author_name_en") is-invalid @enderror" value="{{old('author_name_en')}}" required>
                        @error('author_name_en')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Author Name Ar')}}
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('Author Name Ar')}}" name="author_name_ar"
                            class="form-control @error("author_name_ar") is-invalid @enderror" value="{{old('author_name_ar')}}" required>
                        @error('author_name_ar')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Author Title En')}}
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('Author Title En')}}" name="author_title_en"
                            class="form-control @error("author_title_en") is-invalid @enderror" value="{{old('author_title_en')}}" required>
                        @error('author_title_en')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Author Title Ar')}}
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('Author Title Ar')}}" name="author_title_ar"
                            class="form-control @error("author_title_ar") is-invalid @enderror" value="{{old('author_title_ar')}}" required>
                        @error('author_title_ar')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Title En')}}
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('Title En')}}" name="title" value="{{old('title')}}" class="form-control @error("title") is-invalid @enderror" required>
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Title Ar')}}
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('Title Ar')}}" name="title_ar" value="{{old('title_ar')}}" class="form-control @error("title_ar") is-invalid @enderror"
                            required>
                        @error('title_ar')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="email">{{__('Content En')}}
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9">
                        <textarea type="text" rows="10" placeholder="{{__('Content En')}}" id="article" name="article"
                            class="form-control @error("article") is-invalid @enderror" required>{{old('article')}}</textarea>
                        @error('article')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="email">{{__('Content Ar')}}
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9">
                        <textarea type="text" rows="10" placeholder="{{__('Content Ar')}}" id="article"
                            name="article_ar" class="form-control @error("article_ar") is-invalid @enderror" required>{{old('article_ar')}}</textarea>
                        @error('article_ar')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">{{__('Image')}}
                        <span class="text-danger">*</span>
                    <br><small class="text-danger text-xs">Ext Only: (jpg|jpeg|png|tiff|webp|gif)</small>
                     </label>
                    <div class="col-lg-9">
                        <div id="photo">

                        </div>
                        @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="video">{{__('Youtube link')}}</label>
                    <div class="col-sm-9">
                        <input type="url" placeholder="{{__('video')}}" id="video" name="video"
                            class="form-control @error("video") is-invalid @enderror" value="{{old('video')}}">
                            @error('video')
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
    $(document).ready(function () {
    $("#photo").spartanMultiImagePicker({
            fieldName:        'image',
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