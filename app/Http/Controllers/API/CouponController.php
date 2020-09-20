<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Product;
use App\Variation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    public function validateCoupon(Request $request)
    {
        //dd("coupon");
        $rules = [
            'coupon' => 'required|unique:coupon_affiliates,code',
        ];
        $data['status'] = "fail";

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $data['errors'] = $validator->errors();
        } else {
            $data['status'] = "success";
        }
        return $data;
    }  public function validateCoupon2(Request $request)
    {
        dd("coupon2");
        $rules = [
            'coupon' => 'required|unique:coupon_affiliates,code',
        ];
        $data['status'] = "fail";

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $data['errors'] = $validator->errors();
        } else {
            $data['status'] = "success";
        }
        return $data;
    }

    public function addToCart(Request $request)
    {
        dd('addtocart');
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'product_id' => 'required',
            'options' => 'nullable',
            'amount' => 'required',
        ]);

        $product = Product::find($request->product_id);
        $product_country = \Illuminate\Support\Facades\DB::table('product_countries')->where('product_id' , $product->id)->where('country_id' ,get_country()->id)->first();

        $data = array();
        $data['id'] = $product->id;
        $str = '';
        $tax = 0;

        $chosen_variation = null;
        if ($request->input('options')){
            $options = $request->input('options');
            $case = false;

            if (count($options) > 0) {
                $product_variations = Variation::where('product_id' , $product->id)->where('product_country_id' , get_country()->id)->get();
                foreach ($product_variations as $variation) {
                    $arr = json_decode($variation->choices_values);
                    foreach ($options as $option) {
                        $case = in_array($option, $arr);
                    }
                    if ($case == true){
                        $chosen_variation = $variation;
                        break;
                    }
                }
            }
        }

        if($chosen_variation != null){
            $variations = $chosen_variation;
            $data['variations'] = $variations->id;
            $price = $variations->price;
            if($variations->qty >= $request['quantity']){
                // $variations->$str->qty -= $request['quantity'];
                // $product->variations = json_encode($variations);
                // $product->save();
            }
            else{
                return view('frontend.partials.outOfStockCart');
            }
        }
        else{
            $price = $product_country->unit_price;
        }

        //discount calculation based on flash deal and regular discount
        //calculation of taxes
        $flash_deal = \App\FlashDeal::where('status', 1)->first();
        if ($flash_deal != null && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first() != null) {
            $flash_deal_product = \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first();
            if($flash_deal_product->discount_type == 'percent'){
                $price -= ($price*$flash_deal_product->discount)/100;
            }
            elseif($flash_deal_product->discount_type == 'amount'){
                $price -= $flash_deal_product->discount;
            }
        }
        else{
            if($product->discount_type == 'percent'){
                $price -= ($price*$product->discount)/100;
            }
            elseif($product->discount_type == 'amount'){
                $price -= $product->discount;
            }
        }

        if($product->tax_type == 'percent'){
            $price += ($price*$product->tax)/100;
        }
        elseif($product->tax_type == 'amount'){
            $price += $product->tax;
        }

        $options = $request->input('options');
        if (isset($options)&&!is_null($options)){
            foreach ($request->input('options') as $key => $option) {
                $data['choice_'.$key] = $option;
            }
        }
        $data['quantity'] = $request['quantity'];
        $data['price'] = $price;
        $data['tax'] = $tax;
        if($request->session()->has('cart')){
            $cart = $request->session()->get('cart', collect([]));
            $cart->push($data);
        }
        else{
            $cart = collect([$data]);
            $request->session()->put('cart', $cart);
        }

        return response()->json(['status' => 200, 'message' => 'Added to cart']);
    }
}
