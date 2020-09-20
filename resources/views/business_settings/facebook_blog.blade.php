@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">{{__('Facebook Blog Setting')}}</h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" action="{{ route('facebook_blog.update') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="col-lg-3">
                                <label class="control-label">{{__('Facebook Blog')}}</label>
                            </div>
                            <div class="col-lg-6">
                                <label class="switch">
                                    <input value="1" name="facebook_blog" type="checkbox" @if (\App\BusinessSetting::where('type', 'facebook_blog')->first()->value == 1)
                                        checked
                                    @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="types[]" value="FACEBOOK_PIXEL_ID">
                            <div class="col-lg-3">
                                <label class="control-label">{{__('Facebook Pixel ID')}}</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="FACEBOOK_PIXEL_ID" value="{{ isset($business_settings->where('type', 'FACEBOOK_PIXEL_ID')->first()->value)?$business_settings->where('type', 'FACEBOOK_PIXEL_ID')->first()->value:''}}" placeholder="Facebook Pixel ID" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12 text-right">
                                <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
