@extends('affiliate.layouts.app')
@section('content')
    <div class="panel" id="storeCoupon">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Create coupon')}}</h3>
        </div>
        @if(isset($coupon)&&!is_null($coupon)&&!empty($coupon))
            <h3>This is your coupon <span style="color: #fd397a"> {{$coupon->code}}</span></h3>
        @else
        <!--Horizontal Form-->
            <form class="form-horizontal" action="{{ route('affiliate.coupon.store') }}" method="POST">
                @csrf
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-3" for="url"></label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="" id="url" name="coupon" class="form-control"
                                   value="{{old('coupon')}}" required>
                            <small class="text-danger">{{ $errors->first('coupon') }}</small>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Create coupon</button>
            </form>
            <!--End Horizontal Form-->
        @endif

    </div>

@stop
@section('script')
    <script>
        var storeCoupon = new Vue({
            el: "#storeCoupon",
            data: {
                query: $(location).attr('search'),
                base_url: "{!! url('/') !!}",
                url: "{!! request()->url() !!}",
                csrf: $('meta[name="csrf-token"]').attr('content'),
            },
            mounted() {
            },
            methods: {
                storeCoupon: function () {
                    $.ajax({
                        _token: this.csrf,
                        url: "{!! route('api.affiliate.coupon.store') !!}",
                        type: 'POST',
                        data: {
                            locale: '{{ \App::getLocale() }}',
                            affiliate_id: '{{ auth()->user()->Affiliate->id }}',
                            coupon: "newCouponTestApi"
                        },
                    }).then((response) => {
                        console.log(response);
                    });
                },
            },
        });
    </script>
@stop
