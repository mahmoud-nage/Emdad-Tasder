@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-6">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title text-center">{{__('Smsa Credential')}}</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="{{ route('shipment_method.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="shipment_method" value="smsa">
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="SAMSA_PASS_KEY">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Smsa KEY')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="SAMSA_PASS_KEY" value="{{  isset($business_settings->where('type', 'SAMSA_PASS_KEY')->first()->value)?$business_settings->where('type', 'SAMSA_PASS_KEY')->first()->value:'' }}" placeholder="Smsa KEY" required>
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
    
    <div class="col-lg-6">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title text-center">{{__('Aramex Credential')}}</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="{{ route('shipment_method.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="shipment_method" value="aramex">
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="ARAMEX_ACCOUNT_NUMBER">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Account Number')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="ARAMEX_ACCOUNT_NUMBER" value="{{  isset($business_settings->where('type', 'ARAMEX_ACCOUNT_NUMBER')->first()->value)?$business_settings->where('type', 'ARAMEX_ACCOUNT_NUMBER')->first()->value:''}}" placeholder="Account Number" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="ARAMEX_USER_NAME">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('User Name')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="ARAMEX_USER_NAME" value="{{  isset($business_settings->where('type', 'ARAMEX_USER_NAME')->first()->value)?$business_settings->where('type', 'ARAMEX_USER_NAME')->first()->value:'' }}" placeholder="User Name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="ARAMEX_PASSWORD">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Password')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="ARAMEX_PASSWORD" value="{{ isset($business_settings->where('type', 'ARAMEX_PASSWORD')->first()->value)?$business_settings->where('type', 'ARAMEX_PASSWORD')->first()->value:'' }}" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="ARAMEX_ACCOUNT_BIN">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('AccountPin')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="ARAMEX_ACCOUNT_BIN" value="{{ isset($business_settings->where('type', 'ARAMEX_ACCOUNT_BIN')->first()->value)?$business_settings->where('type', 'ARAMEX_ACCOUNT_BIN')->first()->value:''}}" placeholder="AccountPin" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="ARAMEX_ACCOUNT_ENTITY">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('AccountEntity')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="ARAMEX_ACCOUNT_ENTITY" value="{{ isset($business_settings->where('type', 'ARAMEX_ACCOUNT_ENTITY')->first()->value)?$business_settings->where('type', 'ARAMEX_ACCOUNT_ENTITY')->first()->value:''}}" placeholder="AccountEntity" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="ARAMEX_ACCOUNT_COUNTRY_CODE">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('AccountCountryCode')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="ARAMEX_ACCOUNT_COUNTRY_CODE" value="{{ isset($business_settings->where('type', 'ARAMEX_ACCOUNT_COUNTRY_CODE')->first()->value)?$business_settings->where('type', 'ARAMEX_ACCOUNT_COUNTRY_CODE')->first()->value:'' }}" placeholder="AccountCountryCode" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="ARAMEX_VERSION">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('Version')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="ARAMEX_VERSION" value="{{ isset($business_settings->where('type', 'ARAMEX_VERSION')->first()->value)?$business_settings->where('type', 'ARAMEX_VERSION')->first()->value:'' }}" placeholder="Version" required>
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
