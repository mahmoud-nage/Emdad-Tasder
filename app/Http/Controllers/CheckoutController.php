<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\City;
use App\Zone;
use App\Order;
use App\Coupon;
use App\Address;
use App\Category;
use App\CouponUsage;
use App\CouponAffiliate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\AcceptCardController;
use App\Http\Controllers\AcceptValUController;
use App\Http\Controllers\AcceptKioskController;

class CheckoutController extends Controller
{

    public function __construct()
    {
        //
    }

    //check the selected payment gateway and redirect to that controller accordingly
    public function checkout(Request $request)
    {
        $this->validate(request(), [
            'payment_option' => 'required',
        ]);

        $country = session()->get('country');

        $orderController = new OrderController;
        $orderController->store($request);

        $request->session()->put('payment_type', 'cart_payment');

        if ($request->session()->get('order_id') != null) {
            $order = Order::findOrFail($request->session()->get('order_id'));
            if ($request->payment_option == 'accept_card') {
                $accept_card = new AcceptCardController;
                $token = $accept_card->payment($request->session()->get('order_id'));
                return view('frontend.payment.AcceptCard', compact('token'));
            } elseif ($request->payment_option == 'accept_kiosk') {
                $accept_kiosk = new AcceptKioskController();
                $response = $accept_kiosk->payment($request->session()->get('order_id'));
                return view('frontend.track_order', compact('response', 'order'));
            } elseif ($request->payment_option == 'accept_valu') {
                $accept_valu = new AcceptValUController();
                $response = $accept_valu->payment($request->session()->get('order_id'));
                return view('frontend.track_order', compact('response', 'order'));
            } elseif ($request->payment_option == 'cash_on_delivery') {
                foreach ($order->orderDetails as $key => $orderDetail) {
                    if ($orderDetail->product->user->user_type == 'seller') {
                        $seller = $orderDetail->product->user->seller;
                        $seller->admin_to_pay = $seller->admin_to_pay - ($orderDetail->price - $orderDetail->commission);
                        $seller->save();
                    }
                }
                $request->session()->put('cart_' . $country, collect([]));
                $request->session()->forget('order_id');
                flash("Your order has been placed successfully")->success();
                return redirect()->route('orders.track',['country' => get_country()->code,'order_id'=> $order->code]);
            }
        }
    }

    //redirects to this method after a successfull checkout
    public function checkout_done($country, $order_id, $payment)
    {
        $order = Order::findOrFail($order_id);
        $order->payment_status = 'paid';
        $order->payment_details = $payment;
        $order->save();
        foreach ($order->orderDetails as $key => $orderDetail) {
            $orderDetail->payment_status = 'paid';
            $orderDetail->save();
            if ($orderDetail->product->user->user_type == 'seller') {
                $seller = $orderDetail->product->user->seller;
                $seller->admin_to_pay = $seller->admin_to_pay + ($orderDetail->price - $orderDetail->commission);
                $seller->save();
            }
        }
        $country = session()->get('country');
        Session::put('cart_' . $country, collect([]));
        Session::forget('order_id');
        Session::forget('payment_type');

        flash(__('Payment completed'))->success();
        return redirect()->route('home');
    }

    public function get_shipping_info(Request $request,$country)
    {
        $country = session()->get('country');
        if (Session::has('cart_' . $country) && count(Session::get('cart_' . $country)) > 0) {
            $categories = Category::all();
            return view('frontend.shipping_info', compact('categories'));
        }
        flash(__('Your cart is empty'))->success();
        return back();
    }

