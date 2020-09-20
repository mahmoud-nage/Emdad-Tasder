@extends('layouts.app')

@section('content')

<div class="col-lg-6 col-lg-offset-3">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Unit Information')}}</h3>
        </div>

        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('units.update', $unit->id) }}" method="POST" enctype="multipart/form-data">
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

