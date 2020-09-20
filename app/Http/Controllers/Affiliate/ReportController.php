<?php

namespace App\Http\Controllers\Affiliate;

use App\CouponAffiliate;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function earnings(Request $request)
    {
        $data = array();
        $currency = auth()->user()->Country->Currency->code;
        $orders = Order::where('affiliate_id', auth()->user()->affiliate->id)->distinct()->pluck('created_at');
        foreach ($orders as $key => $order) {
            if (isset($orders[$key - 1]) && $order->toDateString() != $orders[$key - 1]->toDateString()) {
                $date = $order->toDateString();
            } else {
                if ($key == 0) {
                    $date = $order->toDateString();
                } else {
                    $date = $date;
                }
            }
            $data[] = [
                'date' => $date,
                'confirmed_earnings' => Order::where('payment_status', 'paid')->whereDate('created_at', $date)->sum('grand_total') . ' ' . $currency,
                'pending_earnings' => Order::where('payment_status', 'unpaid')->whereDate('created_at', $date)->sum('grand_total') . ' ' . $currency,
                'total_earnings' => Order::whereDate('created_at', $date)->sum('grand_total') . ' ' . $currency,
                'CTR' => CouponAffiliate::where('affiliate_id' , auth()->user()->affiliate->id)->whereDate('created_at', $date)->visits / Order::whereDate('created_at', $date)->count(),
            ];
        }
        return view('affiliate.reports.earnings', compact('data'));
    }

    public function orders(Request $request)
    {
        $data = array();
        $currency = auth()->user()->Country->Currency->code;
        $orders = Order::where('affiliate_id', auth()->user()->affiliate->id)->distinct()->pluck('created_at');
        foreach ($orders as $key => $order) {
            if (isset($orders[$key - 1]) && $order->toDateString() != $orders[$key - 1]->toDateString()) {
                $date = $order->toDateString();
            } else {
                if ($key == 0) {
                    $date = $order->toDateString();
                } else {
                    $date = $date;
                }
            }
            $data[] = [
                'date' => $date,
                'confirmed_orders' => Order::where('payment_status', 'paid')->whereDate('created_at', $date)->count(),
                'pending_orders' => Order::where('payment_status', 'unpaid')->whereDate('created_at', $date)->count(),
                'confirmed_earnings' => Order::where('payment_status', 'paid')->whereDate('created_at', $date)->sum('grand_total') . ' ' . $currency,
                'pending_earnings' => Order::where('payment_status', 'unpaid')->whereDate('created_at', $date)->sum('grand_total') . ' ' . $currency,
                'total_earnings' => Order::whereDate('created_at', $date)->sum('grand_total') . ' ' . $currency,
                'CTR' => CouponAffiliate::where('affiliate_id' , auth()->user()->affiliate->id)->whereDate('created_at', $date)->visits / Order::whereDate('created_at', $date)->count(),
            ];
        }
        return view('affiliate.reports.orders', compact('data'));
    }
}
