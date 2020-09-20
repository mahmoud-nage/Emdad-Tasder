<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Seller Payments')}}</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('Date')}}</th>
                    <th>{{__('Seller')}}</th>
                    <th>{{__('Amount')}}</th>
                    <th>{{ __('Payment Method') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Confirm') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $key => $payment)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $payment->created_at }}</td>
                        <td>
                            @if (\App\User::find($payment->seller_id) != null)
                                {{ \App\User::find($payment->seller_id)->name }} ( {{ \App\User::find($payment->seller_id)->shop->name }} )
                            @endif
                        </td>
                        <td>
                            {{ single_price($payment->amount) }}
                        </td>
                        <td>
                                    @if($payment->payment_method == 1)
                                    <span class="label label-info">{{__('general.bank')}}</span>
                                    @endif
                                    @if($payment->payment_method == 2)
                                    <span class="label">{{__('general.postal')}}</span>
                                    @endif
                                    @if($payment->payment_method == 3)
                                    <span class="label">{{__('general.vodafone_cache')}}</span>
                                    @endif
                           </td>
                            @if($payment->status == 0)
                                <td><span class="label label-warning">Pending</span></td>
                            @elseif($payment->status == 1)
                                <td><span class="label label-danger">In Progress</span></td>
                            @elseif($payment->status == 2)
                                <td><span class="label label-success">Withdraw</span></td>
                            @endif
                            <td>
                            @if($payment->status != 2)
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                  Confirm Request
                                </button>
                                
                                
                                <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
            Payment Request: &nbsp;
            @if (\App\User::find($payment->seller_id) != null)
                {{ \App\User::find($payment->seller_id)->name }} ( {{ \App\User::find($payment->seller_id)->shop->name }} )
            @endif
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form-horizontal" action="{{ route('seller.confirmPayment') }}" method="POST" enctype="multipart/form-data">
    @csrf
      <div class="modal-body col-md-12">
          
        <div>
            <table class="table table-responsive">
                <tbody>
                    <tr>
                        @if($payment->amount >= 0)
                            <td>{{ __('Due to seller') }}</td>
                            <td>{{ single_price($payment->amount) }}</td>
                        @endif
                    </tr>
                </tbody>
            </table>
        </div>
        
            <input type="hidden" name="seller_id" value="{{ $payment->seller_id }}">
            
            <input type="hidden" name="paymentId" value="{{ $payment->id }}">
            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label" for="amount">{{__('Amount')}}</label>
                <div class="col-sm-9">
                    <input type="number" min="0" step="0.01" name="amount" id="amount" value="{{ $payment->amount }}" class="form-control" required>
                </div>
            </div>
            
            <br><br>
              <br>
            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label" for="payment_option">{{__('Payment Method')}}</label>
                <div class="col-sm-9">
                                    @if($payment->payment_method == 1)
                                    <span class="label label-info">{{__('general.bank')}}</span>
                                    @endif
                                    @if($payment->payment_method == 2)
                                    <span class="label">{{__('general.postal')}}</span>
                                    @endif
                                    @if($payment->payment_method == 3)
                                    <span class="label">{{__('general.vodafone_cache')}}</span>
                                    @endif
                </div>
            </div>
        
            <div class="form-group col-sm-12">
             <label class="col-lg-3 control-label">{{ __('payment receipt Image') }}</label><br><br>
             <div class="col-lg-9">
                <div id="image">

                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>

                            @endif
</td>
                            
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@section('script')
<script>
                $("#image").spartanMultiImagePicker({
                fieldName: 'file',
                maxCount: 1,
                rowHeight: '200px',
                groupClassName: 'col-md-12',
                maxFileSize: '',
                dropFileLabel: "Drop Here",
                onExtensionErr: function (index, file) {
                    console.log(index, file, 'extension err');
                    alert('Please only input png or jpg type file')
                },
                onSizeErr: function (index, file) {
                    console.log(index, file, 'file size too big');
                    alert('File size too big');
                }
            });
</script>
@endsection