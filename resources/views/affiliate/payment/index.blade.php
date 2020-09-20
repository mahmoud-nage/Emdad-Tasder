@extends('affiliate.layouts.app')
@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="products">

    <!-- end:: Subheader -->

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head kt-portlet__head--lg">
                    <div class="kt-portlet__head-label">
										<span class="kt-portlet__head-icon">
											<i class="kt-font-brand flaticon2-box"></i>
										</span>
                        <h3 class="kt-portlet__head-title">
                            Payment Requests
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">

                    <!--begin: Search Form -->
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Payment method</th>
                            <th>Name</th>
                            <th>National ID</th>
                            <th>Bank name</th>
                            <th>Bank account number</th>
                            <th>Paypal email</th>
                            <th>confirm info</th>
                            <th>status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $paymentRequest)
                            <tr>
                                <td>{{$paymentRequest->created_at->formatLocalized('%A %e %B %Y')}}</td>
                                <td>{{$paymentRequest['amount'].' '.$currency}}</td>
                                @switch($paymentRequest['payment_method'])
                                    @case (1)
                                    <td>Bank account</td>
                                    @break
                                    @case (2)
                                    <td>Egyption Email</td>
                                    @break
                                    @case (3)
                                    <td>Paypal</td>
                                    @break
                                @endswitch
                                <td>{{$paymentRequest['name']}}</td>
                                <td>{{$paymentRequest['national_id']}}</td>
                                <td>{{$paymentRequest['bank_name']}}</td>
                                <td>{{$paymentRequest['banck_account_number']}}</td>
                                <td>{{$paymentRequest['paypal_email']}}</td>
                                <td>
                                    <a href="{{asset($paymentRequest['file'])}}">
                                        @php
                                            $name = explode("/",$paymentRequest['file']);
                                            echo($name[count($name)-1]);
                                        @endphp</a>
                                    </td>
                                <td>{{$paymentRequest['status']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!--end: Search Form -->
                </div>
            </div>
        </div>

        <!-- end:: Content -->
    </div>
@stop
