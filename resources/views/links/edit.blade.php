@extends('layouts.app')

@section('content')
<div class="col-lg-6 col-lg-offset-3">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Useful Link')}}</h3>
        </div>

        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('links.update',$link->id) }}" method="POST" enctype="multipart/form-data">
        	@csrf
            <input type="hidden" name="_method" value="PATCH">
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Name En')}}</label>
                    <div class="col-sm-9">
                        <input type="text" value="{{ $link->name_en }}" id="name_en" name="name_en" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Name Ar')}}</label>
                    <div class="col-sm-9">
                        <input type="text" value="{{ $link->name_ar }}" id="name_ar" name="name_ar" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('URL')}}</label>
                    <div class="col-sm-9">
                        <input type="text" value="{{ $link->url }}" id="link" name="link" class="form-control" required>
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
