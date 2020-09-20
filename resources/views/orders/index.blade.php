@extends('layouts.app')

@section('content')
@php
    if($type == 'Seller Orders'){
        $route = 'sales.index';
    }else{
        $route = 'orders.index.admin';
    }
@endphp 

<div class="pad-all text-center col-md-offset-2 col-md-8">
    <form class="" action="{{ route($route) }}" method="GET" style="margin-bottom:30px">
        <div class="form-group">
            <label class="col-sm-3 control-label" for="name">{{__('Sort by Category:')}}</label>
                <div class="col-sm-7">
                    <select name="country_id" required class="form-control select2">
                        @foreach($countries as $country)
                            <option value="{{$country->id}}" <?php if($cou == $country->id) echo "selected";?> >{{__($country['name_'.app()->getLocale()])}}</option>
                        @endforeach
                    </select>
                </div>
        </div>
        <div class="col-sm-2">

        <button class="btn btn-default" type="submit">Filter</button>
        </div>
    </form>
</div>
<!-- Basic Data Tables -->
<!--===================================================-->
    <div class="col-lg-12">

<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__($type)}}</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('Order Code')}}</th>
                    <th>{{__('Num. of Products')}}</th>
                    <th>{{__('Customer')}}</th>
                    <th>{{__('Amount')}}</th>
                    <th>{{__('Delivery Status')}}</th>
                    <th>{{__('Payment Method')}}</th>
                    <th>{{__('Payment Status')}}</th>
                    <th>{{__('Shipment Status')}}</th>
                    <!--<th>{{__('Shipment Company')}}</th>-->
                    <th width="10%">{{__('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @if($orders != null)
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
                                {{ $order->code }} @if($order->viewed == 0) <span class="pull-right badge badge-info">{{ __('New') }}</span> @endif
                            </td>
                            <td>
                                {{ count($order->orderDetails) }}
                            </td>
                            <td>
                                @if ($order->user_id != null)
                                    {{ $order->user->name }}
                                @else
                                    Guest ({{ $order->guest_id }})
                                @endif
                            </td>
                            <td>
                                {{$order->orderDetails->sum('price') + $order->orderDetails->sum('tax')}} {{  isset($order->country->Currency)?  $order->country->Currency['name_'.app()->getLocale()]:'' }}
                            </td>
                            <td>
                                @php
                                    $status = $order->orderDetails->first()->delivery_status;
                                @endphp
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </td>
                            <td>
                                {{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}
                            </td>
                            <td>
                                <span class="badge badge--2 mr-4">
                                    @if ($order->orderDetails->first()->payment_status == 'paid')
                                        <i class="bg-green"></i> Paid
                                    @else
                                        <i class="bg-red"></i> Unpaid
                                    @endif
                                </span>
                            </td>
                                <td>
                                    @if($order->shipment_type == 1)
                                    Smsa ({{$order->awb && $order->statusShipment($order->id)?$order->statusShipment($order->id):''}})
                                    @elseif($order->shipment_type == 2)
                                    Aramex ({{$order->awb && $order->statusShipment($order->id)?$order->statusShipment($order->id):''}})
                                    @elseif($order->shipment_type == 0)
                                    Self ({{$order->status->name_en}})
                                    @endif
                                </td>
                                <!--<td>-->
                                <!--    @if($order->shipment_type == 1)-->
                                    
                                <!--    @elseif($order->shipment_type == 2)-->
                                <!--    Aramex-->
                                <!--    @elseif($order->shipment_type == 0)-->
                                <!--    Self-->
                                <!--    @endif-->
                                <!--</td>-->
                            <td>
                                <div class="btn-group dropdown">
                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                        {{__('Actions')}} <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a  href="@if(isset($type) && $type == 'Seller Orders') {{ route('sales.show', encrypt($order->id)) }} @else {{ route('orders.show', encrypt($order->id)) }} @endif">{{__('View')}}</a></li>
                                        <li><a target="blank" href="{{ route('seller.invoice.download', $order->id) }}">{{__('Download Invoice')}}</a></li>
                                        @if(($order->awb && $order->ref_number) && \App\BusinessSetting::where('type', 'shipment_smsa')->first()->value == 1 && $order->shipment_type == 1)
                                        <li><a target="blank" href="{{ route('shipment.invoice.download',$order->id) }}">{{__('Download Shipment Invoice')}}</a></li>
                                         @elseif(\App\BusinessSetting::where('type', 'shipment_aramex')->first()->value == 1 && $order->shipment_type == 2 && $order->aramex_invoice_url)
                                            <li><a target="blank" href="{{ $order->aramex_invoice_url }}">{{__('Download Shipment Invoice')}}</a></li>
                                        @endif
                                        <!--<li><a onclick="confirm_modal('{{route('orders.destroy', $order->id)}}');">{{__('Delete')}}</a></li>-->
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
                @endif
            </tbody>
        </table>

    </div>
</div>
</div>

@endsection


@section('script')
@endsection
