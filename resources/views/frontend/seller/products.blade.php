@extends('frontend.layouts.app')
@section('title' , __('general.products') )
@section('meta')
<meta name="keywords" content="{{ $seo_setting->keyword }}">
<meta name="description" content="{{ $seo_setting->description}}">
<meta property="og:title" content="{{__('general.products')}}" />
<meta property="og:description" content="{{ $seo_setting->description}}" />
@endsection
@section('content')

    <div class="container-fluid">
        <!-- Content -->
        <div class="page-wrap profile-page">
            <!-- Menu -->
        @include('frontend.inc.seller_side_nav')
        <!--  Content -->
            <div class="main-content">

                <!-- Order -->
                <div class="profile-title">
                    {{__('general.products')}}
                    <div>
                        <a href="{{ route('seller.products.upload',['country' => get_country()->code]) }}" class="btn btn-success">{{__('general.add_new_product')}}</a>
                    </div>
                </div>
                <br>
                <!-- User Info -->
                <div class="table-wrapper">
                    <div class="table-block">
                        <table class="table table-responsive table-hover ">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('forms.name')}}</th>
                                <th>{{__('general.image')}}</th>
                                <th>{{__('general.quantity')}}</th>
                                <th>{{__('forms.price')}}</th>
                                <th>{{__('Todays Deal')}}</th>
                                <th>{{__('forms.published')}}</th>
                                <th>{{__('general.featured')}}</th>
                                <th>{{__('forms.options')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($products as $key => $product)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td><a href="{{ route('product', ['country' => get_country()->code, 'slug'=>$product->slug]) }}"
                                           target="_blank">{{ app()->isLocale('ar') ? $product->name_ar : $product->name_en }}</a>
                                    </td>
                                      <td><img class="img-md" style="max-width: 64px;max-height: 64px;" src="{{ asset($product->thumbnail_img)}}" alt="{{ app()->isLocale('ar') ? $product->name_ar : $product->name_en }}"></td>
                                    <td>
                                        @php
                                            $qty = 0;
                                            foreach (json_decode($product->variations) as $key => $variation) {
                                                $qty += $variation->qty;
                                            }
                                            if($qty <= 0) {$qty = $product->main_quantity;}
                                            
                                            echo $qty;
                                        @endphp
                                    </td>
                                    <td>{{ $product->get_price(get_country()->id) }}</td>
                                                                <td><label class="switch">
                                    <input onchange="update_todays_deals(this)" value="{{ $product->id }}"
                                           type="checkbox" <?php if ($product->todays_deal == 1) echo "checked";?> >
                                    <span class="slider round"></span></label></td>
                                    <td><label class="switch">
                                            <input onchange="update_published(this)" value="{{ $product->id }}"
                                                   type="checkbox" <?php if ($product->published == 1) echo "checked";?> disabled>
                                            <span class="slider round"></span>
                                            </label>
                                    </td>
                                    <td><label class="switch">
                                            <input onchange="update_featured(this)" value="{{ $product->id }}"
                                                   type="checkbox" <?php if ($product->featured == 1) echo "checked";?> disabled>
                                            <span class="slider round"></span></label>
                                    </td>

                                    <td>
                                        <div class="dropdown custom-dropdown">
                                            <a class="dropdown-toggle" type="button" data-toggle="dropdown"
                                               aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{route('seller.products.edit', ['country' => get_country()->code, 'id'=> encrypt($product->id) ])}}">{{__('forms.edit')}}</a>
                                                </li>
                                                {{-- <li role="separator" class="divider"></li>
                                                <li>
                                                    <a href="{{route('products.duplicate', ['country' => get_country()->code, 'id'=> $product->id])}}">{{__('general.duplicate')}}</a>
                                                </li> --}}
                                                <!--<li role="separator" class="divider"></li>-->
                                                <!--<li><a href="javascript:void(0)"-->
                                                <!--       onclick="confirm_modal('{{route('products.destroy',  ['country' => get_country()->code, 'id'=> $product->id])}}')">{{__('forms.delete')}}</a>-->
                                                <!--</li>-->
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
        </div>
    </div>
    <div style="position: relative;bottom: -40px;">
        @include('frontend.seller.footer_tabs')
    </div>
@endsection
@section('script')
    <script type="text/javascript">
  
        
                function update_todays_deals(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('products.todays_deals', ['country' => get_country()->code]) }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function (data) {
                if (data == 1) {
                    if($('html').attr('lang') == 'ar'){
                        showFrontendAlert('success', 'تم التعديل بنجاح');
                    }else{
                        showFrontendAlert('success', 'Today Deal products updated successfully');
                    }
                } else {
                                          if($('html').attr('lang') == 'ar'){
                        showFrontendAlert('success', 'حدث خطأ ما');
                    }else{
                    showFrontendAlert('danger', 'Something went wrong');
                    }
                }
            });
        }
        
        function update_featured(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('products.featured', ['country' => get_country()->code]) }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function (data) {
                if (data == 1) {
                                        if($('html').attr('lang') == 'ar'){
                        showFrontendAlert('success', 'تم التعديل بنجاح');
                    }else{
                    showFrontendAlert('success', 'Featured products updated successfully');
                    }
                } else {
                                          if($('html').attr('lang') == 'ar'){
                        showFrontendAlert('success', 'حدث خطأ ما');
                    }else{
                    showFrontendAlert('danger', 'Something went wrong');
                    }
                }
            });
        }

        function update_published(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('products.published', ['country' => get_country()->code]) }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function (data) {
                if (data == 1) {
                                        if($('html').attr('lang') == 'ar'){
                        showFrontendAlert('success', 'تم التعديل بنجاح');
                    }else{
                    showFrontendAlert('success', 'Published products updated successfully');
                    }
                } else {
                                        if($('html').attr('lang') == 'ar'){
                        showFrontendAlert('success', 'حدث خطأ ما');
                    }else{
                    showFrontendAlert('danger', 'Something went wrong');
                    }
                }
            });
        }
    </script>
@endsection
