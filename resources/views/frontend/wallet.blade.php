@extends('frontend.layouts.app')

@section('content')
    <style>
        .dashboard-stat:hover{
            cursor: pointer;
        }
    </style>

    <!-- Page Contents Wrapper-->
    <div class="container">
        <!-- Content -->
        <div class="page-wrap">
            <!-- Menu -->
        @include('frontend.inc.customer_side_nav')
        <!--  Content -->
            <div class="main-content">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-lg-4">
                        <div class=" dashboard-stat stat-products">
                            <div class="stat-icon">
                                <img src="{{ asset('assets/web/images/wallet.svg') }}" alt="">
                            </div>
                            <div class="stat-number">
                                <span class="counter">{{ single_price(Auth::user()->balance) }}</span>L.E
                            </div>
                            <div class="stat-title">
                                {{__('general.balance')}}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-lg-4">
                        <div class=" dashboard-stat stat-products" style="background: white;color: #f76b99" onclick="show_wallet_modal()">
                            <div class="stat-icon">
                                <img src="{{ asset('assets/web/images/plus.svg') }}" style="background: #f76b99;" alt="">
                            </div>
                            <div class="stat-number">
                                <span class="counter">{{__('general.add_balance')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="table-wrapper">
                    <div class="table-block">
                        <table class="table table-responsive table-striped table-hover ">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('forms.date') }}</th>
                                <th>{{__('general.amount')}}</th>
                                <th>{{__('general.payment_method')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($wallets) > 0)
                                @foreach ($wallets as $key => $wallet)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ date('d-m-Y', strtotime($wallet->created_at)) }}</td>
                                        <td>{{ single_price($wallet->amount) }}</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $wallet ->payment_method)) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center pt-5 h4" colspan="100%">
                                        <i class="la la-meh-o d-block heading-1 alpha-5"></i>
                                        <span class="d-block">{{ __('general.no_history_found') }}</span>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    {{ $wallets->links() }}

                </div>

            </div>


        </div>
    </div>

    <div class="modal fade" id="wallet_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="modal-header">
                    <h5 class="modal-title strong-600 heading-5">{{__('general.recharge_wallet')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="" action="{{ route('wallet.recharge') }}" method="post">
                    @csrf
                    <div class="modal-body gry-bg px-3 pt-3">
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{__('general.amount')}} <span class="required-star">*</span></label>
                            </div>
                            <div class="col-md-10">
                                <input type="number" class="form-control mb-3" name="amount" placeholder="{{__('general.amount')}}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{__('general.payment_method')}}</label>
                            </div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <select class="form-control" data-minimum-results-for-search="Infinity" name="payment_option">
                                        @if (\App\BusinessSetting::where('type', 'paypal_payment')->first()->value == 1)
                                            <option value="paypal">{{__('Paypal')}}</option>
                                        @endif
                                        @if (\App\BusinessSetting::where('type', 'stripe_payment')->first()->value == 1)
                                            <option value="stripe">{{__('Stripe')}}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-main">{{__('general.confirm')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script type="text/javascript">
        function show_wallet_modal(){
            $('#wallet_modal').modal('show');
        }
    </script>
@endsection
