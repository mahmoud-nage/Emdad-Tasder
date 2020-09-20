
<title>{{'order-'.$order->code}}</title>
<div style="margin-left:auto;margin-right:auto;">
	<style media="print">
		      @media print
      {
         @page {
           margin-top: 0;
           margin-bottom: 0;
         }

      } 
		@import url('https://fonts.googleapis.com/css?family=Open+Sans:400,700');

		* {
			margin: 0;
			padding: 0;
			line-height: 1.5;
			font-family: 'Open Sans', sans-serif;
			color: #333542;
			-webkit-print-color-adjust: exact !important; /*Chrome, Safari */
        	color-adjust: exact !important;  /*Firefox*/
		}

		div {
			font-size: 1rem;
		}

		.gry-color *,
		.gry-color {
			color: #878f9c;
		}

		table {
			width: 100%;
		}

		table th {
			font-weight: normal;
		}

		table.padding th {
			padding: .5rem .7rem;
		}

		table.padding td {
			padding: .7rem;
		}

		table.sm-padding td {
			padding: .2rem .7rem;
		}

		.border-bottom td,
		.border-bottom th {
			border-bottom: 1px solid #eceff4;
		}

		.text-left {
			text-align: left;
		}

		.text-right {
			text-align: right;
		}

		.small {
			font-size: .85rem;
		}

		.strong {
			font-weight: bold;
		}

	</style>

	@php
	$generalsetting = \App\GeneralSetting::first();
	@endphp

	<div style="background: #eceff4;padding: 1.5rem;" id="printarea">
		<table>
			<tr>
				<td>
					@if($generalsetting->logo != null)
					<img src="{{ asset($generalsetting->logo) }}" height="40" style="display:inline-block;">
					@else
					<img src="{{ asset('frontend/images/logo/logo.png') }}" height="40" style="display:inline-block;">
					@endif
				</td>
			<td style="font-size: 2.5rem;" class="text-right strong">{{__('general.invoice')}}</td>
			</tr>
		</table>
		<table>
			@if (Auth::user()->user_type == 'seller')
			<tr>
				<td style="font-size: 1.2rem;" class="strong">{{ Auth::user()->shop->name }}</td>
				<td class="text-right"></td>
			</tr>
			<tr>
				<td class="gry-color small">{{ Auth::user()->shop->address }}</td>
				<td class="text-right"></td>
			</tr>
			<tr>
				<td class="gry-color small">Email: {{ Auth::user()->email }}</td>
				<td class="text-right small"><span class="gry-color small">Order ID:</span> <span
						class="strong">{{ $order->code }}</span></td>
			</tr>
			<tr>
				<td class="gry-color small">Phone: {{ Auth::user()->phone }}</td>
				<td class="text-right small"><span class="gry-color small">Order Date:</span> <span
						class=" strong">{{ date('d-m-Y', $order->date) }}</span></td>
			</tr>
			@else
			<tr>
				<td style="font-size: 1.2rem;" class="strong">{{ $generalsetting->site_name }}</td>
				<td class="text-right"></td>
			</tr>
			<tr>
				<td class="gry-color small">{{ $generalsetting->address }}</td>
				<td class="text-right"></td>
			</tr>
			<tr>
				<td class="gry-color small">Email: {{ $generalsetting->email }}</td>
				<td class="text-right small"><span class="gry-color small">Order ID:</span> <span
						class="strong">{{ $order->code }}</span></td>
			</tr>
			<tr>
				<td class="gry-color small">Phone: {{ $generalsetting->phone }}</td>
				<td class="text-right small"><span class="gry-color small">Order Date:</span> <span
						class=" strong">{{ date('d-m-Y', $order->date) }}</span></td>
			</tr>
			
			@endif
			@if($order->payment_type == 'accept_card')
			<tr>
				<td class="gry-color small">
					{{__('general.payment_id')}}
				</td>
				<td class="text-right small">
					{{ isset(json_decode($order->payment_details)->payment_id)?json_decode($order->payment_details)->payment_id:' ' }}
				</td>
			</tr>
			@elseif($order->payment_type == 'accept_kiosk')
			<tr>
				<td class="gry-color small">
					{{__('general.koisk_ref_num')}}
				</td>
				<td class="text-right small">
					{{ isset(json_decode($order->payment_details)->refNum)?json_decode($order->payment_details)->refNum:' ' }}
				</td>
			</tr>
			<tr>
				<td class="gry-color small">
					{{__('general.payment_id')}}
				</td>
				<td class="text-right small">
					{{ isset(json_decode($order->payment_details)->payment_id)?json_decode($order->payment_details)->payment_id:' ' }}
				</td>
			</tr>
			@endif
		</table>

	</div>

	<div style="border-bottom:1px solid #eceff4;margin: 0 1.5rem;"></div>

	{{-- <div style="padding: 1.5rem;">
		<table>
			@php
			$shipping_address = json_decode($order->shipping_address);
			@endphp
			<tr>
				<td class="strong small gry-color">Bill to:</td>
			</tr>
			<tr>
				<td class="strong">{{ $shipping_address->name }}</td>
			</tr>

			<tr>
				<td class="gry-color small">{{ json_decode($order->shipping_address)->address_details }}</td>
			</tr>
			{{-- <tr><td class="gry-color small">{{ $shipping_address->address }}, {{ $shipping_address->city }},
			{{ $shipping_address->country }}</td>
			</tr> 
			<tr>
				<td class="gry-color small">Email: {{ $shipping_address->email }}</td>
			</tr>
			<tr>
				<td class="gry-color small">Phone: {{ $shipping_address->phone }}</td>
			</tr>
		</table>
	</div> --}}


	<div class="col-sm-6 text-xs-center" style="padding: 1.5rem;">
		<table class="invoice-details pull-left" style="@if(app()->getLocale() == 'ar') direction:rtl;@endif">
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
					{{__('forms.email')}}
				</td>
				<td class="text-right text-info text-bold">
					{{ json_decode($order->shipping_address)->email }}
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
			<!--<tr>-->
			<!--	<td class="text-main text-bold">-->
			<!--		{{__('general.area')}}-->
			<!--	</td>-->
			<!--	 <td  class="text-info text-bold text-right">-->
			<!--		{{ App\Area::find(json_decode($order->shipping_address)->area)['name_'.app()->getLocale()] }}-->
			<!--	</td>-->
			<!--</tr>-->
			<!--<tr>-->
			<!--	<td class="text-main text-bold">-->
			<!--		{{__('general.zone')}}-->
			<!--	</td>-->
			<!--	 <td  class="text-info text-bold text-right">-->
			<!--		{{ json_decode($order->shipping_address)->zone }}-->
			<!--	</td>-->
			<!--</tr>-->
			<tr>
				<td class="text-main text-bold">
					{{__('general.building_no')}}
				</td>
				 <td  class="text-info text-bold text-right">
					{{ json_decode($order->shipping_address)->building_no }}
				</td>
			</tr>
			<tr>
				<td class="text-main text-bold">
					{{__('general.floor_no')}}
				</td>
				 <td  class="text-info text-bold text-right">
					{{ json_decode($order->shipping_address)->floor_no }}
				</td>
			</tr>
			<tr>
				<td class="text-main text-bold">
					{{__('general.apartment_no')}}
				</td>
				 <td  class="text-info text-bold text-right">
					{{ json_decode($order->shipping_address)->apartment_no }}
				</td>
			</tr>
			<tr>
				<td class="text-main text-bold">
					{{__('general.address')}}
				</td>
				 <td  class="text-info text-bold text-right">
					{{ json_decode($order->shipping_address)->address_details }}
				</td>
			</tr>
			{{-- <tr>
				<td class="text-main text-bold">
					{{__('general.s_mark')}}
				</td>
				 <td  class="text-info text-bold text-right">
					{{ json_decode($order->shipping_address)->address_details }}
				</td>
			</tr> --}}
		 
			</tbody>
		</table>
	</div>

	<div style="padding: 1.5rem;">
		<table class="padding text-center small border-bottom" style="@if(app()->getLocale() == 'ar') direction:rtl;@endif">
			<thead>
				<tr class="gry-color" style="background: #eceff4;">
					<th width="50%">{{__('general.product_description')}}</th>
					<th width="10%">{{__('general.quantity')}}</th>
					<th width="15%">{{__('forms.price')}}</th>
					<th width="15%" class="text-right"> {{__('general.total')}}</th>
				</tr>
			</thead>
			<tbody class="strong">
				@foreach ($order->orderDetails->where('order_id', $order->id) as $key => $orderDetail)
				<tr class="">
					<td>   <strong>
							{{ $orderDetail->product['name_'.app()->getLocale()] }}
					</strong><br>
					<small>{{ isset($orderDetail->Variation) ? '( '.$orderDetail->Variation->getChoice().' )' : '' }}
					</small>
				 </td>
					<td class="gry-color">{{ $orderDetail->quantity }}</td>
					<td class="gry-color">{{ $orderDetail->price/$orderDetail->quantity }} {{  isset($order->country->Currency)?  $order->country->Currency['name_'.app()->getLocale()]:'' }}</td>
					<td class="text-right">{{ $orderDetail->price }} {{  isset($order->country->Currency)?  $order->country->Currency['name_'.app()->getLocale()]:'' }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	<div style="padding:0 1.5rem;">
		<table style="width: 40%;margin-left:auto;@if(app()->getLocale() == 'ar') direction:rtl;@endif" class="total sm-padding small strong">
			<tbody>
				<tr>
					<th class="gry-color  @if(app()->getLocale() == 'ar') text-right @else text-left @endif">{{__('general.sub_total')}}: </td>
					<td class="@if(app()->getLocale() == 'ar') text-left @else text-right @endif">{{ $order->orderDetails->sum('price') }} {{  isset($order->country->Currency)?  $order->country->Currency['name_'.app()->getLocale()]:'' }}
					</td>
				</tr>
				<tr>
					<th class="gry-color @if(app()->getLocale() == 'ar') text-right @else text-left @endif">{{__('general.shipping')}}: </td>
					<td class="@if(app()->getLocale() == 'ar') text-left @else text-right @endif">{{ (json_decode($order->shipping_address)->delivery_price) }} {{  isset($order->country->Currency)?  $order->country->Currency['name_'.app()->getLocale()]:'' }}</td>
				</tr>
				<tr class="border-bottom">
					<th class="gry-color @if(app()->getLocale() == 'ar') text-right @else text-left @endif">{{__('general.tax')}}: </td>
					<td class="@if(app()->getLocale() == 'ar') text-left @else text-right @endif">{{ $order->orderDetails->where('seller_id', Auth::user()->id)->sum('tax') }} {{  isset($order->country->Currency)?  $order->country->Currency['name_'.app()->getLocale()]:'' }}</td>
				</tr>
				@if($order->coupon_discount)
					<tr class="border-bottom">
					<th class="gry-color @if(app()->getLocale() == 'ar') text-right @else text-left @endif">{{__('general.coupon_discount')}}: </td>
					<td class="@if(app()->getLocale() == 'ar') text-left @else text-right @endif">{{ $order->coupon_discount }} {{  isset($order->country->Currency)?  $order->country->Currency['name_'.app()->getLocale()]:'' }}</td>
				</tr>
				@endif
				@if($order->orderDetails->first()->seller->user_type == 'seller')
				@php
				$comm = $order->orderDetails->sum('commission');
				@endphp
				<tr class="border-bottom">
					<th class="gry-color @if(app()->getLocale() == 'ar') text-right @else text-left @endif">{{__('general.commission')}}: </td>
					<td class="@if(app()->getLocale() == 'ar') text-left @else text-right @endif">{{ $comm }}{{  isset($order->country->Currency)?  $order->country->Currency['name_'.app()->getLocale()]:'' }}
					</td>
				</tr>
				@else
				@php
				$comm = 0;
				@endphp
				@endif
				
				<tr>
					<th class="@if(app()->getLocale() == 'ar') text-right @else text-left @endif strong">{{__('general.total')}}: </td>
					<td class="@if(app()->getLocale() == 'ar') text-left @else text-right @endif">{{ $order->grand_total - $comm  }} {{  isset($order->country->Currency)?  $order->country->Currency['name_'.app()->getLocale()]:'' }}
					</td>
				</tr>
			</tbody>
		</table>
	</div>

</div>

<script>
window.print();
window.onafterprint = function(){ window.close()};

</script>