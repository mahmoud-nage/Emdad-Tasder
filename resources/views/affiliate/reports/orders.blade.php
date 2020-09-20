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
                            Orders Reports
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">

                    <!--begin: Search Form -->
                    <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Confirmed Orders</th>
                            <th>Pending Orders</th>
                            <th>Total Earnings</th>
                            <th>Confirmed Earnings</th>
                            <th>Pending Earning</th>
                            <th>CTR</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $report)
                            <tr>
                                <td>{{$report['date']}}</td>
                                <td>{{$report['confirmed_orders']}}</td>
                                <td>{{$report['pending_orders']}}</td>
                                <td>{{$report['total_earnings']}}</td>
                                <td>{{$report['confirmed_earnings']}}</td>
                                <td>{{$report['pending_earnings']}}</td>
                                <td>{{$report['CTR']}}</td>
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
