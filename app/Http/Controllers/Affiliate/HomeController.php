<?php

namespace App\Http\Controllers\Affiliate;

use App\CouponAffiliate;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $affiliateId = auth()->user()->Affiliate->id;
        $visits = 0;
        $affiliate = \App\Affiliate::find($affiliateId);
        $affiliate_coupon = \App\CouponAffiliate::where('affiliate_id', $affiliateId)->first();
        if (!is_null($affiliate_coupon)) {
            $visits = $affiliate_coupon->visits;
        }
        $currency = auth()->user()->Country->Currency->code;
        $totalOrders = \App\Order::where('affiliate_id', $affiliateId)->count();
        $totalConfirmedOrders = \App\Order::where('affiliate_id', $affiliateId)->where('payment_type', 'paid')->count();
        $totalPendingOrders = \App\Order::where('affiliate_id', $affiliateId)->whereIn('payment_type', ['unpaid', NULL])->count();
        $totalConfirmedOrdersSales = \App\Order::where('affiliate_id', $affiliateId)->where('payment_type', 'paid')->sum('grand_total') . ' ' . $currency;
        $totalPendedOrdersSales = \App\Order::where('affiliate_id', $affiliateId)->where('payment_type', 'unpaid')->sum('grand_total') . ' ' . $currency;
        $ctr = 0;
        if ($totalOrders > 0) {
            $ctr = bcdiv($totalConfirmedOrdersSales, $totalOrders);
        }
        $affiliate_coupon = CouponAffiliate::where('affiliate_id', $affiliateId)->first();
        return view('affiliate.index', compact(['visits', 'affiliate', 'affiliate_coupon', 'currency', 'totalOrders',
            'totalConfirmedOrders', 'totalPendingOrders', 'totalConfirmedOrdersSales', 'totalPendedOrdersSales', 'ctr', 'affiliate_coupon']));
    }
}
