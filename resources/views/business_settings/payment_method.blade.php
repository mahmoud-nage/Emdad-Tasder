@extends('layouts.app')

@section('content')

<div class="row">
    
    <!--<div class="col-lg-6">-->
    <!--    <div class="panel">-->
    <!--        <div class="panel-heading">-->
    <!--            <h3 class="panel-title text-center">{{__('Paypal Credential')}}</h3>-->
    <!--        </div>-->
    <!--        <div class="panel-body">-->
    <!--            <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">-->
    <!--                <input type="hidden" name="payment_method" value="paypal">-->
    <!--                @csrf-->
    <!--                <div class="form-group">-->
    <!--                    <input type="hidden" name="types[]" value="PAYPAL_CLIENT_ID">-->
    <!--                    <div class="col-lg-3">-->
    <!--                        <label class="control-label">{{__('Paypal Client Id')}}</label>-->
    <!--                    </div>-->
    <!--                    <div class="col-lg-6">-->
    <!--                        <input type="text" class="form-control" name="PAYPAL_CLIENT_ID" value="{{  env('PAYPAL_CLIENT_ID') }}" placeholder="Paypal Client ID" required>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--                <div class="form-group">-->
    <!--                    <input type="hidden" name="types[]" value="PAYPAL_CLIENT_SECRET">-->
    <!--                    <div class="col-lg-3">-->
    <!--                        <label class="control-label">{{__('Paypal Client Secret')}}</label>-->
    <!--                    </div>-->
    <!--                    <div class="col-lg-6">-->
    <!--                        <input type="text" class="form-control" name="PAYPAL_CLIENT_SECRET" value="{{  env('PAYPAL_CLIENT_SECRET') }}" placeholder="Paypal Client Secret" required>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--                <div class="form-group">-->
    <!--                    <div class="col-lg-3">-->
    <!--                        <label class="control-label">{{__('Paypal Sandbox Mode')}}</label>-->
    <!--                    </div>-->
    <!--                    <div class="col-lg-6">-->
    <!--                        <label class="switch">-->
    <!--                            <input value="1" name="paypal_sandbox" type="checkbox" @if (\App\BusinessSetting::where('type', 'paypal_sandbox')->first()->value == 1)-->
    <!--                                checked-->
    <!--                            @endif>-->
    <!--                            <span class="slider round"></span>-->
    <!--                        </label>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--                <div class="form-group">-->
    <!--                    <div class="col-lg-12 text-right">-->
    <!--                        <button class="btn btn-purple" type="submit">{{__('Save')}}</button>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </form>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
    
    <!--<div class="col-lg-6">-->
    <!--    <div class="panel">-->
    <!--        <div class="panel-heading">-->
    <!--            <h3 class="panel-title text-center">{{__('Stripe Credential')}}</h3>-->
    <!--        </div>-->
    <!--        <div class="panel-body">-->
    <!--            <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">-->
    <!--                @csrf-->
    <!--                <input type="hidden" name="payment_method" value="stripe">-->
    <!--                <div class="form-group">-->
    <!--                    <input type="hidden" name="types[]" value="STRIPE_KEY">-->
    <!--                    <div class="col-lg-3">-->
    <!--                        <label class="control-label">{{__('Stripe Key')}}</label>-->
    <!--                    </div>-->
    <!--                    <div class="col-lg-6">-->
    <!--                        <input type="text" class="form-control" name="STRIPE_KEY" value="{{  env('STRIPE_KEY') }}" placeholder="STRIPE KEY" required>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--                <div class="form-group">-->
    <!--                    <input type="hidden" name="types[]" value="STRIPE_SECRET">-->
    <!--                    <div class="col-lg-3">-->
    <!--                        <label class="control-label">{{__('Stripe Secret')}}</label>-->
    <!--                    </div>-->
    <!--                    <div class="col-lg-6">-->
    <!--                        <input type="text" class="form-control" name="STRIPE_SECRET" value="{{  env('STRIPE_SECRET') }}" placeholder="STRIPE SECRET" required>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--                <div class="form-group">-->
    <!--                    <div class="col-lg-12 text-right">-->
    <!--                        <button class="btn btn-purple" type="submit">{{__('Save')}}</button>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </form>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
    
    <div class="col-lg-6">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title text-center">{{__('Accept Credential')}}</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="payment_method" value="accept">
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="ACCEPT_KEY">
                        <div class="col-lg-3">
                            <label class="control-label">{{__('ACCEPT KEY')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="ACCEPT_KEY" value="{{ isset($business_settings->where('type', 'ACCEPT_KEY')->first()->value)?$business_settings->where('type', 'ACCEPT_KEY')->first()->value:''}}" placeholder="ACCEPT KEY" required>
                        </div>
                    </div>
                     <div class="form-group">
                        <input type="hidden" name="types[]" value="ACCEPT_CARD_INTEGRATION_ID">
                        <div class="col-lg-6">
                            <label class="control-label">{{__('ACCEPT CARD INTEGRATION ID')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="ACCEPT_CARD_INTEGRATION_ID" value="{{ isset($business_settings->where('type', 'ACCEPT_CARD_INTEGRATION_ID')->first()->value)?$business_settings->where('type', 'ACCEPT_CARD_INTEGRATION_ID')->first()->value:''}}" placeholder="ACCEPT CARD INTEGRATION ID" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="ACCEPT_KOISK_INTEGRATION_ID">
                        <div class="col-lg-6">
                            <label class="control-label">{{__('ACCEPT KOISK INTEGRATION ID')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="ACCEPT_KOISK_INTEGRATION_ID" value="{{ isset($business_settings->where('type', 'ACCEPT_KOISK_INTEGRATION_ID')->first()->value)?$business_settings->where('type', 'ACCEPT_KOISK_INTEGRATION_ID')->first()->value:''}}" placeholder="ACCEPT KOISK INTEGRATION ID" required>
                        </div>
                    </div>
                     <div class="form-group">
                        <input type="hidden" name="types[]" value="ACCEPT_VALU_INTEGRATION_ID">
                        <div class="col-lg-6">
                            <label class="control-label">{{__('ACCEPT VALU INTEGRATION ID')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="ACCEPT_VALU_INTEGRATION_ID" value="{{ isset($business_settings->where('type', 'ACCEPT_VALU_INTEGRATION_ID')->first()->value)?$business_settings->where('type', 'ACCEPT_VALU_INTEGRATION_ID')->first()->value:''}}" placeholder="ACCEPT VALU INTEGRATION ID" required>
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
