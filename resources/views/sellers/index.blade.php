@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <a href="{{ route('sellers.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add New Seller')}}</a>
    </div>
</div>

<br>

<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('sellers')}}</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Email Address')}}</th>
                    <th>{{__('Status')}}</th>
                    <th>{{__('Verify')}}</th>
                    <th>{{ __('Num. of Products') }}</th>
                    <th>{{ __('Due to seller') }}</th>
                    <th width="10%">{{__('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sellers as $key => $seller)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td><a href="{{route('sellers.show', $seller->id)}}">{{isset($seller->shop->name)?$seller->shop->name:$seller->user->name}}</a></td>
                        <td>{{$seller->user->email}}</td>
                        <td>
                            @if ($seller->verification_status == 1)
                                <div class="label label-table label-success">
                                    {{__('Verified')}}
                                </div>
                            @elseif ($seller->verification_info != null)
                                <a href="{{ route('sellers.show_verification_request', $seller->id) }}">
                                    <div class="label label-table label-info">
                                        {{__('Requested')}}
                                    </div>
                                </a>
                            @else
                                <div class="label label-table label-danger">
                                    {{__('Not Verified')}}
                                </div>
                            @endif
                        </td>
                                                    <td><label class="switch">
                                    <input onchange="update_verify(this)" value="{{ $seller->id }}"
                                           type="checkbox" <?php if ($seller->verification_status == 1) echo "checked";?> >
                                    <span class="slider round"></span></label></td>
                        <td>{{ \App\Product::where('user_id', $seller->user->id)->count() }}</td>
                        <td>
                            @if ($seller->admin_to_pay >= 0)
                                {{ single_price($seller->admin_to_pay) }}
                            @else
                                {{ single_price(abs($seller->admin_to_pay)) }} (Due to Admin)
                            @endif
                        </td>
                        <td>
                            <div class="btn-group dropdown">
                                <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                    {{__('Actions')}} <i class="dropdown-caret"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a onclick="show_seller_payment_modal('{{$seller->id}}');">{{__('Pay Now')}}</a></li>
                                    <li><a href="{{route('sellers.payment_history', encrypt($seller->id))}}">{{__('Payment History')}}</a></li>
                                    <li><a href="{{route('sellers.edit', encrypt($seller->id))}}">{{__('Edit')}}</a></li>
                                    <!--<li><a onclick="confirm_modal('{{route('sellers.destroy', $seller->id)}}');">{{__('Delete')}}</a></li>-->
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>


<div class="modal fade" id="payment_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="modal-content">

        </div>
    </div>
</div>


@endsection

@section('script')
    <script type="text/javascript">
        function show_seller_payment_modal(id){
            $.post('{{ route('sellers.payment_modal') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
                $('#modal-content').html(data);
                $('#payment_modal').modal('show', {backdrop: 'static'});
                $('.demo-select2-placeholder').select2();
            });
        }
           function update_verify(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            console.log(el.value);
            $.post('{{ route('sellers.approved')}}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function (data) {
                if (data == 1) {
                    showAlert('success', 'Featured products updated successfully');
                    location.reload();
                } else {
                    showAlert('danger', 'Something went wrong');
                }
            });
        }
    </script>
@endsection
