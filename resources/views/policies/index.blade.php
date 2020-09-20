@extends('layouts.app')

@section('content')

<div class="col-sm-12">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{ ucfirst(str_replace('_', ' ',$policy->name_en))}}</h3>
        </div>
        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('policies.store') }}" method="POST" enctype="multipart/form-data">
        	@csrf
        	            <div class="panel-body">

        	                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="name_en">{{__('Name Ar')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="{{__('Name Ar')}}" id="name_ar" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" value="{{ $policy->name_ar }}"  required>
                            @error('name_ar')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    </div>

            <div class="panel-body">
                <div class="form-group">
                                        <input type="hidden" name="name_en" value="{{ $policy->name_en }}">

                    <label class="col-sm-2 control-label" for="name">{{__('Content En')}}<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <textarea class="editor" name="content_en" required>{{$policy->content_en}}</textarea>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <input type="hidden" name="name_en" value="{{ $policy->name_en }}">
                    <label class="col-sm-2 control-label" for="name">{{__('Content Ar')}}<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <textarea class="editor" name="content_ar" required>{{$policy->content_ar}}</textarea>
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
