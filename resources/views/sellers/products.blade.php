{{-- @extends('layouts.app')

@section('content') --}}


    {{-- <div class="col-lg-12"> --}}
        <div class="panel">
            <!--Panel heading-->
            <div class="panel-heading">
                <h3 class="panel-title"> {{ __($type.' Products') }}&nbsp;( {{isset($seller->shop->name)?$seller->shop->name:$seller->user->name}} ) </h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th width="20%">{{__('Name')}}</th>
                        <th>{{__('Photo')}}</th>
                        <th>{{__('Current qty')}}</th>
                        <th>{{__('Base Price')}}</th>
                        <th>{{__('Todays Deal')}}</th>
                        <th>{{__('Published')}}</th>
                        <th>{{__('Featured')}}</th>
                        <th>{{__('Options')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $key => $product)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td><a href="{{ route('product', $product->slug) }}"
                                   target="_blank">{{ __($product->name_ar) }}</a></td>
                            <td><img class="img-md" src="{{ asset($product->thumbnail_img)}}" alt="Image"></td>
                            <td>
                                @if($product->main_quantity ==0 )
                                    {{ \App\Variation::where('product_id' , $product->id)->sum('qty') }}
                                @else
                                    {{$product->main_quantity}}
                                @endif
                            </td>
                            @php
                                if (request()->session()->get('country')){
                                    $country = \App\Country::where('code' , request()->session()->get('country'))->first();
                                }else{
                                    $country = \App\Country::where('code' , 'eg')->first();
                                }
                                $price = $product->get_price($country->id);
                            @endphp
                            <td>{{ $price}}</td>
                            <td><label class="switch">
                                    <input onchange="update_todays_deal(this)" value="{{ $product->id }}"
                                           type="checkbox" <?php if ($product->todays_deal == 1) echo "checked";?> >
                                    <span class="slider round"></span></label></td>
                            <td><label class="switch">
                                    <input onchange="update_published(this)" value="{{ $product->id }}"
                                           type="checkbox" <?php if ($product->published == 1) echo "checked";?> >
                                    <span class="slider round"></span></label></td>
                            <td><label class="switch">
                                    <input onchange="update_featured(this)" value="{{ $product->id }}"
                                           type="checkbox" <?php if ($product->featured == 1) echo "checked";?> >
                                    <span class="slider round"></span></label></td>
                            <td>
                                <div class="btn-group dropdown">
                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon"
                                            data-toggle="dropdown" type="button">
                                        {{__('Actions')}} <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        @if ($type == 'Seller')
                                            <li>
                                                <a href="{{route('products.seller.edit', encrypt($product->id))}}">{{__('Edit')}}</a>
                                            </li>
                                        @else
                                            <li>
                                                <a href="{{route('products.admin.edit', encrypt($product->id))}}">{{__('Edit')}}</a>
                                            </li>
                                        @endif
                                        <li>
                                            <a onclick="confirm_modal('{{route('products.destroy', $product->id)}}');">{{__('Delete')}}</a>
                                        </li>
                                        <li>
                                            <a href="{{route('products.duplicate', $product->id)}}">{{__('Duplicate')}}</a>
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
    {{-- </div> --}}

    {{-- @include('sellers.summary')

@endsection --}}


@section('script')
    {{-- <script type="text/javascript">

        $(document).ready(function () {
            //$('#container').removeClass('mainnav-lg').addClass('mainnav-sm');
        });

        function update_todays_deal(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('products.todays_deal') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function (data) {
                if (data == 1) {
                    showAlert('success', 'Todays Deal updated successfully');
                } else {
                    showAlert('danger', 'Something went wrong');
                }
            });
        }

        function update_published(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('products.published') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function (data) {
                if (data == 1) {
                    showAlert('success', 'Published products updated successfully');
                } else {
                    showAlert('danger', 'Something went wrong');
                }
            });
        }

        function update_featured(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('products.featured') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function (data) {
                if (data == 1) {
                    showAlert('success', 'Featured products updated successfully');
                } else {
                    showAlert('danger', 'Something went wrong');
                }
            });
        }
    </script> --}}
@endsection
