@extends('frontend.layouts.app')
@section('title' , __('general.payment_history') )
@section('meta')
<meta name="keywords" content="{{ $seo_setting->keyword }}">
<meta name="description" content="{{ $seo_setting->description}}">
<meta property="og:title" content="{{__('general.payment_history')}}" />
<meta property="og:description" content="{{ $seo_setting->description}}" />
@endsection
@section('content')

<div class="container-fluid">
    <!-- Content -->
    <div class="page-wrap profile-page">
        <!-- Menu -->
        @include('frontend.inc.seller_side_nav')
        <!--  Content -->
        <div class="main-content">
            <!--  Dashboard  -->
            <div class="profile-title">
                {{__('general.payment_history')}}
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-lg-4">
                    <div class=" dashboard-stat stat-products">
                        <div class="stat-title">
                            {{__('general.available_balance')}}
                        </div>
                        <div class="stat-number">
                            <span class="counter">
                                @php
                                $total_pendding = 0;
                                $total_available = 0;
                                $total = 0;
                                $orderDetails = DB::table('order_details')
                                ->orderBy('id', 'desc')
                                ->join('orders', 'orders.id', '=', 'order_details.order_id')
                                ->where('orders.payment_request', 0)
                                ->where('order_details.seller_id', Auth::user()->id)
                                ->where('order_details.delivery_status','delivered')
                                ->select('order_details.id')
                                ->get();


                                if($orderDetails != null){
                                foreach($orderDetails as $orderDetail_id){

                                $orderDetail = \App\OrderDetail::find($orderDetail_id->id);
                                if(strtotime("+".$general_setting->withdrawal_duration." day",
                                strtotime($orderDetail->created_at)) >= strtotime(now())){

                                $total_pendding += $orderDetail->price - $orderDetail->commission;

                                }elseif(strtotime("+".$general_setting->withdrawal_duration." day",
                                strtotime($orderDetail->created_at)) <= strtotime(now())){ $total_available
                                    +=$orderDetail->price - $orderDetail->commission;
                                    }

                                    $total += $orderDetail->price - $orderDetail->commission;
                                    }
                                    }
                                    @endphp
                                    {{ $total_available }}
                            </span>
                        </div>
                        <div class="stat-icon">
                            <img src="{{ asset('assets/seller/images/Asset%201.png') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-4">
                    <div class=" dashboard-stat stat-sale">
                        <div class="stat-title">
                            {{__('general.pending_balance')}}
                        </div>
                        <div class="stat-number">
                            <span class="counter">
                                {{ $total_pendding }}
                            </span>
                        </div>
                        <div class="stat-icon">
                            <img src="{{ asset('assets/seller/images/Asset%202.png') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-4">
                    <div class=" dashboard-stat stat-prescription">
                        <div class="stat-title">
                            {{__('general.withdrawn_balance')}}
                        </div>
                        <div class="stat-number">
                            <span
                                class="counter">{{isset(auth()->user()->seller_payments)?auth()->user()->seller_payments->where('status',2)->sum('amount'):0}}</span>
                        </div>
                        <div class="stat-icon">
                            <img src="{{ asset('assets/seller/images/Asset%203.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 margin-10">
                    @if($total_available>0)
                    <a href="#" class="btn btn-success" data-toggle="modal"
                        data-target="#withdrawModal">{{__('general.withdrawn')}}</a>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 ">
                    <br><br>
                    <div class="table-wrapper">
                        <div class="table-block">
                            <table class="table table-responsive table-hover table-striped">
                                <thead>
                                    <tr>


                                        <th class="reorder">#</th>
                                        <th class="reorder">{{__('forms.date')}}</th>
                                        <th class="">{{__('general.amount')}}</th>
                                        <th class="">{{__('general.payment_method')}}</th>
                                        <th class="">{{__('forms.status')}}</th>
                                        <th class="">{{__('general.image')}}</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (auth()->user()->seller_payments as $key => $payment)
                                    <tr>
                                        <td>
                                            {{ $key+1 }}
                                        </td>
                                        <td>{{ date('d-m-Y', strtotime($payment->created_at)) }}</td>
                                        <td>
                                            {{ single_price($payment->amount) }}
                                        </td>
                                        <td>
                                            @if($payment->payment_method == 1)
                                            <span class="label label-info">{{__('general.bank')}}</span>
                                            @endif
                                            @if($payment->payment_method == 2)
                                            <span class="label">{{__('general.postal')}}</span>
                                            @endif
                                            @if($payment->payment_method == 3)
                                            <span class="label">{{__('general.vodafone_cache')}}</span>
                                            @endif
                                        </td>
                                        @if($payment->status == 0)
                                        <td><span class="label label-warning">{{__('general.pending')}}</span></td>
                                        @elseif($payment->status == 1)
                                        <td><span class="label label-danger">In Progress</span></td>
                                        @elseif($payment->status == 2)
                                        <td><span class="label label-success">{{__('general.withdrawl')}}</span></td>
                                        @endif
                                        @if($payment->file != null)
                                        <td>
                                            <a href="{{asset($payment->file)}}" data-fancybox="gallary">
                                                <img class="img-md" style="max-width: 64px;max-height: 64px;"
                                                    src="{{ asset($payment->file)}}" alt=""></td>
                                        </a>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<div class="modal fade" id="withdrawModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title color-main text-center">{{__('general.withdrawn')}}</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form action="{{route( 'seller.seller_payment_request',['country' => get_country()->code])}}" class="form-style">
                        @csrf
                        <h5 class="text-muted">{{__('general.withdrawn_msg')}} : {{$total_available}} LE</h5>
                        <br>
                        <div class="form-group">
                            <!--<label>{{__('general.amount')}}</label>-->
                            <input class="form-control" type="hidden" min="1" max="{{$total_available}}" name="amount"
                                value="{{$total_available}}">
                            <input type="hidden" name="seller_id" value="{{Auth::user()->id}}" id="">
                        </div>

                        <div class="form-group">
                            <label>{{__('general.method_choise')}}</label>
                            <select name="payment_method" class="form-control">
                                @if(Auth::user()->seller->bank_account_status)
                                <option value="1">{{__('general.bank')}}</option>
                                @endif
                                @if(Auth::user()->seller->postal_status)
                                <option value="1">{{__('general.postal')}}</option>
                                @endif
                                @if(Auth::user()->seller->vodafone_status)
                                <option value="1">{{__('general.vodafone_cache')}}</option>
                                @endif
                            </select>
                        </div>


                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-main">{{__('general.send')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div style="position: relative;bottom: -40px;">
    @include('frontend.seller.footer_tabs')
</div>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.js"
    integrity="sha512-j7/1CJweOskkQiS5RD9W8zhEG9D9vpgByNGxPIqkO5KrXrwyDAroM9aQ9w8J7oRqwxGyz429hPVk/zR6IOMtSA=="
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"
    integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA=="
    crossorigin="anonymous"></script>

@endsection