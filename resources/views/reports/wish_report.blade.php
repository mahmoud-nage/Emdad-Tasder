@extends('layouts.app')

@section('content')

<div class="pad-all text-center col-md-offset-2 col-md-8">
    <form class="" action="{{ route('wish_report.index') }}" method="GET" style="margin-bottom:30px">
        <div class="form-group">
            <label class="col-sm-3 control-label" for="name">{{__('Sort by Category:')}}</label>
                <div class="col-sm-7">
                    <select name="category_id" required class="form-control select2">
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" <?php if($cat == $category->id) echo "selected";?> >{{__($category['name_'.app()->getLocale()])}}</option>
                        @endforeach
                    </select>
                </div>
        </div>
                    <div class="col-sm-2">

        <button class="btn btn-default" type="submit">Filter</button>
        </div>
    </form>
</div>


    <div class="col-md-offset-2 col-md-8">
        <div class="panel">
            <!--Panel heading-->
            <div class="panel-heading">
                <h3 class="panel-title">Product Wish Report</h3>
            </div>

            <!--Panel body-->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped mar-no demo-dt-basic">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Number of Wish</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $key => $product)
                                @if($product->wishlists != null)
                                    <tr>
                                        <td>{{ __($product->name_en) }}</td>
                                        <td>{{ $product->wishlists->count() }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
