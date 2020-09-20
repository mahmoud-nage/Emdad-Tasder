@extends('frontend.layouts.app')
@section('title' , __('general.purchase_history') )
@section('meta')
    <meta name="keywords" content="{{ $seo_setting->keyword }}">
    <meta name="description" content="{{ $seo_setting->description}}">
<meta property="og:title" content="{{__('general.purchase_history')}}" />
    <meta property="og:description" content="{{ $seo_setting->description}}"/>
@endsection
@section('content')
    <!-- Page Contents Wrapper-->
    <div class="container">
        <!-- Content -->
        <div class="page-wrap">
            <!-- Menu -->
        @include('frontend.inc.customer_side_nav')
        <!--  Content -->
            <div class="main-content">
                <br><br>
                <div class="table-wrapper">
                    <div class="table-block">
                        <table class="table table-responsive table-striped table-hover ">
                            <thead>
                            <tr>
                                <th class="reorder">#</th>
                                <th class="reorder">{{__('general.order_number')}}</th>
                                <th class="reorder">{{__('general.order_date')}}</th>
                                <th class="">{{__('forms.price')}}</th>
                                <th class=""> {{__('general.payment_status')}}</th>
                                <th class="">{{__('forms.optional')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($orders as $key => $order)
                                <tr>
                                    <td>
                                        {{ $key+1 }}
                                    </td>
                                    <td>
                                        <a href="#{{ $order->code }}"
                                           onclick="show_purchase_history_details({{ $order->id }})">{{ $order->code }}</a>
                                    </td>
                                    <td>{{ date('d-m-Y', $order->date) }}</td>
                                    <td>
                                        {{ single_price($order->grand_total) }}
                                    </td>
                                    <td>
                                        @if($order->status_id > 0) 
                                        {{ $order->status['name_'. app()->getLocale()] }}
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown custom-dropdown">
                                            <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: transparent;border: 0;}">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="javascript:void(0)" onclick="show_purchase_history_details({{ $order->id }})">{{__('general.details')}}</a></li>
                                                <li role="separator" class="divider"></li>
                                                <li><a target="blank" href="{{ route('customer.invoice.download', $order->id) }}">{{__('general.download_invoice')}}</a></li>
                                                @if($order->payment_type == 'accept_card' && $order->status_id == 1 && isset(json_decode($order->payment_details)->payment_token))
                                                <li role="separator" class="divider"></li>
                                                <li>
                                                <a href="{{route('weaccept_card.payment', ['country' => get_country()->code, 'token'=>json_decode($order->payment_details)->payment_token])}}">{{__('general.continue_check_out')}}</a>
                                                </li>
                                                @endif
                                                @if($order->status_id == 1)
                                                <li role="separator" class="divider"></li>
                                                <li>
                                                <a href="{{route('purchase_history.cancel',  ['country' => get_country()->code, 'id'=>$order->id])}}">{{__('forms.cancel')}}</a>
                                                </li>
                                                @endif
                                                @if($order->status_id == 3)
                                                <li role="separator" class="divider"></li>
                                                <li>
                                                <a href="{{route('purchase.follow.get', ['country' => get_country()->code]).'?code='.$order->code}}">{{__('general.follow_order')}}</a>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $orders->links() }}

                </div>

            </div>

        </div>
    </div>
    <div class="modal fade order-modal" id="order_details" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="c-preloader">
                    <i class="fa fa-spin fa-spinner"></i>
                </div>
                <div id="order-details-modal-body">

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


@endsection
