<?php

namespace App\Http\Controllers\Affiliate;

use App\CouponAffiliate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    public function create()
    {
        $coupon = CouponAffiliate::where('affiliate_id', auth()->user()->Affiliate->id)->first();
        return view('affiliate.coupon.create',compact('coupon'));
    }

    public function store(Request $request)
    {
        $rules = [
            'coupon' => 'required|unique:coupon_affiliates,code',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        } else {
            $couponAffiliate = CouponAffiliate::where('code', $request->coupon)->get();
            if (isset($couponAffiliate) && !is_null($couponAffiliate)) {

            } else {

            }
        }

    }
}
