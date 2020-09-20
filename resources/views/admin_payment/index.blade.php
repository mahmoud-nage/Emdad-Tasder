@extends('layouts.app')

@section('content')

    <!-- Basic Data Tables -->
    <!--===================================================-->
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Payment Requests')}}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
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
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $paymentRequest)
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
                                        data-toggle="dropdown" type="button">{{$paymentRequest['status']}} <i
                                        class="dropdown-caret"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a onclick="confirmPaymentModal('{{route("admin.payment_requests.confirmPayment")}}','{{$paymentRequest['id']}}','{{$paymentRequest['affiliate_id']}}');">{{__('Confirm')}}</a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td>
                                <a class="btn btn-primary" href="{{route("payment_requests.show",['id'=>$paymentRequest['id']])}}">{{__('Review')}}</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
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

                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
                    <a id="delete_link" onclick="confirmPayment(this)"
                       class="btn btn-primary btn-ok"><?php echo e(__('Confirm payment request')); ?></a>
                </div>
            </div>
        </div>
    </div>

@stop

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
                },
            }).then((response) => {
                console.log(response);
            });

        }
    </script>
@endsection
