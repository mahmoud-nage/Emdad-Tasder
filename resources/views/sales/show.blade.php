@extends('layouts.app')

@section('content')

    <div class="panel">
        <div class="panel-body">
            <div class="invoice-masthead">
                <div class="invoice-text">
                    <h3 class="h1 text-thin mar-no text-primary">{{ __('Order Details') }}</h3>
                </div>
            </div>
            <div class="row">
                @php
                    $delivery_status = $order->status_id;
                    $payment_status = $order->payment_status;
                    $status_name = $order->status->name_en;
                @endphp
                <div class="col-lg-offset-6 col-lg-3">
                    <label for="update_payment_status">{{__('general.payment_status')}}</label>
                    <select class="form-control select2" data-minimum-results-for-search="Infinity"
                            id="update_payment_status">
                        @if ($payment_status == 'paid')
                        <option value="paid" disabled @if ($payment_status == 'paid') selected @endif>{{__('forms.paid')}}</option>
                        @endif
                        @if ($payment_status == 'unpaid')
                        <option value="unpaid" disabled
                                @if ($payment_status == 'unpaid') selected @endif>{{__('forms.unpaid')}}</option>
                        @endif
                    </select>
                </div>
                <div class="col-lg-3">
                    <label for=update_delivery_status"">{{__('Delivery Status')}}</label>
                    <select class="form-control select2" data-minimum-results-for-search="Infinity"
                    id="update_delivery_status">
                    @if($order->payment_type == "cash_on_delivery")
                    @if($order->status_id != 5)
                    @if ($delivery_status == 1)
                    <option value="pending" @if ($delivery_status==1) selected disabled @endif >{{__('Pending')}}</option>
                    <option value="on_review" @if ($delivery_status==2) disabled selected @endif >{{__('On review')}}</option>
                    @elseif ($delivery_status == 2)
                    <option value="on_review" @if ($delivery_status==2) disabled selected @endif >{{__('On review')}}</option>
                    <option value="on_delivery" @if ($delivery_status==3) disabled selected @endif >{{__('On delivery')}}</option>
                    @elseif ($delivery_status == 3)
                    <option value="on_delivery" @if ($delivery_status==3) disabled selected @endif >{{__('On delivery')}}</option>
                    <option value="delivered" @if ($delivery_status==4) disabled selected @endif >{{__('Delivered')}}</option>
                    @endif
                    @endif
                    @php
                        $status_shipment = $order->awb && $order->statusShipment($order->id)?$order->statusShipment($order->id):'';
                    @endphp
                    @if(($order->status_id <= 3 || $order->status_id == 5))
                        <option value="Canceled" @if ($delivery_status==5) selected
                            style="background:darkred !important" @endif @if($order->payment_type != "cash_on_delivery")
                            disabled @endif >{{__('Canceled')}}</option>
                        @endif
                    @else
                        <option value="{{$status_name}}" selected disabled>{{__($status_name)}}</option>
                    @endif
                </select>
                </div>
            </div>
            <hr>
            <div class="invoice-bill row">
                 <div class="col-sm-6 text-xs-center customer">
                    <table class="invoice-details pull-left">
                        <tbody>
                        <tr>
                            <td class="text-main text-bold">
                                {{__('general.name')}}
                            </td>
                            <td class="text-right text-info text-bold">
                                {{ json_decode($order->shipping_address)->name }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">
                                {{__('forms.phone')}}
                            </td>
                             <td  class="text-info text-bold text-right">
                                {{ json_decode($order->shipping_address)->phone }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">
                                {{__('general.city')}}
                            </td>
                             <td  class="text-info text-bold text-right">
                                {{ App\City::find(json_decode($order->shipping_address)->city)['name_'.app()->getLocale()] }}

                            </td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">
                                {{__('general.area')}}
                            </td>
                             <td  class="text-info text-bold text-right">
                                {{ App\Area::find(json_decode($order->shipping_address)->area)['name_'.app()->getLocale()] }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">
                                {{__('general.zone')}}
                            </td>
                             <td  class="text-info text-bold text-right">
                                {{ json_decode($order->shipping_address)->zone }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">
                                {{__('general.building_no')}}
                            </td>
                             <td  class="text-info text-bold text-right">
                                {{ isset(json_decode($order->shipping_address)->building_no)?json_decode($order->shipping_address)->building_no:'' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">
                                {{__('general.floor_no')}}
                            </td>
                             <td  class="text-info text-bold text-right">
                                {{ isset(json_decode($order->shipping_address)->floor_no)?json_decode($order->shipping_address)->floor_no:'' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">
                                {{__('general.apartment_no')}}
                            </td>
                             <td  class="text-info text-bold text-right">
                                {{ isset(json_decode($order->shipping_address)->apartment_no)?json_decode($order->shipping_address)->apartment_no:'' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">
                                {{__('general.address')}}
                            </td>
                             <td  class="text-info text-bold text-right">
                                {{ isset(json_decode($order->shipping_address)->address_details)?json_decode($order->shipping_address)->address_details:'' }}
                            </td>
                        </tr>
                        {{-- <tr>
                            <td class="text-main text-bold">
                                {{__('general.s_mark')}}
                            </td>
                             <td  class="text-info text-bold text-right">
                                {{ isset(json_decode($order->shipping_address)->s_mark)?json_decode($order->shipping_address)->s_mark:'' }}
                            </td>
                        </tr> --}}
                     
                        </tbody>
                    </table>
                </div>
                
                <div class="col-sm-6 text-xs-center order">
                    <table class="invoice-details">
                        <tbody>
                        <tr>
                            <td class="text-main text-bold">
                                {{__('general.order_number')}}
                            </td>
                            <td class="text-right text-info text-bold">
                                {{ $order->code }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">
                                {{__('forms.status')}}
                            </td>
                            @php
                                $status = $order->orderDetails->first()->delivery_status;
                            @endphp
                            <td class="text-right text-info">
                                @if($delivery_status == 4)
                                    <span
                                        class="badge badge-success">{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                                @elseif($delivery_status == 5)
                                    <span
                                        class="badge badge-danger">{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                                @elseif($delivery_status == 3)
                                    <span
                                        class="badge badge-warning">{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                                @else
                                    <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">
                                {{__('general.order_date')}}
                            </td>
                            <td class="text-right text-info">
                                {{ date('d-m-Y h:i A', $order->date) }} (UTC)
                            </td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">
                                {{__('general.sub_total')}}
                            </td>
                            <td class="text-right text-info">
                                {{ $order->orderDetails->sum('price') + $order->orderDetails->sum('tax') }}{{  isset($order->country->Currency)?  $order->country->Currency['name_'.app()->getLocale()]:'' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">
                                {{__('general.payment_status')}}
                            </td>
                            <td class="text-right text-info">
                                {{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}
                            </td>
                        </tr>
                        @if($order->payment_type == 'accept_card')
                        <tr>
                            <td class="text-main text-bold">
                                {{__('general.payment_id')}}
                            </td>
                            <td class="text-right text-info">
                                {{ isset(json_decode($order->payment_details)->payment_id)?json_decode($order->payment_details)->payment_id:' ' }}
                            </td>
                        </tr>
                        @elseif($order->payment_type == 'accept_kiosk')
                        <tr>
                            <td class="text-main text-bold">
                                {{__('general.koisk_ref_num')}}
                            </td>
                            <td class="text-right text-info">
                                {{ isset(json_decode($order->payment_details)->refNum)?json_decode($order->payment_details)->refNum:' ' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">
                                {{__('general.payment_id')}}
                            </td>
                            <td class="text-right text-info">
                                {{ isset(json_decode($order->payment_details)->payment_id)?json_decode($order->payment_details)->payment_id:' ' }}
                            </td>
                        </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <hr class="new-section-sm bord-no">
            <div class="row">
                <div class="col-lg-12 table-responsive">
                    <table class="table table-bordered invoice-summary">
                        <thead>
                        <tr class="bg-trans-dark">
                            <th class="min-col text-center">#</th>
                            <th class="text-uppercase text-center">
                                {{__('general.product_description')}}
                            </th>
                            <th class="min-col text-center text-uppercase">
                                {{__('general.quantity')}}
                            </th>
                            <th class="min-col text-center text-uppercase">
                                {{__('forms.price')}}
                            </th>
                            <th class="min-col text-center text-uppercase">
                                {{__('general.total')}}
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($order->orderDetails as $key => $orderDetail)
                            @php
                                $orderDetaill=$orderDetail->with('product')->first();
                            @endphp
                            <tr>
                                <td class="text-center">{{ $key+1 }}</td>
                                <td>
                                    <strong>
                                        
                                        <a href="{{ route('product', ['country'=> auth()->user()->country, 'slug' => $orderDetail->product->slug]) }}" target="_blank">
                                            {{ $orderDetail->product['name_'.app()->getLocale()] }}
                                        </a>
                                    </strong>
                                    <small>{{ isset($orderDetail->Variation) ? '( '.$orderDetail->Variation->getChoice().' )' : '' }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    {{ $orderDetail->quantity }}
                                </td>
                                <td class="text-center">
                                    {{ $orderDetail->price/$orderDetail->quantity }}{{  isset($order->country->Currency)?  $order->country->Currency['name_'.app()->getLocale()]:'' }}
                                </td>
                                <td class="text-center">
                                    {{ $orderDetail->price }}{{  isset($order->country->Currency)?  $order->country->Currency['name_'.app()->getLocale()]:'' }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="clearfix">
                <table class="table invoice-total">
                    <tbody>
                    <tr>
                        <td>
                            <strong>{{__('general.sub_total')}}: </strong>
                        </td>
                        <td class="text-info">
                            {{ $order->orderDetails->sum('price') }}{{  isset($order->country->Currency)?  $order->country->Currency['name_'.app()->getLocale()]:'' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>{{__('general.tax')}} :</strong>
                        </td>
                        <td class="text-info">
                            {{ $order->orderDetails->sum('tax') }}{{  isset($order->country->Currency)?  $order->country->Currency['name_'.app()->getLocale()]:'' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>{{__('general.shipping')}} :</strong>
                        </td>
                        <td>
                            @php
                            $shiping = $order->orderDetails->first()->shipping_cost;
                            @endphp
                            {{ $shiping }}{{  isset($order->country->Currency)?  $order->country->Currency['name_'.app()->getLocale()]:'' }}
                        </td>
                    </tr>
                    @if ($order->coupon_url_id != null)
                        @php
                            $setting = \App\BusinessSetting::where('type' , 'coupon_affiliate_value')->first()->value;
                            $value = explode('_' , $setting)[0];
                        @endphp
                        <tr>
                            <td>
                                <strong>{{__('Affiliate Discount')}} :</strong>
                            </td>
                            <td class="text-info">
                                {{ $value }}{{  isset($order->country->Currency)?  $order->country->Currency['name_'.app()->getLocale()]:'' }}
                            </td>
                        </tr>
                    @elseif($order->coupon_discount != 0)
                        <tr>
                            <td>
                                <strong>{{__('general.coupon_discount')}} :</strong>
                            </td>
                            <td class="text-info">
                                {{ $order->coupon_discount}}{{  isset($order->country->Currency)?  $order->country->Currency['name_'.app()->getLocale()]:'' }}
                            </td>
                        </tr>
                    @endif
                       <tr>
                            <td>
                                <strong>{{__('general.commission')}} :</strong>
                            </td>
                            <td class="text-info">
                                {{ $order->orderDetails->sum('commission') }}{{  isset($order->country->Currency)?  $order->country->Currency['name_'.app()->getLocale()]:'' }}
                            </td>
                        </tr>
                      
                    <tr>
                        <td>
                            <strong>{{__('general.total')}} :</strong>
                        </td>
                        <td class="text-bold h4 text-info" @if($order->status_id == 5)
                                style="color: #ff0000;text-decoration: line-through;" @endif >
                            @if($order->status_id == 4)
                                0 ({{__('forms.paid')}})
                            @else
                                {{$order->grand_total-($order->orderDetails->sum('commission'))  }}{{  isset($order->country->Currency)?  $order->country->Currency['name_'.app()->getLocale()]:'' }} @if($order->status_id == 5)
                                ({{__('Canceled')}}) @endif </td>
                            @endif
                       
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-right no-print">
                <a target="blank" href="{{ route('seller.invoice.download', $order->id) }}" class="btn btn-default"><i
                        class="demo-pli-printer icon-lg"></i></a>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('#update_delivery_status').on('change', function () {
            var order_id = {{ $order->id }};
            var status = $('#update_delivery_status').val();
            console.log(status);
            $.post('{{ route('orders.update_delivery_status') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                status: status
            }, function (data) {
                console.log(data);
                if(data.status == 200){
                    showAlert('success', data.message);
                                          setTimeout(function() {
                    location.reload();
    }, 3000);
                }else{
                    
                    showAlert('danger', data.message);
                      setTimeout(function() {
                    location.reload();
    }, 3000);
                }
                
            });
        });

        $('#update_payment_status').on('change', function () {
            var order_id = {{ $order->id }};
            var status = $('#update_payment_status').val();
            $.post('{{ route('orders.update_payment_status') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                status: status
            }, function (data) {
                showAlert('success', 'Payment status has been updated');
            });
        });
    </script>
@endsection
