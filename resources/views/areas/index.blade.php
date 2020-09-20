@extends('layouts.app')
@section('title' , 'Areas')
@section('content')
   




@extends('layouts.app')
@section('title' , 'Cities')

@section('content')

@if(false)
        <div class="row">
            <div class="col-lg-12">
                <a href="{{ route('areas.create')}}"
                   class="btn btn-rounded btn-info pull-right">{{__('Add New Area')}}</a>
            </div>
        </div>

    <br>
    @endif

    <div class="col-lg-12">
        <div class="panel">
            <!--Panel heading-->
            <div class="panel-heading">
                <h3 class="panel-title">{{ __('Areas') }}</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th width="20%">{{__('Name')}}</th>
                        <th>{{__('City')}}</th>
                        <th>{{__('Country')}}</th>
                        {{-- <th>{{__('Options')}}</th> --}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($areas as $key => $area)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$area['name_'.app()->getLocale()]}}</td>
                            {{-- <td>{{$area->City['name_'.app()->getLocale()]}}</td> --}}
                            {{-- <td>{{$area->City->country['name_'.app()->getLocale()]}}</td> --}}
                            {{-- <td> --}}
                                {{-- <div class="btn-group dropdown">
                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon"
                                            data-toggle="dropdown" type="button">
                                        {{__('Actions')}} <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        @if(false)
                                            <!--<li>-->
                                            <!--    <a href="{{route('cities.edit', encrypt($area->id))}}">{{__('Edit')}}</a>-->
                                            <!--</li>-->
                                        <!--<li>-->
                                        <!--    <a onclick="confirm_modal('{{route('cities.destroy', $area->id)}}');">{{__('Delete')}}</a>-->
                                        <!--</li>-->
                                        @endif
                                    </ul>
                                </div> --}}
                            {{-- </td> --}}
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection
