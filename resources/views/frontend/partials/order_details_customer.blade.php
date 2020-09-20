<div class="modal-header">
    <h5 class="modal-title strong-600 heading-5">{{__('general.order_number')}}: {{ $order->code }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

@php
    $status = $order->status->name_en;
    $status_name = \App\Status::all();
@endphp

<div class="modal-body gry-bg px-3 pt-0">
    <div class="container-fluid">
        <div>
            <div class="stepper">
                <ul class="step-wrapper">
                    @if($status != 'Canceled')
                    <li @if($status == 'pending' || $status == 'on_review' || $status == 'on_delivery' || $status == 'delivered') class="active" @endif>
                        <span data-text="{{$status_name[0]['name_'.app()->getLocale()]}}">1</span>
                    </li>
                    <li @if($status == 'on_review' || $status == 'on_delivery' || $status == 'delivered') class="active"  @endif>
                        <span data-text="{{$status_name[1]['name_'.app()->getLocale()]}}">2</span>
                    </li>
                    <li @if($status == 'on_delivery' || $status == 'delivered') class="active" @endif>
                        <span data-text="{{$status_name[2]['name_'.app()->getLocale()]}}">3</span>
                    </li>
                    <li @if($status == 'delivered') class="active" @endif>
                        <span data-text="{{$status_name[3]['name_'.app()->getLocale()]}}">4</span>
                    </li>
                    @else
                    <li @if($status == 'Canceled') class="active" @endif>
                        <span data-text="{{$status_name[4]['name_'.app()->getLocale()]}}">1</span>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="section-wrapper">
            <div class="section-header">
               {{__('general.order_summery')}}
            </div>
            <div class="order-wrapper">
                <div>
                    <div class="row">
                    <div class="col-xs-12 col-lg-6">
                        <div class="order-row">
                            <span class="order-title">{{__('general.order_number')}}:</span>
                            <span class="order-number">{{ $order->code }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-6">
                        <div class="order-row">
                            <span class="order-title">{{__('general.customer')}}:</span>
                            <span class="order-number">
                                    @if ($order->user_id != null)
                                    {{ $order->user->name }}
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-6">
                        <div class="order-row">
                            <span class="order-title">{{__('forms.email')}}:</span>
                            <span class="order-number">
                                @if ($order->user_id != null)
                                    {{ $order->user->email }}
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-6">
                        <div class="order-row">
                            <span class="order-title">{{__('general.delivery_address')}}:</span>
                            <span class="order-number">{{ json_decode($order->shipping_address)->address_details }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-6">
                        <div class="order-row">
                            <span class="order-title">{{__('general.order_date')}}:</span>
                            <span class="order-number">{{ date('d-m-Y H:m A', $order->date) }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-6">
                        <div class="order-row">
                            <span class="order-title">{{__('forms.status')}}:</span>
                            <span class="order-number">{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-6">
                        @if($order->orderDetails->count()>0)
                        <div class="order-row">
                            <span class="order-title">{{__('general.sub_total')}}:</span>
                            <span class="order-number">{{ $order->orderDetails->sum('price') + $order->orderDetails->sum('tax') }}{{  isset($order->country->Currency['name_'.app()->getLocale()])?  $order->country->Currency['name_'.app()->getLocale()]:'' }}</span>
                        </div>
                        @endif
                    </div>
                    <div class="col-xs-12 col-lg-6">
                        <div class="order-row">
                            <span class="order-title">{{__('general.payment_method')}}:</span>
                            <span class="order-number">{{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-6">
                        @if($order->payment_type == 'accept_card')
                        <div class="order-row">
                            <span class="order-title">{{__('general.payment_id')}}:</span>
                            <span class="order-number">{{ isset(json_decode($order->payment_details)->payment_id)?json_decode($order->payment_details)->payment_id:' ' }}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-6">
                        @elseif($order->payment_type == 'accept_kiosk')
                        <div class="order-row">
                            <span class="order-title">{{__('general.koisk_ref_num')}}:</span>
                            <span class="order-number">{{ isset(json_decode($order->payment_details)->refNum)?json_decode($order->payment_details)->refNum:' ' }}</span>
                        </div>
                    </div>
                
                    <div class="col-xs-12 col-lg-6">
                        
                        <div class="order-row">
                            <span class="order-title">{{__('general.payment_id')}}:</span>
                            <span class="order-number">{{ isset(json_decode($order->payment_details)->payment_id)?json_decode($order->payment_details)->payment_id:' ' }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                </div>
                
            </div>
        </div>
        
        <div class="section-wrapper">
            <div class="section-header">
               {{__('forms.order_location')}}
            </div>

            <div class="order-wrapper">
                <div class="row">
                                            <div class="col-xs-12 col-lg-12">
                        <div class="order-row">
                            <span class="order-title">{{__('general.delivery_address')}}:</span>
                            <span class="order-number">{{ isset(json_decode($order->shipping_address)->address_details)?json_decode($order->shipping_address)->address_details:'' }}</span>
                        </div>
                        </div>
                        
                    <div class="col-xs-12 col-lg-6">
         
                        <div class="order-row">
                            <span class="order-title">{{__('general.city')}}:</span>
                            <span class="order-number">{{ isset(json_decode($order->shipping_address)->city)?App\City::find(json_decode($order->shipping_address)->city)['name_'.app()->getLocale()]:'' }}</span>
                        </div>
                        
                        
                        <div class="order-row">
                            <span class="order-title">{{__('general.area')}}:</span>
                            <span class="order-number">
                                  {{ isset(json_decode($order->shipping_address)->area)?App\Area::find(json_decode($order->shipping_address)->area)['name_'.app()->getLocale()]:'' }}
                            </span>
                        </div>
                       
                        
                        <!--<div class="order-row">-->
                        <!--    <span class="order-title">{{__('general.zone')}}:</span>-->
                        <!--    <span class="order-number">-->
                        <!--       {{ isset(json_decode($order->shipping_address)->zone)?json_decode($order->shipping_address)->zone:'' }}-->
                        <!--    </span>-->
                        <!--</div>-->
                      

                    </div>
                    
                    
                    <div class="col-xs-12 col-lg-6">
                        <div class="order-row">
                            <span class="order-title">{{__('general.building_no')}}:</span>
                            <span class="order-number">{{ isset(json_decode($order->shipping_address)->building_no)?json_decode($order->shipping_address)->building_no:'' }}</span>
                        </div>
                     
                        
                        <div class="order-row">
                            <span class="order-title">{{__('general.floor_no')}}:</span>
                            <span class="order-number">{{ isset(json_decode($order->shipping_address)->floor_no)?json_decode($order->shipping_address)->floor_no:'' }}</span>
                        </div>
                       
                        <div class="order-row">
                            <span class="order-title">{{__('general.apartment_no')}}:</span>
                            <span class="order-number">{{ isset(json_decode($order->shipping_address)->apartment_no)?json_decode($order->shipping_address)->apartment_no:'' }}</span>
                        </div>

                    </div>
                                            

                </div>
            </div>
        </div>
        
        <div class="col-xs-12 col-lg-8">
            <div class="table-wrapper">
                <div class="table-block">
                    <table class="table table-responsive table-hover ">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th width="40%">{{__('general.product')}}</th>
                            <th>{{__('forms.options')}}</th>
                            <th>{{__('general.quantity')}}</th>
                            <th>{{__('forms.price')}}</th>
                            <th>{{__('general.total')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if($order->orderDetails->count()>0)
                        @foreach ($order->orderDetails as $key => $orderDetail)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td><a href="{{ route('product', ['country' => get_country()->code, 'slug' => $orderDetail->product->slug]) }}" target="_blank">{{ $orderDetail->product['name_'.app()->getLocale()] }}</a></td>
                                <td>
                                    {{ isset($orderDetail->Variation) ? $orderDetail->Variation->getChoice() : '' }}
                                </td>
                                <td>
                                    {{ $orderDetail->quantity }}
                                </td>
                                <td>{{ $orderDetail->price / $orderDetail->quantity }} {{  isset($order->country->Currency['name_'.app()->getLocale()])?  $order->country->Currency['name_'.app()->getLocale()]:'' }}</td>
                                <td>{{ $orderDetail->price }} {{  isset($order->country->Currency['name_'.app()->getLocale()])?  $order->country->Currency['name_'.app()->getLocale()]:'' }}</td>
                            </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-lg-4">
            <div class="section-wrapper @if(isset(auth()->user()->seller)) customer_section @endif">
                <div class="section-header">
                    {{__('general.order_summery')}}
                </div>
                    @if($order->orderDetails->count()>0)
                <div class="order-wrapper">
                    <div class="order-row">
                        <span class="order-title">{{__('general.sub_total')}}:</span>
                        <span class="order-number">{{ $order->orderDetails->sum('price')}} {{  isset($order->country->Currency['name_'.app()->getLocale()])?  $order->country->Currency['name_'.app()->getLocale()]:'' }}</span>
                    </div>
                    <div class="order-row">
                        <span class="order-title">{{__('general.shipping')}}</span>
                        <span class="order-number">{{ $order->orderDetails->first()->shipping_cost }} {{  isset($order->country->Currency['name_'.app()->getLocale()])?  $order->country->Currency['name_'.app()->getLocale()]:'' }}</span>
                    </div>
                    <div class="order-row">
                        <span class="order-title">{{__('general.tax')}}</span>
                        <span class="order-number">{{ $order->orderDetails->sum('tax') }}{{  isset($order->country->Currency['name_'.app()->getLocale()])?  $order->country->Currency['name_'.app()->getLocale()]:'' }}</span>
                    </div>
                    	@if($order->coupon_discount)
                    	<div class="order-row">
                        <span class="order-title">{{__('general.coupon_discount')}}</span>
                        <span class="order-number">{{ $order->coupon_discount }}{{  isset($order->country->Currency['name_'.app()->getLocale()])?  $order->country->Currency['name_'.app()->getLocale()]:'' }}</span>
                        </div>
				
				        @endif
                    <div class="order-row">
                        <span class="order-title">{{__('general.total')}}</span>
                        <span class="order-number">{{$order->grand_total }}{{  isset($order->country->Currency['name_'.app()->getLocale()])?  $order->country->Currency['name_'.app()->getLocale()]:'' }}</span>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
