@extends('layouts.app')

@section('content')


@if(auth()->user()->type != 'Seller')
<div class="row">
    <div class="col-lg-12">
        <a href="{{ route('countries.create')}}"
            class="btn btn-rounded btn-info pull-right">{{__('Add New Country')}}</a>
    </div>
</div>
@endif

<br>
<div class="col-lg-12">
    <div class="panel">
        <!--Panel heading-->
        <div class="panel-heading">
            <h3 class="panel-title">{{ __(' Countries') }}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Code')}}</th>
                        <th>{{__('Currency')}}</th>
                        <th>{{__('Icon')}}</th>
                        @if(\App\BusinessSetting::where('type', 'accept_kiosk')->first()->value == 1)
                        <th>{{__('Credit Card')}}</th>
                        @endif
                        @if(\App\BusinessSetting::where('type', 'accept_card')->first()->value == 1)
                        <th>{{__('Masary & Aman')}}</th>
                        @endif
                        @if(\App\BusinessSetting::where('type', 'accept_valu')->first()->value == 1)
                        <th>{{__('Valu')}}</th>
                        @endif
                        @if(\App\BusinessSetting::where('type', 'cash_payment')->first()->value == 1)
                        <th>{{__('Cash Payment')}}</th>
                            @endif
                        <th>Status</th>
                        <th>Default</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($countries as $key => $country)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ __($country['name_'.app()->getLocale()]) }}</td>
                        <td>{{ __($country->code) }}</td>
                        <td>{{ isset($country->Currency) ? $country->Currency['name_'.app()->getLocale()] : '' }}</td>
                        <td><img class="img-md" src="{{ asset($country->icon)}}" alt="Image"></td>
                        @if(\App\BusinessSetting::where('type', 'accept_card')->first()->value == 1)
                        <td><label class="switch">
                            <input onchange="update_payment_methods(this, 'accept_card')" value="{{ $country->id }}"
                            type="checkbox" <?php if ($country->accept_card == 1) echo "checked";?> >
                            <span class="slider round"></span></label></td>
                            @endif
                            @if(\App\BusinessSetting::where('type', 'accept_kiosk')->first()->value == 1)
                            <td><label class="switch">
                                <input onchange="update_payment_methods(this, 'accept_kiosk')" value="{{ $country->id }}"
                                       type="checkbox" <?php if ($country->accept_kiosk == 1) echo "checked";?> >
                                <span class="slider round"></span></label></td>
                                @endif
                            @if(\App\BusinessSetting::where('type', 'accept_valu')->first()->value == 1)
                            <td><label class="switch">
                                <input onchange="update_payment_methods(this, 'accept_valu')" value="{{ $country->id }}"
                                    type="checkbox" <?php if ($country->accept_valu == 1) echo "checked";?> >
                                <span class="slider round"></span></label></td>
                                @endif
                            @if(\App\BusinessSetting::where('type', 'cash_payment')->first()->value == 1)
                            <td><label class="switch">
                                <input onchange="update_payment_methods(this, 'cash_payment')" value="{{ $country->id }}"
                                    type="checkbox" <?php if ($country->cash_payment == 1) echo "checked";?> >
                                <span class="slider round"></span></label></td>
                                @endif
                                
                                <td><label class="switch">
                                <input onchange="update_status(this)" value="{{ $country->id }}"
                                    type="checkbox" <?php if ($country->status == 1) echo "checked";?> @if($country->default) disabled @endif>
                                <span class="slider round"></span></label>
                                </td>
                                
                                <td><label class="switch">
                                <input onchange="update_default(this)" value="{{ $country->id }}"
                                    type="checkbox" <?php if ($country->default == 1) echo "checked";?> >
                                <span class="slider round"></span></label>
                                </td>

                            <td>
                            <div class="btn-group dropdown">
                                <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon"
                                    data-toggle="dropdown" type="button">
                                    {{__('Actions')}} <i class="dropdown-caret"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="{{route('countries.edit', encrypt($country->id))}}">{{__('Edit')}}</a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection


@section('script')
<script type="text/javascript">
    $(document).ready(function(){
            //$('#container').removeClass('mainnav-lg').addClass('mainnav-sm');
        });

        function update_payment_methods(el, type) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('country.updatePaymentMethod') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status,
                type: type
            }, function (data) {
                if (data == 1) {
                    showAlert('success', 'Payment Method updated successfully');
                } else {
                    showAlert('danger', 'Something went wrong');
                }
            });
        }
        
        function update_status(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('country.updatestatus') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status,
            }, function (data) {
                if (data == 1) {
                    showAlert('success', 'Country Status updated successfully');
                } else {
                    showAlert('danger', 'Something went wrong');
                }
            });
        }
        
        function update_default(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('country.update_default') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status,
            }, function (data) {
                if (data == 1) {
                    location.reload();
                    showAlert('success', 'Country Default updated successfully');
                } else {
                    showAlert('danger', 'Something went wrong');
                }
            });
        }

        
</script>
@endsection