<?php

namespace App\Http\Controllers\API\Admin;

use App\Affiliate;
use App\CouponAffiliate;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AffiliateController extends Controller
{
    public function index(Request $request)
    {
        $data = Affiliate::with('User')->latest()->paginate(30);
        return response()->json(['status' => 200 , 'data' => $data]);
    }

    public function show($id)
    {
        $data = Affiliate::find($id);
        return response()->json(['status' => 200 , 'data' => $data]);
    }

    public function update($id,Request $request)
    {
        $affiliate = Affiliate::find($id);
        if ($request->input('is_approved')){
            $affiliate->is_approved == 1 ? $affiliate->is_approved = 0 : $affiliate->is_approved = 1;
            if ($affiliate->is_approved == 0)
            {
                $coupon = CouponAffiliate::where('affiliate_id' , $id)->first();
                if ($coupon == null){
                    CouponAffiliate::create([
                        'affiliate_id' => $id,
                        'code' => 'coupon-'.rand(50000,100000),
                    ]);
                }
            }
            $affiliate->update();
        }
        if ($request->input('is_blocked')){
            $affiliate->is_blocked == 1 ? $affiliate->is_blocked = 0 : $affiliate->is_blocked = 1;
            $affiliate->update();
        }
        return response()->json(['status' => 200 , 'message' => 'Updated Successfully']);
    }
    public function destroy($id,Request $request)
    {
        $affiliate = Affiliate::find($id);
        User::where('id' , $affiliate->user_id)->delete();
        Affiliate::where('id' , $id)->delete();
    }
}
