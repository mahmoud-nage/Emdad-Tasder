@if(count($product_ids) > 0)
    <label class="col-sm-3 control-label">{{__('Discounts')}}</label>
    <div class="col-sm-9">
        <table class="table table-bordered">
    		<thead>
    			<tr>
    				<td class="text-center" width="40%">
    					<label for="" class="control-label">{{__('Product')}}</label>
    				</td>
                    <td class="text-center">
    					<label for="" class="control-label">{{__('Base Price')}}</label>
    				</td>
    				<td class="text-center">
    					<label for="" class="control-label">{{__('Country')}}</label>
    				</td>
    				<td class="text-center">
    					<label for="" class="control-label">{{__('Discount')}}</label>
    				</td>
                    <td>
                        <label for="" class="control-label">{{__('Discount Type')}}</label>
                    </td>
    			</tr>
    		</thead>
    		<tbody>
                @foreach ($product_ids as $key => $id)
                	@php
                        $productCountry = DB::table('product_countries')->find($id);
                		$product = \App\Product::find($productCountry->product_id);
                		$country = \App\Country::find($productCountry->country_id);
                	@endphp
                		<tr>
                			<td>
                                <div class="col-sm-3">
                                <img class="img-md" src="{{ asset($product->thumbnail_img)}}" alt="Image">
                                </div>
                                <div class="col-sm-9">
                				<label for="" class="control-label">{{ __($product->name_en) }}</label>
                                </div>
                			</td>
                            <td>
                				<label for="" class="control-label">{{ $productCountry->unit_price }}</label>
                			</td>
                            <td>
                				<label for="" class="control-label">{{ $country->name_en }}</label>
                			</td>
                			<td>
                				<input type="number" name="discount_{{ $id }}" value="{{ $product->discount }}" min="0" step="1" class="form-control" required>
                			</td>
                            <td>
                                <select class="select2" name="discount_type_{{ $id }}">
                                    <option value="amount">LE</option>
                                    <option value="percent">%</option>
                                </select>
                            </td>
                		</tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