    public function store_shipping_info(Request $request,$country)
    {
        $this->validate(request(), [
            'old_address' => 'required_without_all:address_details,building_no,floor_no,apartment_no,country,phone,city',
            'name' => 'required_without:old_address',
            'address_details' => 'required_without:old_address',
            'building_no' => 'required_without:old_address',
            'floor_no' => 'required_without:old_address',
            'apartment_no' => 'required_without:old_address',
            'country' => 'required_without:old_address',
            'phone' => 'required_without:old_address|min:8',
            'city' => 'required_without:old_address',
        ]);

        // dd($request->all());
            $data['email'] = auth()->user()->email;
        if ($request->old_address) {
            $old_address = Address::find($request->old_address);
            $data['name'] = $old_address->name;
            // $zone = $old_address->zone_id?$old_address->Zone['name_'.app()->getLocale()]:'';
            $data['address_id'] = $old_address->id;
            $data['address_details'] = $old_address->address_details;
            $data['building_no'] = $old_address->building_no;
            $data['floor_no'] = $old_address->floor_no;
            $data['apartment_no'] = $old_address->apartment_no;
            $data['city'] = $old_address->city_id;
            $data['area'] = $old_address->area_id;
            $data['zone'] = $old_address->zone_id;
            $data['postal_code'] = $old_address->postal_code;
            $data['phone'] = $old_address->phone;
            $data['country'] = $old_address->City->country['name_' . app()->getLocale()];
            $data['delivery_price'] = $old_address->City->delivery_price;

        } else {
            $data['name'] = $request->name;

            // $zone = isset($request->zone)&&$request->zone?Zone::find($request->zone)['name_'.app()->getLocale()]:'';
            $data['address_details'] = $request->address_details;
            $data['building_no'] = $request->building_no;
            $data['floor_no'] = $request->floor_no;
            $data['apartment_no'] = $request->apartment_no;
            $data['city'] = $request->city;
            $data['area'] = $request->area;
            $data['zone'] = '';
            $data['postal_code'] = $request->postal_code;
            $data['phone'] = $request->phone;
            $data['country'] = $request->country;
            $data['delivery_price'] = City::find($request->city)->delivery_price;
            
            $address = Address::create([
                'address_details' => $request->address_details,
                'apartment_no' => $request->apartment_no,
                'country_id' => get_country()->id,
                'building_no' => $request->building_no,
                'floor_no' => $request->floor_no,
                'city_id' => $request->city,
                'postal_code' => $request->postal_code,
                'phone' => $request->phone,
                'user_id' => auth()->user()->id,
                'name' => $request->name,
                ]);
                $data['address_id'] = $address->id;

        }
        
        $data['checkout_type'] = $request->checkout_type;
        
        $shipping_info = $data;
        $request->session()->put('shipping_info', $shipping_info);

        $subtotal = 0;
        $tax = 0;
        $shipping = 0;
        $country = session()->get('country');

        foreach (Session::get('cart_' . $country) as $key => $cartItem) {
            $subtotal += $cartItem['price'] * $cartItem['quantity'];
            $tax += $cartItem['tax'] * $cartItem['quantity'];
        }

        $total = $subtotal + $tax + $shipping;

        if (Session::has('coupon_discount')) {
            $total -= Session::get('coupon_discount');
        }

        return view('frontend.payment_select', compact('total'));
    }

    public function get_payment_info(Request $request)
    {
        $subtotal = 0;
        $tax = 0;
        $shipping = 0;
        $country = session()->get('country');
        
        if(!Session::has('cart_' . $country)){
            flash(__('messages.empty_cart'))->error();
             return redirect()->route('home' , $country);
        }

        foreach (Session::get('cart_' . $country) as $key => $cartItem) {
            $subtotal += $cartItem['price'] * $cartItem['quantity'];
            $tax += $cartItem['tax'] * $cartItem['quantity'];

        }

        $total = $subtotal + $tax + $shipping;

        if (Session::has('coupon_discount')) {
            $total -= Session::get('coupon_discount');
        }

        return view('frontend.payment_select', compact('total'));
    }

    public function apply_coupon_code(Request $request)
    {
        $this->validate(request(), [
            'code' => 'required',
        ]);

        $coupon = Coupon::where('code', $request->code)->first();
        $coupon_affiliate = CouponAffiliate::where('code', $request->code)->first();

        if ($coupon != null) {
            if (strtotime(date('d-m-Y')) >= $coupon->start_date && strtotime(date('d-m-Y')) <= $coupon->end_date) {
                if (CouponUsage::where('user_id', Auth::user()->id)->where('coupon_id', $coupon->id)->first() == null) {

                    $coupon_details = json_decode($coupon->details);

                    if ($coupon->type == 'cart_base') {
                        $subtotal = 0;
                        $tax = 0;
                        $shipping = 0;
                        $country = session()->get('country');

                        foreach (Session::get('cart_' . $country) as $key => $cartItem) {
                            $subtotal += $cartItem['price'] * $cartItem['quantity'];
                            $tax += $cartItem['tax'] * $cartItem['quantity'];
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
                            $request->session()->put('coupon_id', $coupon->id);
                            $request->session()->put('coupon_discount', $coupon_discount);
                            Session::flash('alert-success', 'Coupon has been applied');
                        } else {
                            Session::flash('alert-warning', 'Sorry!, Minimum Coupon has ' . $coupon_details->min_buy . ' pounds.');
                        }
                    } elseif ($coupon->type == 'product_base') {
                        $coupon_discount = 0;
                        foreach (Session::get('cart_' . $country) as $key => $cartItem) {
                            foreach ($coupon_details as $key => $coupon_detail) {
                                if ($coupon_detail->product_id == $cartItem['id']) {
                                    if ($coupon->discount_type == 'percent') {
                                        $coupon_discount += $cartItem['price'] * $coupon->discount / 100;
                                    } elseif ($coupon->discount_type == 'amount') {
                                        $coupon_discount += $coupon->discount;
                                    }
                                }
                            }
                        }
                        $request->session()->put('coupon_id', $coupon->id);
                        $request->session()->put('coupon_discount', $coupon_discount);
                        Session::flash('alert-success', 'Coupon has been applied');
                    }
                } else {
                    Session::flash('alert-warning', 'You already used this coupon!');
                }
            } else {
                Session::flash('alert-danger', 'Coupon expired!');
            }
        } elseif ($coupon_affiliate != null) {
            if ($coupon_affiliate->Affiliate->is_approved == 1) {
            }
        } else {
            Session::flash('alert-danger', 'Invalid coupon!');
        }
        return back();
    }

    public function remove_coupon_code(Request $request)
    {
        $request->session()->forget('coupon_id');
        $request->session()->forget('coupon_discount');
        return back();
    }
}
