<?php

namespace App\Http\Controllers;

use App\Variation;
use Illuminate\Http\Request;
use App\Product;
use App\SubSubCategory;
use App\Category;
use Session;
use App\Color;

class CartController extends Controller
{
    public function index(Request $request)
    {
        //dd($cart->all());
        $categories = Category::all();
        return view('frontend.view_cart', compact('categories'));
    }

    public function showCartModal(Request $request)
    {
        $product = Product::find($request->id);
        return view('frontend.partials.addToCart', compact('product'));
    }

    public function updateNavCart(Request $request)
    {
        return view('frontend.partials.cart');
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->id);
        $product_country = \Illuminate\Support\Facades\DB::table('product_countries')->where('product_id' , $product->id)->where('country_id' ,get_country()->id)->first();

        $data = array();
        $data['id'] = $product->id;
        $str = '';
        $tax = 0;

        $chosen_variation = null;

        if ($request->input('options')){
            $options = $request->input('options');
            $case = 0;

            if (count($options) > 0) {
                $product_variations = Variation::where('product_id' , $product->id)->where('product_country_id' , get_country()->id)->get();
                foreach ($product_variations as $variation) {
                    $arr = json_decode($variation->choices_values);
                    foreach ($options as $option) {
                       
                         $op = (int)$option;
                        if(in_array($op , $arr)){
                            $case++ ;
                        }
                    }
                    if($case == count($arr)){
                        $chosen_variation = $variation;
                        break;
                    }else{
                        $case = 0;
                    }
                }
            }
        }
        

        if($chosen_variation != null){
            $variations = $chosen_variation;
            $data['variations'] = $variations->id;
            $price = $variations->price;
            if($variations->qty >= $request['quantity']){
            }else{
                return view('frontend.partials.outOfStockCart');
            }
        }
        else{
            $price = $product_country->unit_price;
            if($product->main_quantity >= $request['quantity']){
                
            }
            else{
                return view('frontend.partials.outOfStockCart');
            }
        }
        


        //discount calculation based on flash deal and regular discount
        //calculation of taxes
        $flash_deal = \App\FlashDeal::where('status', 1)->where('country_id', get_country()->id)->first();
        if ($flash_deal != null && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first() != null) {
            $flash_deal_product = \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first();
            if($flash_deal_product->discount_type == 'percent'){
                $price -= ($price*$flash_deal_product->discount)/100;
            }
            elseif($flash_deal_product->discount_type == 'amount'){
                $price -= $flash_deal_product->discount;
            }
        } else{
            if($product_country->discount_type == 'percent'){
                $price -= ($price*$product_country->discount)/100;
            }
            elseif($product_country->discount_type == 'amount'){
                $price -= $product_country->discount;
            }
        }
        
        if($product_country->tax_type == 'percent'){
            $price += ($price*$product_country->tax)/100;
            // $tax = ($price*$product_country->tax)/100;
        }
        elseif($product_country->tax_type == 'amount'){
            $price += $product_country->tax;
            //  $tax = $product_country->tax ;
        }
        
        $options = $request->input('options');
        if (isset($options)&&!is_null($options)){
            foreach ($request->input('options') as $key => $option) {
                $data['choice_'.$key] = $option;
            }
        }

        $country = session()->get('country');
        
        $data['quantity'] = $request['quantity'];
        $data['price'] = $price;
        $data['tax'] = $tax;
        if($request->session()->has('cart_'.$country)){
            $cart = $request->session()->get('cart_'.$country, collect([]));
            $cart->push($data);
        }
        else{
            $cart = collect([$data]);
            $request->session()->put('cart_'.$country, $cart);
        }
        return view('frontend.partials.addedToCart', compact('product', 'data'));
    }

    //removes from Cart
    public function removeFromCart(Request $request)
    {
        if($request->session()->has('cart_'.get_country()->code)){
            $cart = $request->session()->get('cart_'.get_country()->code, collect([]));
            $cart->forget($request->key);
            $request->session()->put('cart_'.get_country()->code, $cart);
        }

        return view('frontend.partials.cart_details');
    }

    //updated the quantity for a cart item
    public function updateQuantity(Request $request)
    {
        $cart = $request->session()->get('cart_'.session()->get('country'), collect([]));
        $cart = $cart->map(function ($object, $key) use ($request) {
            if($key == $request->key){
                $object['quantity'] = $request->quantity;
            }
            return $object;
        });
        
        $request->session()->put('cart_'.session()->get('country'), $cart);
        
if($request->ajax()){
  return response()->json(view('frontend.partials.cart_details'));
}else{
        return view('frontend.partials.cart_details');
}
    }
}
