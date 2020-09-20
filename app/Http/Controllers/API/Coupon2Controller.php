<?php

namespace App\Http\Controllers\Api\Affiliate;

use App\CouponAffiliate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Coupon2Controller extends Controller
{
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
