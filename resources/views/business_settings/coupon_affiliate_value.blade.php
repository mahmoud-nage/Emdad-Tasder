@extends('layouts.app')

@section('content')


    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title text-center">{{__('Set Coupon value')}}</h3>
        </div>
        @php
            $settings = \App\BusinessSetting::where('type' , 'coupon_affiliate_value')->first();
        @endphp
        <div class="panel-body">
            <form class="form-horizontal" action="{{ route('coupon.affiliate.settings.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <div class="col-lg-3">
                        <label class="control-label">{{__('Symbol Format')}}</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="number" class="form-control" name="discount"
                               value="{{ explode('_',$settings->value)[0] }}" placeholder="Discount">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-3">
                        <label class="control-label">{{__('Discount Type')}}</label>
                    </div>
                    <div class="col-lg-6">
                        <select class="form-control" name="discount_type">
                            <option value="percent" @if(explode('_',$settings->value)[1] == 'percent') selected @endif>
                                Percentage
                            </option>
                            <option value="amount" @if(explode('_',$settings->value)[1] == 'amount') selected @endif>
                                Amount
                            </option>
                        </select>
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


@endsection

@section('script')

@endsection
