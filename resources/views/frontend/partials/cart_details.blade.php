@include('frontend.partials.cart_summary')
<div class="col-xs-12 col-md-7 col-lg-8">
    <div class="cart-items-wrapper">
        <table class="table table-responsive cart-item">
            <thead>
            <tr>
                <th class="product-image"></th>
                <th class="product-name">{{__('Product')}}</th>
                <th class="product-price d-none d-lg-table-cell">{{__('Price')}}</th>
                <th class="product-quanity d-none d-md-table-cell">{{__('Quantity')}}</th>
                <th class="product-total">{{__('Total')}}</th>
                <th class="product-remove"></th>
            </tr>
            </thead>
            <tbody>
            @php
                $total = 0;
            @endphp
            @foreach (Session::get('cart') as $key => $cartItem)
                @php
                    $product = \App\Product::find($cartItem['id']);
                    $total = $total + $cartItem['price']*$cartItem['quantity'];
                    $product_name_with_choice = app()->isLocale('ar') ? $product->name_ar : $product->name_en;
                    if(isset($cartItem['color'])){
                        $product_name_with_choice .= ' - '.\App\Color::where('code', $cartItem['color'])->first()->name;
                    }
                    foreach (json_decode($product->choice_options) as $choice){
                        $str = $choice->name; // example $str =  choice_0
                        $product_name_with_choice .= ' - '.$cartItem[$str];
                    }
                @endphp
                <tr class="cart-item">
                    <td class="product-image">
                        <a href="#" class="mr-3">
                            <img src="{{ asset($product->thumbnail_img) }}" width="100">
                        </a>
                    </td>

                    <td class="product-name">
                        <span class="pr-4 d-block">{{ app()->isLocale('ar') ? $product->name_ar : $product->name_en }}</span>
                    </td>

                    <td class="product-price d-none d-lg-table-cell">
                        <span class="pr-3 d-block">{{ single_price($cartItem['price']) }}</span>
                    </td>
                    <td class="product-quantity d-none d-md-table-cell">
                        <div class=" number-input-wrapper">
                            <div class="number-input">
                                <button onclick="updateQuantity({{ $key }}, this.nextElementSibling , 'minus')"
                                        data-type="minus" data-field="quantity[{{ $key }}]"></button>
                                <input class="quantity" min="0" name="quantity[{{ $key }}]"
                                       value="{{ $cartItem['quantity'] }}" type="number"
                                       onchange="updateQuantity({{ $key }}, this)">
                                <button onclick="updateQuantity({{ $key }}, this.previousElementSibling , 'plus')"
                                        class="plus" data-type="plus"
                                        data-field="quantity[{{ $key }}]"></button>
                            </div>
                        </div>
                    </td>
                    <td class="product-total">
                        <span>{{ single_price($cartItem['price']*$cartItem['quantity']) }}</span>
                    </td>
                    <td class="product-remove">
                        <span class="remove-item fa fa-trash" title="Remove from Cart" onclick="removeFromCartView(event, {{ $key }})"></span>
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>
    <div class="form-group text-right">
        @if(Auth::check())
            <a href="{{ route('checkout.shipping_info', ['country' => get_country()->code]) }}" class="btn btn-main next-tab">{{__('Continue to Shipping')}}</a>
        @else
            <button class="btn btn-main next-tab" onclick="showCheckoutModal()">{{__('Continue to Shipping')}}
                <i class="fa fa-chevron-right"></i>
            </button>
        @endif
    </div>

</div>
<script type="text/javascript">
    cartQuantityInitialize();
    function updateQuantity(key, element,type) {
        if(type == 'plus'){
            element.parentNode.querySelector('input[type=number]').stepUp()
        }else{
            element.parentNode.querySelector('input[type=number]').stepDown()
        }
        $.post('{{ route('cart.updateQuantity', ['country' => get_country()->code]) }}', {
            _token: '{{ csrf_token() }}',
            key: key,
            quantity: element.value
        }, function (data) {
            updateNavCart();
            $('#cart-summary').html(data);
        });
    }

</script>
