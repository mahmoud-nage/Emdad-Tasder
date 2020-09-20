@extends('frontend.layouts.app')
@section('title' , __('general.orders') )
@section('meta')
    <meta name="keywords" content="{{ $seo_setting->keyword }}">
    <meta name="description" content="{{ $seo_setting->description}}">
<meta property="og:title" content="{{__('general.orders')}}" />
    <meta property="og:description" content="{{ $seo_setting->description}}"/>
@endsection
@section('content')

    <div class="container-fluid">
        <!-- Content -->
        <div class="page-wrap profile-page">
            <!-- Menu -->
        @include('frontend.inc.seller_side_nav')
        <!--  Content -->
            <div class="main-content">

                <!-- Branch -->
                <div class="profile-title">
                    {{__('general.orders')}}
                </div>
                <div class="table-wrapper">
                    <div class="table-block">
                        <table class="table table-responsive table-hover ">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('general.order_number')}}</th>
                                <th>{{__('general.products_number')}}</th>
                                <th>{{__('general.customer')}}</th>
                                <th>{{__('forms.price')}}</th>
                                <th>{{__('forms.status')}}</th>
                                <th>{{__('forms.options')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($orders as $key => $order_id)
                                @php
                                    $order = \App\Order::find($order_id->id);
                                @endphp
                                @if($order != null)
                                    <tr>
                                        <td>
                                            {{ $key+1 }}
                                        </td>
                                        <td>
                                            <a href="#{{ $order->code }}" onclick="show_order_details({{ $order->id }})">{{ $order->code }}</a>
                                        </td>
                                        <td>
                                            {{ count($order->orderDetails->where('seller_id', Auth::user()->id)) }}
                                        </td>
                                        <td>
                                            @if ($order->user_id != null)
                                                {{ $order->user->name }}
                                            @else
                                                Guest ({{ $order->guest_id }})
                                            @endif
                                        </td>
                                        <td>
                                            {{ $order->orderDetails->where('seller_id', Auth::user()->id)->sum('price') }}{{  isset($order->country->Currency['name_'.app()->getLocale()])?  $order->country->Currency['name_'.app()->getLocale()]:'' }}
                                        </td>
                                        <td>
                                        @if($order->status_id > 0) 
                                            {{ $order->status['name_'. app()->getLocale()] }}
                                        @endif
                                        </td>
                                        <td>
                                            <div class="dropdown custom-dropdown">
                                                <a class="dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="javascript:void(0)" onclick="show_purchase_history_details({{ $order->id }})">{{__('general.details')}}</a></li>
                                                    <li role="separator" class="divider"></li>
                                                    <li><a target="blank" href="{{ route('seller.invoice.download', $order->id) }}">{{__('general.download_invoice')}}</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $orders->links() }}

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="order_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="c-preloader">
                    <i class="fa fa-spin fa-spinner"></i>
                </div>
                <div id="order-details-modal-body">

                </div>
            </div>
        </div>
    </div>
    <div style="position: relative;bottom: -40px;">
        @include('frontend.seller.footer_tabs')
    </div>
@endsection
