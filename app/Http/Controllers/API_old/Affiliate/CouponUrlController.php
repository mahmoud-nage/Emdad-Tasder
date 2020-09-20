<?php

namespace App\Http\Controllers\API\Affiliate;

use App\CouponUrl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponUrlController extends Controller
{
    public function index(Request $request)
    {
        $urls = CouponUrl::where('affiliate_id' , $request->input('affiliate_id'))->get();
        return response()->json(['data' => $urls]);
    }
}
