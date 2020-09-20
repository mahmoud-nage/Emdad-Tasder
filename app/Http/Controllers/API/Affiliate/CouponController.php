<?php

namespace App\Http\Controllers\Api\Affiliate;

use App\CouponAffiliate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{

    public function store(Request $request)
    {
        if ($flag == "share") {
            $rules = [
                'coupon' => 'required|unique:coupon_affiliates,code',
            ];
        }
        $validator = Validator::make($request->all(), $rules);
        $couponAffiliate = CouponAffiliate::where('code', $request->coupon)->get();
        if (isset($couponAffiliate) && !is_null($couponAffiliate)) {

        } else {

        }

    }

    public function validateCoupon(Request $request)
    {
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
}
