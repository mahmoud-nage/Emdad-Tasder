@extends('affiliate.layouts.app')
@php
    $affiliate_max_discount = \App\BusinessSetting::where('type', 'affiliate_max_discount ')->first();
@endphp
@section('content')
    <div class="panel" id="requestPayment">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Request Payment')}}</h3>
        </div>
        <!--Horizontal Form-->
        <div
            class="kt-portlet kt-portlet--fit kt-portlet--head-lg kt-portlet--head-overlay kt-portlet--skin-solid kt-portlet--height-fluid">
            <div class="kt-portlet__body kt-portlet__body--fit">
                <div class="kt-widget17">
                    <div
                        class="kt-widget17__visual kt-widget17__visual--chart kt-portlet-fit--top kt-portlet-fit--sides"
                        style="background-color: #fd397a">
                        <div class="kt-widget17__chart" style="height:100px;">
                            <canvas id="kt_chart_activities"></canvas>
                        </div>
                    </div>
                    <div class="kt-widget17__stats">
                        <div class="kt-widget17__items">
                            <div class="kt-widget17__item"
                                 style="border-style: solid;  border-color: #fd397a; border-width: .5px;">
                                <span class="kt-widget17__icon"></span>
                                <span class="kt-widget17__subtitle">Total Available Amount</span>
                                <span
                                    class="kt-widget17__desc"><strong>{{ $totalEarning['totalAvailableAmount'] }}</strong></span>
                            </div>
                            <div class="kt-widget17__item"
                                 style="border-style: solid;  border-color: #fd397a; border-width: .5px;">
                                <span class="kt-widget17__icon"> </span>
                                <span class="kt-widget17__subtitle">{{__('Total pending amount')}}</span>
                                <span class="kt-widget17__desc"><strong>{{$totalEarning['totalpendingAmount']}}</strong></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--        v-on:submit.prevent="onSubmit"--}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" id="paymentForm" accept-charset="UTF-8"
              action="{{ route('affiliate.payment_requests.store') }}">
            @csrf
            <input type="hidden" name="affiliate_id" value="{{auth()->user()->Affiliate->id}}"> <br>
            <div class="form-group row">
                <label class="col-form-label col-lg-3 col-sm-12">Amount *</label>
                <select class="form-control col-lg-3 col-sm-12 selectpicker" multiple data-live-search="true"
                        id="order_ids" name="order_ids[]" required="required">
                    @foreach($orders as $order)
                        <option
                            value="{{$order->id}}">
                            @php
                                $profit = $order->grand_total * ($affiliate_percentage->value / 100);
                                if ($profit<$affiliate_max_discount->value){
        echo ($profit);
    }else{
                                    echo($affiliate_max_discount->value);
    }
                                    $affiliate_max_discount->value;
                            @endphp</option>
                    @endforeach
                </select>

                <input
                    type="hidden" name="amount" min="1" max="{{$totalEarning['totalAvailableAmount']}}"
                    value="{{$totalEarning['totalAvailableAmount']}}"
                    accept="any" placeholder="Amount" required="required" class="form-control col-lg-3 col-sm-12">
            </div>
            <div class="form-group row">
                <label for="payment_method" class="col-form-label col-lg-3 col-sm-12">Payment method *</label>
                <select class="form-control col-lg-3 col-sm-12" id="payment_method" name="payment_method"
                        @change="onChange($event)" class="form-control" v-model="key" required="required">
                    @foreach($paymentMethods as $key => $method)
                        <option value="{{$key}}">{{$method}}</option>
                        @endforeach
                </select>
            </div>
            <div v-if="bank" id="banck">
                <div class="form-group row">
                    <label for="national_name"
                           class="col-form-label col-lg-3 col-sm-12">{{__('general.name')}}</label>
                    <input type="text" name="national_name" id="national_name" required="required"
                           placeholder="{{__('general.name')}}" class="form-control col-lg-3 col-sm-12">
                </div>
                <div class="form-group row">
                    <label for="national_id"
                           class="col-form-label col-lg-3 col-sm-12">{{__('general.national_id')}}</label>
                    <input type="number" name="national_id" id="national_id" required="required"
                           placeholder="{{__('general.national_id')}}" class="form-control col-lg-3 col-sm-12">
                </div>
                <div class="form-group row">
                    <label for="bank_name" class="col-form-label col-lg-3 col-sm-12">Bank Name*</label>
                    <input type="text" name="bank_name" id="bank_name" placeholder="Bank name" required="required"
                           class="form-control col-lg-3 col-sm-12">
                </div>

                <div class="form-group row">
                    <label for="bank_account_number" class="col-form-label col-lg-3 col-sm-12">Bank Account
                        Number*</label>
                    <input type="number" name="bank_account_number" id="bank_account_number" required="required"
                           placeholder="account number" class="form-control col-lg-3 col-sm-12">
                </div>
            </div>
            <div v-else-if="egyptionMail" id="egyptionMail">
                <div class="form-group row">
                    <label for="national_name"
                           class="col-form-label col-lg-3 col-sm-12">{{__('general.name')}}</label>
                    <input type="text" name="national_name" id="national_name" required="required"
                           placeholder="{{__('general.name')}}" class="form-control col-lg-3 col-sm-12">
                </div>

                <div class="form-group row">
                    <label for="national_id"
                           class="col-form-label col-lg-3 col-sm-12">{{__('general.national_id')}}</label>
                    <input type="number" name="national_id" id="national_id" required="required"
                           placeholder="{{__('general.national_id')}}" class="form-control col-lg-3 col-sm-12">
                </div>

            </div>
            <div v-else-if="paypal" id="Paypal">
                <div class="form-group row">
                    <label for="paypal_email" class="col-form-label col-lg-3 col-sm-12">Paypal Account
                        Email*</label>
                    <input type="text" name="paypal_email" id="paypal_email" placeholder="Paypal Account Email"
                           class="form-control col-lg-3 col-sm-12" required="required">
                </div>
            </div>
            <div v-else id="empty">
                <div class="alert alert-danger col-form-label col-lg-3 col-sm-12" role="alert">
                    <h6>Please select payment method first</h6>
                </div>
            </div>

            <div class="modal-footer">
                <button style="float: left" type="submit" class="btn btn-primary">Request Payment.</button>
            </div>
        </form>
    </div>
