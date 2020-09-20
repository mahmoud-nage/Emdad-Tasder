@extends('layouts.app')

@section('content')

    <div id="payments" class="col-lg-12">
        <div class="panel">
            <!--Panel heading-->
            <div class="panel-heading">
                <h3 class="panel-title">{{ __('Users') }}</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Amount')}}</th>
                        <th>{{__('Payment Method')}}</th>
                        <th>{{__('Bank Account')}}</th>
                        <th>{{__('SSN')}}</th>
                        <th>{{__('Bank Name')}}</th>
                        <th>{{__('Bank account Username')}}</th>
                        <th>{{__('Bank account Number')}}</th>
                        <th>{{__('Egyptian mail')}}</th>
                        <th>{{__('Phone')}}</th>
                        <th>{{__('Country')}}</th>
                        <th>{{__('Address')}}</th>
                        <th>{{__('Date')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="request, index  in requests">
                        <td>@{{ index +1 }}</td>
                        <td>@{{ request.affiliate.user.name }}</td>
                        <td>@{{ request.amount }}</td>
                        <td>@{{ request.payment_method }}</td>
                        <td>@{{ request.bank_account_status }}</td>
                        <td>@{{ request.SSN }}</td>
                        <td>@{{ request.bank_name }}</td>
                        <td>@{{ request.bank_account_username }}</td>
                        <td>@{{ request.bank_account_number }}</td>
                        <td>@{{ request.egyptian_mail_status }}</td>
                        <td>@{{ request.affiliate.user.phone }}</td>
                        <td>@{{ request.affiliate.user.country }}</td>
                        <td>@{{ request.affiliate.user.address }}</td>
                        <td>@{{ request.created_at }}</td>
                    </tr>
                    </tbody>
                </table>

            </div>

        </div>
        {{--        <div class="modal fade" id="payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"--}}
        {{--             aria-hidden="true">--}}
        {{--            <div class="modal-dialog" role="document">--}}
        {{--                <div class="modal-content">--}}
        {{--                    <div class="modal-header">--}}
        {{--                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>--}}
        {{--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
        {{--                            <span aria-hidden="true">&times;</span>--}}
        {{--                        </button>--}}
        {{--                    </div>--}}
        {{--                    <form method="POST" action="{{ route('affiliates.payments.store') }}" v-if="selected_affiliate">--}}
        {{--                        <div class="modal-body">--}}
        {{--                            @csrf--}}
        {{--                            <input type="hidden" name="affiliate_id" :value="selected_affiliate.id">--}}
        {{--                            <br/>--}}
        {{--                            <div class="form-group row">--}}
        {{--                                <label class="col-form-label col-lg-3 col-sm-12">Amount *</label>--}}
        {{--                                <div class="col-lg-4 col-md-9 col-sm-12">--}}
        {{--                                    <label class="kt-checkbox kt-checkbox--success">--}}
        {{--                                        <input type="number" class="form-control" name="amount" min="1" accept="any" placeholder="Amount" required>--}}
        {{--                                        <span></span>--}}
        {{--                                    </label>--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                            <div class="form-group row">--}}
        {{--                                <label class="col-form-label col-lg-3 col-sm-12">egyptian mail</label>--}}
        {{--                                <div class="col-lg-4 col-md-9 col-sm-12">--}}
        {{--                                    <label class="kt-checkbox kt-checkbox--success">--}}
        {{--                                        <input type="radio" name="payment_method" value="egyptian_mail" required>--}}
        {{--                                        egyptian mail--}}
        {{--                                        <span></span>--}}
        {{--                                    </label>--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                            <br/>--}}
        {{--                            <div class="form-group row">--}}
        {{--                                <label class="col-form-label col-lg-3 col-sm-12">Full name</label>--}}
        {{--                                <div class="col-lg-6 col-md-9 col-sm-12">--}}
        {{--                                    <div class="input-group">--}}
        {{--                                        <input type="text"--}}
        {{--                                               class="form-control @error('full_name') is-invalid @enderror"--}}
        {{--                                               name="full_name" :value="selected_affiliate.full_name"--}}
        {{--                                               placeholder="Full name" disabled>--}}
        {{--                                    </div>--}}
        {{--                                    @error('full_name')--}}
        {{--                                    <div class="error">{{ $message }}</div>--}}
        {{--                                    @enderror--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                            <br/>--}}
        {{--                            <div class="form-group row">--}}
        {{--                                <label class="col-form-label col-lg-3 col-sm-12">SSN</label>--}}
        {{--                                <div class="col-lg-6 col-md-9 col-sm-12">--}}
        {{--                                    <div class="input-group">--}}
        {{--                                        <input type="text" class="form-control @error('SSN') is-invalid @enderror"--}}
        {{--                                               maxlength="14"--}}
        {{--                                               name="SSN" :value="selected_affiliate.SSN"--}}
        {{--                                               placeholder="SSN" disabled>--}}
        {{--                                    </div>--}}
        {{--                                    @error('name_en')--}}
        {{--                                    <div class="error">{{ $message }}</div>--}}
        {{--                                    @enderror--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                            <br/>--}}
        {{--                            <div class="form-group row">--}}
        {{--                                <label class="col-form-label col-lg-3 col-sm-12">bank account</label>--}}
        {{--                                <div class="col-lg-4 col-md-9 col-sm-12">--}}
        {{--                                    <label class="kt-checkbox kt-checkbox--success">--}}
        {{--                                        <input type="radio" name="payment_method" value="bank_account" required> bank--}}
        {{--                                        account--}}
        {{--                                        <span></span>--}}
        {{--                                    </label>--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                            <br/>--}}
        {{--                            <div class="form-group row">--}}
        {{--                                <label class="col-form-label col-lg-3 col-sm-12">Bank name</label>--}}
        {{--                                <div class="col-lg-6 col-md-9 col-sm-12">--}}
        {{--                                    <div class="input-group">--}}
        {{--                                        <input type="text"--}}
        {{--                                               class="form-control @error('bank_name') is-invalid @enderror"--}}
        {{--                                               maxlength="14"--}}
        {{--                                               name="bank_name" :value="selected_affiliate.bank_name"--}}
        {{--                                               placeholder="bank_name" disabled>--}}
        {{--                                    </div>--}}
        {{--                                    @error('bank_name')--}}
        {{--                                    <div class="error">{{ $message }}</div>--}}
        {{--                                    @enderror--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                            <br/>--}}
        {{--                            <div class="form-group row">--}}
        {{--                                <label class="col-form-label col-lg-3 col-sm-12">Bank account username</label>--}}
        {{--                                <div class="col-lg-6 col-md-9 col-sm-12">--}}
        {{--                                    <div class="input-group">--}}
        {{--                                        <input type="text"--}}
        {{--                                               class="form-control @error('bank_account_username') is-invalid @enderror"--}}
        {{--                                               maxlength="14"--}}
        {{--                                               name="bank_account_username"--}}
        {{--                                               :value="selected_affiliate.bank_account_username"--}}
        {{--                                               placeholder="Bank account username " disabled>--}}
        {{--                                    </div>--}}
        {{--                                    @error('bank_account_username')--}}
        {{--                                    <div class="error">{{ $message }}</div>--}}
        {{--                                    @enderror--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                            <br/>--}}
        {{--                            <div class="form-group row">--}}
        {{--                                <label class="col-form-label col-lg-3 col-sm-12">Bank account number</label>--}}
        {{--                                <div class="col-lg-6 col-md-9 col-sm-12">--}}
        {{--                                    <div class="input-group">--}}
        {{--                                        <input type="text"--}}
        {{--                                               class="form-control @error('bank_account_number') is-invalid @enderror"--}}
        {{--                                               maxlength="14"--}}
        {{--                                               name="bank_account_number"--}}
        {{--                                               :value="selected_affiliate.bank_account_number"--}}
        {{--                                               placeholder="bank name" disabled>--}}
        {{--                                    </div>--}}
        {{--                                    @error('bank_account_number')--}}
        {{--                                    <div class="error">{{ $message }}</div>--}}
        {{--                                    @enderror--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                        <div class="modal-footer">--}}
        {{--                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
        {{--                            <button type="submit" class="btn btn-primary">Save changes</button>--}}
        {{--                        </div>--}}
        {{--                    </form>--}}

        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
    </div>

@endsection

@section('script')
    <script>
        new Vue({
            el: "#payments",
            data: {
                requests: {!! $requests !!},
                status: '',
                name: '',
                country: '0',
                is_blocked: 0,
                is_approved: 0,
                category: '0',
                current_page_url: '',
                pages: '',
                selected_affiliate: '',
                last_page: '',
                base_url: "{!! url('/') !!}",
                url: "{!! request()->url() !!}",
            },
            methods: {

            },
        });
    </script>
@stop
