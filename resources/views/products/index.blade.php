@extends('layouts.app')

@section('content')
@php
    if($type == 'Seller'){
        $route = 'products.seller';
    }elseif($type == 'Packages'){
        $route = 'packages.index';
    }elseif($type == 'Pendding Seller'){
        $route = 'products.seller.pendding';
    }else{
        $route = 'products.admin';
    }
@endphp 

<div class="pad-all text-center col-md-offset-2 col-md-8">
    <form class="" action="{{ route($route) }}" method="GET" style="margin-bottom:30px">
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


    @if($type == 'In House')
        <div class="row">
            <div class="col-lg-12">
                <a href="{{ route('products.create')}}"
                   class="btn btn-rounded btn-info pull-right">{{__('Add New Product')}}</a>
            </div>
        </div>
    @endif

    <br>

    <div class="col-lg-12">
        <div class="panel">
            <!--Panel heading-->
            <div class="panel-heading">
                <h3 class="panel-title">{{ __($type.' Products') }}</h3>
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
                    @if($products != null)
                    @foreach($products as $key => $product)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td><a href="{{ route('product', ['country' => auth()->user()->country, 'slug' => $product->slug]) }}"
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
                                                <a href="{{route('products.seller.edit', ['country' => 'eg', 'id' => encrypt($product->id)])}}">{{__('Edit')}}</a>
                                            </li>
                                        @else
                                            <li>
                                                <a href="{{route('products.admin.edit', encrypt($product->id))}}">{{__('Edit')}}</a>
                                            </li>
                                        @endif
                                        <!--<li>-->
                                        <!--    <a onclick="confirm_modal('{{route('products.destroy', $product->id)}}');">{{__('Delete')}}</a>-->
                                        <!--</li>-->
                                        <li>
                                            <a href="{{route('products.duplicate', $product->id)}}">{{__('Duplicate')}}</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection


@section('script')
    <script type="text/javascript">

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
    </script>
@endsection
