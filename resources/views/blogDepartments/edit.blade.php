@extends('layouts.app')

@section('content')

    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Blog Information')}}</h3>
            </div>
            <!--Horizontal Form-->
            <!--===================================================-->
            <form class="form-horizontal" action="{{ route('blogDepartment.update',$blog_dep->id) }}" method="POST" enctype="multipart/form-data">
                <input name="_method" type="hidden" value="PUT">
                <input type="hidden" name="id" value="{{ $blog_dep->id }}">
                @csrf
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="name_ar">{{__('name_ar')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" value="{{$blog_dep->name_ar}}" placeholder="{{__('Name Ar')}}" id="name_ar" name="name_ar" class="form-control  @error("name_ar") is-invalid @enderror">
                            @error('name_ar')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="name_en">{{__('name_en')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" value="{{$blog_dep->name_en}}" placeholder="{{__('Name En')}}" id="name_en" name="name_en" class="form-control  @error("name_en") is-invalid @enderror">
                            @error('name_en')
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
