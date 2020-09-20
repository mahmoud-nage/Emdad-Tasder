<?php

namespace App\Http\Controllers\API;

use App\Cart;
use App\PromoCode;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PromoCodeController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'code' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 500);
        }
        $user = User::find($request->input('user_id'));
        $promo_code = PromoCode::where('code', $request->input('code'))->first();
        $today_date = Carbon::now()->toDateString();
        if (isset($promo_code)) {
            $old_price = array_sum(Cart::where('user_id', $request->input('user_id'))->pluck('price')->toArray());
            if ($today_date >= $promo_code->start_date && $today_date <= $promo_code->end_date) {
                if (!$user->promos->contains($promo_code)) {
                    if ($old_price >= $promo_code->min_amount) {
                        if (isset($promo_code->max_users) && $promo_code->users()->count() < $promo_code->max_users) {
                            $user->promos()->attach($promo_code, ['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
                            if ($promo_code->discount_type == 'percentage') {
                                $price = $old_price - $old_price * ($promo_code->discount / 100);
                            } else {
                                $price = $old_price - $promo_code->discount;
                            }
                            $discount_type = $promo_code->discount_type == 'percentage' ? '%' : 'EGP';
                            $discount = $promo_code->discount . ' ' . $discount_type;
                            return response()->json(['status' => 200, 'data'=> $promo_code, 'message' => 'Done successfully', 'price' => $price, 'code' => $promo_code->code,
                                'discount' => $discount]);
                        }
                        return response()->json(['status' => 400, 'message' => 'Exceeded limits']);
                    }
                    return response()->json(['status' => 400, 'message' => 'The amount should be more than ' . $promo_code->min_amount]);
                }
                return response()->json(['status' => 400, 'message' => 'used before']);
            }
            return response()->json(['status' => 400, 'message' => 'Expired Code']);
        }
        return response()->json(['status' => 400, 'message' => 'Wrong Code']);
    }
}
