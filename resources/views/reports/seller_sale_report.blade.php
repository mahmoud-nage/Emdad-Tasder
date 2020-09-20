@extends('layouts.app')

@section('content')
<div class="pad-all text-center col-md-offset-2 col-md-8">
    <form class="" action="{{ route('seller_sale_report.index') }}" method="GET" style="margin-bottom:30px">
        <div class="form-group">
            <label class="col-sm-3 control-label" for="name">{{__('Sort by verificarion status:')}}</label>
                <div class="col-sm-7">
                    <select class="select2" name="verification_status" required>
                        <option value="1" <?php if($status == 1) echo "selected";?>>Approved</option>
                        <option value="0" <?php if($status == 0) echo "selected";?>>Non Approved</option>
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
                <h3 class="panel-title">{{ __('Seller Based Selling Report') }}</h3>
            </div>

            <!--Panel body-->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped mar-no demo-dt-basic">
                        <thead>
                            <tr>
                                <th>Seller Name</th>
                                <th>Shop Name</th>
                                <th>Number of Sale</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sellers as $key => $seller)
                                @if($seller->user != null)
                                    <tr>
                                        <td>{{ $seller->user->name }}</td>
                                        <td>{{ $seller->user->shop->name }}</td>
                                        <td>
                                            {{ $seller->user->products->sum('num_of_sale') }}
                                        </td>
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
