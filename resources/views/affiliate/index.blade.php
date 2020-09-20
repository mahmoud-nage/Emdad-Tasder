@extends('affiliate.layouts.app')

@section('content')

    <div id="home" class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

        <!--Begin::Dashboard 1-->

        <!--Begin::Row-->

        <div class="row">
            <div class="col-lg-6 col-xl-4 order-lg-1 order-xl-1">

                <!--begin:: Widgets/Activity-->
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
                                    <div class="kt-widget17__item">
														<span class="kt-widget17__icon">
															 </span>
                                        <span class="kt-widget17__subtitle">Total visits</span>
                                        <span class="kt-widget17__desc">{{ $visits }}</span>
                                    </div>
                                    <div class="kt-widget17__item">
															<span class="kt-widget17__icon">
															 </span>
                                        <span class="kt-widget17__subtitle">
                                                        {{__('general.total_orders')}}
															</span>
                                        <span class="kt-widget17__desc">
																{{ $totalOrders  }}
															</span>
                                    </div>
                                </div>
                                <div class="kt-widget17__items">
                                    <div class="kt-widget17__item">
															<span class="kt-widget17__icon">
																 </span>
                                        <span class="kt-widget17__subtitle"> Total Confirmed Orders </span>
                                        <span class="kt-widget17__desc"> {{ $totalConfirmedOrders }} </span>
                                    </div>
                                    <div class="kt-widget17__item">
                                        <span class="kt-widget17__icon"></span>
                                        <span class="kt-widget17__subtitle">
																Total Pended Orders
															</span>
                                        <span class="kt-widget17__desc">
																{{ $totalPendingOrders}}
															</span>
                                    </div>
                                </div>
                                <div class="kt-widget17__items">
                                    <div class="kt-widget17__item"><span class="kt-widget17__icon"></span>
                                        <span class="kt-widget17__subtitle">Total Confirmed Orders Sales</span>
                                        <span class="kt-widget17__desc">{{ $totalConfirmedOrdersSales }}</span>
                                    </div>
                                    <div class="kt-widget17__item"><span class="kt-widget17__icon"></span>
                                        <span class="kt-widget17__subtitle">Total Pended Orders Sales</span>
                                        <span class="kt-widget17__desc">{{ $totalPendedOrdersSales }}</span>
                                    </div>
                                </div>
                                <div class="kt-widget17__items">
                                    <div class="kt-widget17__item"><span class="kt-widget17__icon"></span>
                                        <span class="kt-widget17__subtitle">CTR</span>
                                        <span class="kt-widget17__desc">{{ $ctr }} %</span>
                                    </div>
                                    <div class="kt-widget17__item"><span class="kt-widget17__icon"></span>
                                        <span class="kt-widget17__subtitle">Coupon</span>
                                        <span class="kt-widget17__desc">{{ $affiliate_coupon->code }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--end:: Widgets/Activity-->
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        var x = 1;
        var home = new Vue({
            el: "#home",
            data: {
                urls: {},
                egyptian_mail_status: '{!! $affiliate->egyptian_mail_status == 1 ? true : false !!}',
                bank_account_status: '{!! $affiliate->bank_account_status == 1 ? true : false !!}',
                query: $(location).attr('search'),
                base_url: "{!! url('/') !!}",
                url: "{!! request()->url() !!}",
            },
        });
    </script>
@stop