@stop

@section('script')
    <script>
        var vm = new Vue({
            el: "#requestPayment",
            data: {
                key: "",
                bank: false,
                egyptionMail: false,
                paypal: false,
                requestPayment: {},
            },
            methods: {
                onChange(event) {
                    console.log(event.target.value);
                    if (event.target.value == 1) {
                        this.bank = true;
                        this.egyptionMail = false;
                        this.paypal = false;
                    } else if (event.target.value == 2) {
                        this.bank = false;
                        this.egyptionMail = true;
                        this.paypal = false;
                    } else if (event.target.value == 3) {
                        this.bank = false;
                        this.egyptionMail = false;
                        this.paypal = true;
                    } else {
                        this.bank = false;
                        this.egyptionMail = false;
                        this.paypal = false;
                    }
                },
                onSubmit() {
                    console.log("{!! route('affiliate.payment_requests.store') !!}")
                    let paymentForm = document.getElementById('paymentForm');
                    let formData = new FormData(paymentForm);
                    for (var value of formData.values()) {
                        console.log(value);
                    }
                    this.axios.post("{!! route('affiliate.payment_requests.store') !!}", {
                        name: formData
                    }).then(function (response) {
                        console.log(response);
                    }).catch(function (error) {
                        console.log(error);
                    });
                    {{--$.ajax({--}}
                    {{--    url: "{!! route('affiliate.payment_requests.store') !!}",--}}
                    {{--    type: 'POST',--}}
                    {{--    data: formData,--}}
                    {{--}).then((response) => {--}}
                    {{--    console.log(response);--}}
                    {{--});--}}
                }
            }
        });
    </script>
@stop
