<?php

namespace App\Http\Controllers\API;

use App\Cart;
use App\Size;
use App\Order;
use App\Coupon;
use App\User;
use App\Option;
use App\Address;
use App\Product;
use App\Setting;
use App\Category;
use App\FlashDeal;
use App\PromoCode;
use App\Variation;
use App\SeoSetting;
use App\CouponUsage;
use App\OrderDetail;
use App\FlashDealProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'product_id' => 'required|exists:products,id',
            'amount' => 'required',
            'country_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 200);
        }

        $product = Product::find($request->product_id);
        $product_country = \Illuminate\Support\Facades\DB::table('product_countries')->where('product_id', $product->id)->where('country_id', $request->country_id)->first();

        $data = array();
        $data['product_id'] = $product->id;
        $data['user_id'] = $request->user_id;

        $str = '';
        $tax = 0;
        $price = 0;

        $chosen_variation = null;
        if ($request->input('options')) {
            $options = $request->input('options');
            $case = false;

            if (count($options) > 0) {

                $data['option_id'] = json_encode($options);

                $product_variations = Variation::where('product_id', $product->id)->where('product_country_id', $request->country_id)->get();
                foreach ($product_variations as $variation) {
                    $arr = json_decode($variation->choices_values);
                    foreach ($options as $option) {

                        $op = (int)$option;
                        if (in_array($op, $arr)) {
                            $case++;
                        }
                    }
                    if ($case == count($arr)) {
                        $chosen_variation = $variation;
                        break;
                    } else {
                        $case = 0;
                    }
                }
            }
        }

        if ($chosen_variation != null) {
            $variations = $chosen_variation;
            $data['variation_id'] = $variations->id;
            $price = $variations->price;
            if ($variations->qty >= $request['amount']) {
            } elseif ($product->main_quantity >= $request['amount']) {
            } else {
                return response()->json(['status' => 500, 'message' => 'This item is out of stock!'], 200);
            }
        } else {
            $price = $product_country->unit_price;
            if ($product->main_quantity >= $request['amount']) {

            } else {
                return response()->json(['status' => 500, 'message' => 'This item is out of stock!'], 200);
            }
        }


        //discount calculation based on flash deal and regular discount
        //calculation of taxes
        $flash_deal = \App\FlashDeal::where('status', 1)->first();
        if ($flash_deal != null && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first() != null) {
            $flash_deal_product = \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first();
            if ($flash_deal_product->discount_type == 'percent') {
                $price -= ($price * $flash_deal_product->discount) / 100;
            } elseif ($flash_deal_product->discount_type == 'amount') {
                $price -= $flash_deal_product->discount;
            }
        } else {
            if ($product_country->discount_type == 'percent') {
                $price -= ($price * $product_country->discount) / 100;
            } elseif ($product_country->discount_type == 'amount') {
                $price -= $product_country->discount;
            }
        }

        if ($product_country->tax_type == 'percent') {
            $price += ($price * $product_country->tax) / 100;
            $tax = round((($price * $product_country->tax) / 100), 2);
        } elseif ($product_country->tax_type == 'amount') {
            $price += $product_country->tax;
            $tax = $product_country->tax;
        }
        $data['amount'] = $request['amount'];
        $data['price'] = $price;
        $data['tax'] = $tax;
        $cart = Cart::create($data);
        return response()->json(['status' => 200, 'message' => 'Added to cart'], 200);
    }

    public function getMyCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 500);
        }

        $lang = 'ar';
        if (!is_null($request->header('lang'))) {
            $lang = $request->header('lang');
        }

        $column = $lang == 'ar' ? 'name_ar' : 'name_en';
        $column_des = $lang == 'ar' ? 'description_ar' : 'description_en';
        $carts = Cart::where('user_id', $request->input('user_id'))->get()->toArray();
        $count = count($carts);

        for ($i = 0; $i < $count; $i++) {
            $product = Product::where('products.id', $carts[$i]['product_id'])
                ->join('product_countries', 'products.id', '=', 'product_countries.product_id')
                ->where('product_countries.country_id', $request->input('country_id'))
                ->select('products.id as id', $column . ' as name', 'products.thumbnail_img', 'products.featured_img',
                    'products.flash_deal_img', $column_des . ' as description', 'product_countries.unit_price', 'product_countries.discount',
                    'product_countries.discount_type', 'products.category_id', 'products.rating')->first();
            $category = Category::where('id', $product->category_id)->first();
            $product->categoryName = $lang == 'ar' ? $category->name_ar : $category->name_en;
            $carts[$i]['product'] = $product;
        }
        return response()->json(['status' => 200, 'cart' => $carts]);
    }

    public function destroy(Request $request)
    {
        Cart::where('user_id', $request->input('user_id'))->where('product_id', $request->input('product_id'))->delete();
        return response()->json(['status' => 200, 'message' => 'Removed Successfully']);
    }

    public function removeFromCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_token' => 'required|exists:users,api_token',
            'user_id' => 'required|exists:users,id',
            'cart_id' => 'required|exists:carts,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 500);
        }
        $cart = Cart::where('id', $request->input('cart_id'))->where('user_id', $request->input('user_id'))->first();
