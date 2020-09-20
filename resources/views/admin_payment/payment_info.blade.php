@extends('layouts.app')

@section('content')

    <!-- Basic Data Tables -->
    <!--===================================================-->
    {{--    payment request information--}}
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Payment Request')}}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered " cellspacing="0" width="100%">
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
                    <th>status</th>
                </tr>
                </thead>
                <tbody>
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
                        <div class="btn-group dropdown">
                            <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon"
                                    data-toggle="dropdown" type="button">{{$paymentRequest['status']}}
                            </button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            @if($paymentRequest['status']=="pending")
                <div class="container">
                    <h2>Confirm payment</h2>
                    <p>Please review this payment carefully first before confirming it.</p>
                    <form class="form-inline" action="{{ route('admin.payment_requests.confirmPayment') }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        <input value="{{$paymentRequest['id']}}" name="paymentId" type="hidden" required="required">
                        <input value="{{$paymentRequest->affiliate->id}}" name="affiliateId" type="hidden"
                               required="required">
                        <div class="form-group">
                            <label for="pwd">File:</label>
                            <input type="file" class="form-control" id="file" name="file"
                                   accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps">
                        </div>
                        <button type="submit" class="btn btn-primary">Confirm payment</button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    {{--    payment request affiliate user information--}}
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Affiliate')}}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered " cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>country</th>
                    <th>phone</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{$paymentRequest->affiliate->user->name}}</td>
                    <td>{{$paymentRequest->affiliate->user->country}}</td>
                    <td>{{$paymentRequest->affiliate->user->phone}}</td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>

    {{--    Orders in this payment request --}}
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Orders')}}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered" cellspacing="0" width="100%">
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
                    <th width="10%">{{__('Options')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orders as $order)
                    @if($order != null)
                        <tr>
                            <td>
                                {{ $order->id }}
                            </td>
                            <td>
                                {{ $order->code }} @if($order->viewed == 0) <span
                                    class="pull-right badge badge-info">{{ __('New') }}</span> @endif
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
                                {{ single_price($order->orderDetails->sum('price') + $order->orderDetails->sum('tax')) }}
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
                                <div class="btn-group dropdown">
                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon"
                                            data-toggle="dropdown" type="button">
                                        {{__('Actions')}} <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="{{ route('orders.show', encrypt($order->id)) }}">{{__('View')}}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('seller.invoice.download', $order->id) }}">{{__('Download Invoice')}}</a>
                                        </li>
                                        <li>
                                            <a onclick="confirm_modal('{{route('orders.destroy', $order->id)}}');">{{__('Delete')}}</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
            {{ $orders->links() }}
        </div>
    </div>

    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo e(__('Confirmation')); ?></h4>
                </div>

                <div class="modal-body">
                    <p>Are you sure you want to confirm this payment</p>
                </div>

                <form></form>
                <input type="file" id="paymentFile" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps">
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
                    <a id="delete_link" onclick="confirmPayment(this)"
                       class="btn btn-primary btn-ok"><?php echo e(__('Confirm payment request')); ?></a>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')

    <script type="text/javascript">
        function confirmPaymentModal(confirmPaymentUrl, paymentId, affiliateId) {
            console.log(confirmPaymentUrl);
            console.log(paymentId);
            console.log(affiliateId);
            jQuery('#confirm-delete').modal('show', {backdrop: 'static'});
            $('#delete_link').attr("data-paymentId", paymentId);
            $('#delete_link').attr("data-affiliateId", affiliateId);
            // document.getElementById('delete_link').setAttribute('href', confirmPaymentUrl);
        }

        function confirmPayment(el) {
            console.log(el.getAttribute("data-paymentId"));
            console.log(el.getAttribute("data-affiliateId"));
            $.ajax({
                _token: this.csrf,
                url: "{!! route('api.admin.payment_requests.confirmPayment') !!}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    locale: '{{ \App::getLocale() }}',
                    paymentId: el.getAttribute("data-paymentId"),
                    affiliateId: el.getAttribute("data-affiliateId"),
                    file: ''
                },
            }).then((response) => {
                console.log(response);
            });

        }
    </script>
@endsection
