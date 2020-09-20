@extends('layouts.app')
@section('content')

<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        @if(isset($payments)&&count($payments)>0)
        <h3 class="panel-title">{{ \App\Seller::find($payments->first()->seller_id)->user->name }} ({{ \App\Seller::find($payments->first()->seller_id)->user->shop->name }})</h3>
        @endif
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('Date')}}</th>
                    <th>{{__('Amount')}}</th>
                    <th>{{ __('Payment Method') }}</th>
                </tr>
            </thead>
            <tbody>
            @if(isset($payments)&&count($payments)>0)
                @foreach($payments as $key => $payment)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $payment->created_at }}</td>
                        <td>
                            {{ single_price($payment->amount) }}
                        </td>
                        <td>{{ ucfirst($payment->payment_method) }}</td>
                    </tr>
                @endforeach
                @endif
            </tbody>
        </table>

    </div>
</div>

@endsection
