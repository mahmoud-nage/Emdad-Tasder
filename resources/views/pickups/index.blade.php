

@extends('layouts.app')
@section('title' , 'Cities')

@section('content')
@if($shipment_order_pending > 1)
        <div class="row">
            <div class="col-lg-12">
                <a href="{{ route('aramex_pickup.create')}}"
                   class="btn btn-rounded btn-info pull-right">{{__('Add New PickUp')}}</a>
            </div>
        </div>
@endif

    <br>

    <div class="col-lg-12">
        <div class="panel">
            <!--Panel heading-->
            <div class="panel-heading">
                <h3 class="panel-title">{{ __('Pick Ups') }}</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th width="20%">{{__('pickupId')}}</th>
                        <th>{{__('pickupGUID')}}</th>
                        <th>{{__('Shipment Count')}}</th>
                        <th>{{__('Status')}}</th>
                        <th>{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($records as $key => $record)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$record->pickupId}}</td>
                            <td>{{$record->pickupGUID}}</td>
                            <td>{{$record->shipment_count}}</td>
                            <td>{{$record->status}}</td>
                            <td>
                                <div class="btn-group dropdown">
                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon"
                                            data-toggle="dropdown" type="button">
                                        {{__('Actions')}} <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        @if(true)
                                            <li>
                                                <a href="{{route('aramex_pickup.cancel', encrypt($record->id))}}">{{__('Cancel PickUp')}}</a>
                                            </li>
                                        @endif
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
@endsection