

@extends('layouts.app')
@section('title' , 'Cities')

@section('content')

        <div class="row">
            <div class="col-lg-12">
                <a href="{{ route('cities.create')}}"
                   class="btn btn-rounded btn-info pull-right">{{__('Add New City')}}</a>
            </div>
        </div>

    <br>

    <div class="col-lg-12">
        <div class="panel">
            <!--Panel heading-->
            <div class="panel-heading">
                <h3 class="panel-title">{{ __('Cities') }}</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                    @php
                        $smsa = \App\BusinessSetting::where('type' , 'shipment_smsa')->first();
                        $aramex = \App\BusinessSetting::where('type' , 'shipment_aramex')->first();
                    @endphp
                    <thead>
                    <tr>
                        <th>#</th>
                        <th width="20%">{{__('Name')}}</th>
                        <th>{{__('Country')}}</th>
                        <th>{{__('Delivery Price')}}</th>
                        @if ($smsa->value == 1)
                            <th>{{__('Smsa')}}</th>
                        @endif
                        @if($aramex->value == 1)
                            <th>{{__('Aramex')}}</th>
                        @endif
                        <th>{{__('Options')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cities as $key => $city)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$city['name_'.app()->getLocale()]}}</td>
                            <td>{{$city->country['name_'.app()->getLocale()]}}</td>
                            <td>{{$city->delivery_price}}</td>
                            @if($smsa->value == 1)
                            <td><label class="switch">
                                    <input onchange="update_smsa(this)" value="{{ $city->id }}"
                                           type="checkbox" <?php if ($city->smsa == 1) echo "checked";?> >
                                    <span class="slider round"></span></label>
                            </td>
                            @endif
                            @if($aramex->value == 1)
                            <td><label class="switch" @if($city->type == 0) disabled @endif>
                                    <input onchange="update_aramex(this)" value="{{ $city->id }}"
                                           type="checkbox" <?php if ($city->aramex == 1) echo "checked";?> @if($city->type == 0) disabled @endif>
                                    <span class="slider round"></span></label>
                            </td>
                            @endif
                            <td>
                                <div class="btn-group dropdown">
                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon"
                                            data-toggle="dropdown" type="button">
                                        {{__('Actions')}} <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a href="{{route('cities.edit', encrypt($city->id))}}">{{__('Edit')}}</a>
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

        function update_smsa(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('cities.update.shipment.status') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status,
                type:'smsa'
            }, function (data) {
                if (data == 1) {
                    showAlert('success', 'City Shipment status updated successfully');
location.reload();
} else {
                    showAlert('danger', 'Something went wrong');
                }
            });
        }

        function update_aramex(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('cities.update.shipment.status') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status,
                type:'aramex'
            }, function (data) {
                if (data == 1) {
                    showAlert('success', 'City Shipment status updated successfully');
location.reload();
} else {
                    showAlert('danger', 'Something went wrong');
                }
            });
        }
    </script>
@endsection