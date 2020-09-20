<div class="modal-body added-to-cart">
    <div class="text-center text-success">
        <i class="fa fa-check"></i>
        <h3>{{__('general.added_to_cart')}}</h3>
    </div>
    <div class="card">
        <div class="card-body text-center">
            <div class="block-image">
                <img src="{{ asset($product->thumbnail_img) }}" class="" width="200" alt="Product Image">
            </div>
            <div class="block-body">
                <h6 class="strong-600">
                    {{ app()->isLocale('ar') ? $product->name_ar : $product->name_en }}
                </h6>
                <div class="row">
                    <div class="col-2">
                        <div>{{__('forms.price')}}:</div>
                    </div>
                    <div class="col-10">
                        <div class="heading-6 text-danger">
                            <strong>
                                {{ single_price($data['price']*$data['quantity']) }}
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center">
        <button class="btn btn-success" data-dismiss="modal">{{__('general.return_to_shop')}}</button>
        <a href="{{ route('cart',['country' => get_country()->code]) }}" class="btn btn-main">{{__('general.continue_to_shipping')}}</a>
    </div>
</div>
