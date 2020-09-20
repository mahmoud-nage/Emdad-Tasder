@extends('layouts.app')

@section('content')
    <form class="form-horizontal" action="{{ route('affiliates.settings.update') }}" method="POST">
        @csrf

        <div class="row col-lg-6">
            <div class="col-lg-12">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">{{__('Coupon Percentage')}}</h3>
                    </div>
                    <div class="panel-body">
                        <input type="hidden" name="types[]" value="coupon_percentage">
                        <div class="form-group">
                            <div class="col-lg-3">
                                <label class="control-label">{{__('Coupon Percentage')}}</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="values[]"
                                       value="{{  $coupon_percentage->value }}" placeholder="Coupon Percentage"
                                       required>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">{{__('Affiliate Percentage')}}</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-lg-3">
                                <label class="control-label">{{__('Affiliate Percentage')}}</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="affiliate_percentage"
                                       value="{{  $affiliate_percentage->value }}" placeholder="Coupon Percentage"
                                       required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">{{__('Affiliate max discount')}}</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-lg-3">
                                <label class="control-label">{{__('Affiliate max discount')}}</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="affiliate_max_discount"
                                       value="{{  $affiliate_max_discount->value }}" placeholder="Coupon Percentage"
                                       required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row col-lg-6">
            <div class="col-lg-12">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">{{__('EGY Mail')}}</h3>
                    </div>
                    <div class="panel-body">
                        <input type="hidden" name="payment_method" value="stripe">
                        <div class="form-group">
                            <div class="col-lg-3">
                                <label class="control-label">{{__('EGY Mail')}}</label>
                            </div>
                            <div class="col-lg-6">
                                <label class="switch">
                                    <input value="1" name="egy_mail" type="checkbox" @if ($egy_mail->value == 1)
                                    checked
                                        @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">{{__('paypal')}}</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-lg-3">
                                <label class="control-label">{{__('Paypal')}}</label>
                            </div>
                            <div class="col-lg-6">
                                <label class="switch">
                                    <input value="1" name="paypal_payment" type="checkbox" @if ($paypal_payment->value == 1)
                                    checked
                                        @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">{{__('Bank account')}}</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-lg-3">
                                <label class="control-label">{{__('Bank account')}}</label>
                            </div>
                            <div class="col-lg-6">
                                <label class="switch">
                                    <input value="1" name="bank" type="checkbox"
                                           @if ($bank->value == 1)
                                                   checked
                                           @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12 text-right">
                <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
            </div>
        </div>
    </form>
@endsection