//        dd($cart);
        $cart->delete();
        return response()->json(['status' => 200, 'message' => 'Deleted Successfully']);
    }

    public function updateMyCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_token' => 'required|exists:users,api_token',
            'user_id' => 'required|exists:users,id',
            'cart_id' => 'required|exists:carts,id',
            'product_id' => 'required|exists:products,id',
            'options.*' => 'required|exists:options,id',
            'amount' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 500);
        }

        $chosen_variation = null;
        $cartObject = $request->except('api_token');
        if ($request->input('options')) {
            $options = $request->input('options');
            if (count($options) > 0) {
                $cartObject['option_id'] = json_encode($cartObject['options']);
                unset($cartObject['options']);
            }
        }
        $cart = Cart::where('id', $cartObject['cart_id'])->first();
        $cart->update($cartObject);
        return response()->json(['status' => 200, 'message' => 'Updated succefully']);
    }

    public function checkout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_token' => 'required|exists:users,api_token',
            'user_id' => 'required|exists:users,id',
            'address_id' => 'required|exists:addresses,id',
            'promo_code' => 'nullable|exists:coupons,code',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 200);
        }

        // create new order for user using his cart info
        // remove user cart
        $lang = 'ar';
        if (!is_null($request->header('lang'))) {
            $lang = $request->header('lang');
        }


        $column = $lang == 'ar' ? 'name_ar' : 'name_en';
        $column_des = $lang == 'ar' ? 'description_ar' : 'description_en';

        $carts = Cart::where('user_id', $request->input('user_id'))->get()->toArray();
        $count = count($carts);


        $address = Address::where('id', $request->input('address_id'))->first();

        $order = new Order;
        $order->payment_type = $request->payment_option;
        $order->payment_status = $request->payment_status;

        $order->address_id = $request->input('address_id');  //ok

        $order->shipping_address = json_encode($address);  // ok

        $order->user_id = $request->input('user_id');  // ok
        $order->code = date('Ymd-his');
        $order->date = strtotime('now');
        $order->discount_points = 0;

        $shipping = $address->city_id ? $address->City->delivery_price : 0;
        $order->delivery = "" . $shipping;

        $subtotal = 0;
        $tax = 0;
        foreach ($carts as $key => $cartItem) {
            $product = Product::find($cartItem['product_id']);
            $subtotal += $cartItem['price'] * $cartItem['amount'];
            $tax += $cartItem['tax'] * $cartItem['amount'];

            if (isset($cartItem['variation_id']))
                $product_variation = $cartItem['variation_id'];
            if (isset($product_variation) && !is_null($product_variation)) {
                $variations = Variation::find($product_variation);
                if (isset($variations) && !is_null($variations)) {

                }
            }
            $order_detail = new OrderDetail;
            $order_detail->order_id = $order->id;
            $order_detail->seller_id = $product->user_id;
            $order_detail->product_id = $product->id;
            if (isset($product_variation)) {
                $order_detail->variation_id = $product_variation;
            } else {
                $order_detail->variation_id = null;
                $product->main_quantity -= $cartItem['amount'];
            }
            $order_detail->price = $cartItem['price'] * $cartItem['amount'];
            $order_detail->commission = round(($cartItem['price'] * $cartItem['amount'] * ($product->category->vendor_commission / 100)), 2);

            $order_detail->tax = round($cartItem['tax'] * $cartItem['amount'], 2);

            $order_detail->shipping_cost = round($shipping, 2);
            $order_detail->quantity = $cartItem['amount'];
            $product->num_of_sale++;
            $order->OrderDetails[] = $order_detail;
        }

        $order->grand_total = $subtotal + $tax + $shipping;
        $order->sub_total = $subtotal;
        $coupon_discount = 0;
        if ($request->has('promo_code') && !is_null($request->promo_code)) {
            $coupon = Coupon::where('code', $request->promo_code)->first();
            if ($coupon->discount_type == 'amount') {
                $coupon_discount = $coupon->discount;
                $order->grand_total -= $coupon_discount;
            } else if ($coupon->discount_type == 'percent') {
                $coupon_discount = round(($subtotal * ($coupon->discount / 100)), 2);
                $order->grand_total -= $coupon_discount;
            }
        }
        $order->promo_code_discount = $coupon_discount;
        $order->tax = $tax;
        if ($order->grand_total < 0) {
            $order->grand_total = 0;
        }
        $order->status = 200;
        return response()->json($order);

    }

    public function confirmCheckout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_token' => 'required|exists:users,api_token',
            'user_id' => 'required|exists:users,id',
            'address_id' => 'required|exists:addresses,id',
            'promo_code' => 'nullable|exists:coupons,code',
            'payment_option' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 200);
        }


        $orderController = new OrderController;
        $order = $orderController->store($request);
        if ($order == 'cart Empty') {
            return response()->json(['status' => 500, 'message' => 'Your Cart Is Empty'], 200);
        }
        if ($order->count() > 0) {
            if ($request->payment_option == 'accept_card') {
                $accept_card = new \App\Http\Controllers\AcceptCardController;
                $token = $accept_card->payment($order->id);
                $call_back = "https://newfaceeg.com/weaccept/payment/callback";
                $ifram = "https://accept.paymobsolutions.com/api/acceptance/iframes/27011?payment_token=" . $token;
                $data = [
                    'response' => $ifram
                ];
                return response()->json(['status' => 200, 'message' => 'Order Created Successfully', 'data' => $data], 200);
            } elseif ($request->payment_option == 'accept_kiosk') {
                $accept_kiosk = new \App\Http\Controllers\AcceptKioskController();
                $response = $accept_kiosk->payment($order->id);
                $data = [
                    'response' => $response
                ];
                return response()->json(['status' => 200, 'message' => 'Order Created Successfully', 'data' => $data], 200);
            } elseif ($request->payment_option == 'accept_valu') {
                $accept_valu = new \App\Http\Controllers\AcceptValUController();
                $response = $accept_valu->payment($order->id);
                $data = [
                    'response' => $response
                ];
                return response()->json(['status' => 200, 'message' => 'Order Created Successfully', 'data' => $data], 200);
            } elseif ($request->payment_option == 'cash_on_delivery') {
                foreach ($order->orderDetails as $key => $orderDetail) {
                    if ($orderDetail->product->user->user_type == 'seller') {
                        $seller = $orderDetail->product->user->seller;
                        $seller->admin_to_pay = $seller->admin_to_pay - ($orderDetail->price - $orderDetail->commission);
                        $seller->save();
                    }
                }
                $data = [
                    'order' => $order,
                ];
                return response()->json(['status' => 200, 'message' => 'Order Created Successfully', 'data' => $data], 200);
            }
        } else {
            return response()->json(['status' => 500, 'message' => 'This Order has not been found on our system'], 200);
        }
    }

    public function checkPromoCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_token' => 'required',
            'code' => 'required|exists:coupons,code',
        ]);
        $lang = 'ar';
        if (!is_null($request->header('lang'))) {
            $lang = $request->header('lang');
        }
        if ($validator->fails()) {
            $arMsg = "كوبون غير صالح للاستخدام";
            $enMsg = "Invalid coupon";
            $message = $lang == 'ar' ? $arMsg : $enMsg;
            return response()->json(['status' => 400, 'message' => $message]);
        }
        $user = User::where('api_token', $request->input('api_token'))->first();
        $cart = Cart::where('user_id', $user->id)->get();
        $coupon = Coupon::where('code', $request->input('code'))->first();
        if (strtotime(date('d-m-Y')) >= $coupon->start_date && strtotime(date('d-m-Y')) <= $coupon->end_date) {
            if (CouponUsage::where('user_id', $user->id)->where('coupon_id', $coupon->id)->first() == null) {
                $coupon_details = json_decode($coupon->details);
                if ($coupon->type == 'cart_base') {
                    $subtotal = 0;
                    $tax = 0;
                    $shipping = 0;
                    foreach ($cart as $key => $cartItem) {
                        $PD = DB::table('product_countries')->where('country_id', 1)->where('product_id', $cartItem->product_id)->first();
                        $subtotal += $PD->purchase_price * $cartItem->amount;
                        $tax += $PD->tax * $cartItem->amount;
                    }
                    $sum = $subtotal + $tax + $shipping;
                    if ($sum > $coupon_details->min_buy) {
                        if ($coupon->discount_type == 'percent') {
                            $coupon_discount = ($sum * $coupon->discount) / 100;
                            if ($coupon_discount > $coupon_details->max_discount) {
                                $coupon_discount = $coupon_details->max_discount;
                            }
                        } elseif ($coupon->discount_type == 'amount') {
                            $coupon_discount = $coupon->discount;
                        }
                        $message = $lang == 'ar' ? 'كوبون صالح للاستخدام' : 'Valid coupon';
                        return response()->json(['status' => 200, 'message' => $message], 200);
                    }
                } elseif ($coupon->type == 'product_base') {
                    $coupon_discount = 0;
                    foreach ($cart as $key => $cartItem)
                        foreach ($coupon_details as $key => $coupon_detail) {
                            if ($coupon_detail->product_id == $cartItem->product_id) {
                                $message = $lang == 'ar' ? 'كوبون صالح للاستخدام' : 'Valid coupon';
                                return response()->json(['status' => 200, 'message' => $message], 200);
                            }
                        }
                }

            } else {
                $arMsg = "كوبون غير صالح للاستخدام";
                $enMsg = "Unvalid coupon";
                $message = $lang == 'ar' ? $arMsg : $enMsg;
                return response()->json(['status' => 400, 'message' => $message], 200);
            }
        } else {
            $arMsg = "كوبون منتهي";
            $enMsg = "Expired coupon";
            $message = $lang == 'ar' ? $arMsg : $enMsg;
            return response()->json(['status' => 400, 'message' => $message], 200);
        }
        $message = $lang == 'ar' ? 'كوبون صالح للاستخدام' : 'Valid coupon';
        return response()->json(['status' => 200, 'message' => $message], 200);
    }
}
