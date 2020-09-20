@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">{{__('Facebook Chat Setting')}}</h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" action="{{ route('facebook_chat.update') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="col-lg-3">
                                <label class="control-label">{{__('Facebook Chat')}}</label>
                            </div>
                            <div class="col-lg-6">
                                <label class="switch">
                                    <input value="1" name="facebook_chat" type="checkbox" @if (\App\BusinessSetting::where('type', 'facebook_chat')->first()->value == 1)
                                        checked
                                    @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="types[]" value="FACEBOOK_PAGE_ID">
                            <div class="col-lg-3">
                                <label class="control-label">{{__('Facebook Code Javascript')}}</label>
                            </div>
                            <div class="col-lg-6">
                            <textarea class="form-control" name="FACEBOOK_PAGE_ID"  placeholder="Facebook Page ID" required>
                                {{ isset($business_settings->where('type', 'FACEBOOK_PAGE_ID')->first()->value)?$business_settings->where('type', 'FACEBOOK_PAGE_ID')->first()->value:''}}
                            </textarea>
                                <!--<input type="text" class="form-control" name="FACEBOOK_PAGE_ID" value="{{ isset($business_settings->where('type', 'FACEBOOK_PAGE_ID')->first()->value)?$business_settings->where('type', 'FACEBOOK_PAGE_ID')->first()->value:''}}" placeholder="Facebook Page ID" required>-->
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
