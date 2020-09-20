@inject('categories', 'App\Category');
@extends('layouts.app')
@section('content')

    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel">
            <!--Horizontal Form-->
            <form class="form-horizontal" action="{{ route('categories.vendor_commission.update') }}" method="POST">
            	@csrf
                <div class="panel-body">
                    <div class="form-group">
                    <label class="col-lg-12 text-left control-label">{{__('Seller Commission')}}</label>
                    </div>
                    @foreach ($categories->all() as $cat)
                    <div class="form-group">
                        <div class="col-lg-5">
                            <input type="hidden"  name="ids[]" value="{{$cat->id}}" class="form-control">
                            <input type="text" disabled value="{{ $cat['name_'.app()->getLocale()] }}" class="form-control">
                        </div>
                        <div class="col-lg-5">
                            <input type="number" min="0" step="0.01" value="{{ $cat->vendor_commission }}" placeholder="{{__('Seller Category Commission')}}" name="vendor_commission[]" class="form-control">
                        </div>
                        <div class="col-lg-2">
                            <option class="form-control">%</option>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="panel-footer text-right">
                    <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
                </div>
            </form>
            <!--===================================================-->
            <!--End Horizontal Form-->

        </div>
    </div>


@endsection
