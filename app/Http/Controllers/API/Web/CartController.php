<?php

namespace App\Http\Controllers\API\Web;

use App\Cart;
use App\Meal;
use App\Offer;
use App\Option;
use App\PromoCode;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $data = array();
        $session = request()->session()->get('cart');
        $sub = 0;
        $tax_percentage = 0;
        $tax = 0;
        $tax = 0;
        $total = 0;
        $option_price = 0;
        if ($request->input('user_id')) {
            $data = Cart::where('user_id', $request->input('user_id'))->with('Meal', 'Offer', 'User', 'Size', 'Option')->latest()->get();
            foreach ($data as $key => $item) {
                $option = Option::find($item->option_id);
                if (isset($option)) {
                    $option_price += $option->price * $item->quantity;
                }
            }
            $promo = DB::table('user_promos')->where('user_id', $request->input('user_id'))->where('is_used', 0)->pluck('promo_code_id')->toArray();
            $promo_code = PromoCode::whereIn('id', $promo)->first();
            $sub = Cart::where('user_id', $request->input('user_id'))->sum('price');
            $tax_percentage = Setting::find(1)->tax_percentage / 100;
            $tax = round($sub * $tax_percentage, 2);
            if (isset($promo_code)) {
                $old_price = $sub + $tax;
                if ($promo_code->discount_type == 'percentage') {
                    $total = $old_price - $old_price * ($promo_code->discount / 100);
                } else {
                    $total = $old_price - $promo_code->discount;
                }
            } else {
                $total = $sub + $tax;
            }
        } elseif (isset($session)) {
            $data = Cart::where('session_id', $session)->with('Meal', 'Offer', 'User', 'Size', 'Option')->latest()->get();
            foreach ($data as $key => $item) {
                $option = Option::find($item->option_id);
                if (isset($option)) {
                    $option_price += $option->price * $item->quantity;
                }
            }
            $tax_percentage = Setting::find(1)->tax_percentage / 100;
            $sub = array_sum(Cart::where('session_id', $session)->pluck('price')->toArray()) + $option_price;
            $tax = round($sub * $tax_percentage, 2);
            $total = $sub + $tax;
        }
        return response()->json(['status' => 200, 'data' => $data, 'sub_total' => $sub, 'total' => round($total, 2), 'tax' => $tax]);
    }

    public function store(Request $request)
    {
        $qty = $request->input('qty');
        if ($request->input('offer_id')) {
            $price = Offer::find($request->input('offer_id'))->price;
        } else {
            $price = DB::table('meal_sizes')->where('meal_id', $request->input('meal_id'))->where('size_id', $request->input('size_id'))->first()->price;
        }

        $meal = Meal::find($request->input('meal_id'));
        if (isset($meal)) {
            $point = $meal->Points;
        }
        $option = Option::find($request->input('option_id'));
        $option_price = isset($option) ? $option->price : 0;
        $session = request()->session()->get('cart');
        if ($request->input('user_id')) {
            Cart::create([
                'user_id' => $request->input('user_id'),
                'meal_id' => $request->input('meal_id'),
                'offer_id' => $request->input('offer_id'),
                'size_id' => $request->input('size_id'),
                'option_id' => $request->input('option_id'),
                'quantity' => $request->input('qty'),
                'notes' => $request->input('notes'),
                'price' => ($price * $qty) + ($qty *$option_price),
                'points' => isset($point) ? $point->amount : null,
            ]);
        } else if (isset($session)) {
            Cart::create([
                'session_id' => $session,
                'meal_id' => $request->input('meal_id'),
                'offer_id' => $request->input('offer_id'),
                'size_id' => $request->input('size_id'),
                'option_id' => $request->input('option_id'),
                'quantity' => $request->input('qty'),
                'notes' => $request->input('notes'),
                'price' => ($price * $qty) + ($qty *$option_price),
                'points' => isset($point) ? $point->amount : null,
            ]);
        } else {
            request()->session()->put('cart', uniqid());
            $session = request()->session()->get('cart');
            Cart::create([
                'session_id' => $session,
                'meal_id' => $request->input('meal_id'),
                'offer_id' => $request->input('offer_id'),
                'size_id' => $request->input('size_id'),
                'option_id' => $request->input('option_id'),
                'quantity' => $request->input('qty'),
                'notes' => $request->input('notes'),
                'price' => ($price * $qty) + ($qty *$option_price),
                'points' => isset($point) ? $point->amount : null,
            ]);
        }
        return response()->json(['status' => 200, 'message' => 'Added Successfully']);
    }

    public function destroy(Request $request)
    {
        if ($request->input('cart_id')) {
            Cart::where('id', $request->input('cart_id'))->delete();
        } else {
            if ($request->input('user_id')) {
                Cart::where('user_id', $request->input('user_id'))->delete();
            } elseif ($request->input('session_id')) {
                Cart::where('session_id', $request->input('session_id'))->delete();
            }
        }
        return response()->json(['status' => 200, 'message' => 'Deleted Successfully']);
    }
}
