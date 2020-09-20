<?php

namespace App\Http\Controllers\Affiliate;

use App\BusinessSetting;
use App\CouponUrl;
use App\Http\Controllers\Controller;
use App\Order;
use App\PaymentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/**
 * Class PaymentRequestController
 * package App\Http\Controllers\Affiliate
 */
class PaymentRequestController extends Controller
{

    public function index()
    {
        $currency = auth()->user()->Country->Currency->code;
        $data = $totalPaymentRequest = PaymentRequest::where('affiliate_id', auth()->user()->Affiliate->id)->get();;
        return view('affiliate.payment.index', compact(['data', 'currency']));
    }

    public function create()
    {
        $affiliateId = auth()->user()->Affiliate->id;
        $totalEarning = $this->totalEarning($affiliateId);
        $paymentRequests = PaymentRequest::where('affiliate_id', $affiliateId)->pluck("order_ids");
//        dd($paymentRequests);
        if (count($paymentRequests)>0)
        $orders = Order::where('payment_status', 'paid')->where('affiliate_id', $affiliateId)->whereNotIn('id', json_decode($paymentRequests->toArray()[0]))
            ->where("payment_request", 0)->with('CouponUrl')->get();
        else
            $orders = Order::where('payment_status', 'paid')->where('affiliate_id', $affiliateId)
                ->where("payment_request", 0)->with('CouponUrl')->get();
        $urls = CouponUrl::where('affiliate_id', $affiliateId)->first();
        $affiliate_percentage = BusinessSetting::where('type', 'affiliate_percentage')->first();
        $affiliate_max_discount = BusinessSetting::where('type', 'affiliate_max_discount ')->first();
        $egy_mail = BusinessSetting::where('type', 'egy_mail')->first();
        $paypal_payment = BusinessSetting::where('type', 'paypal_payment ')->first();
        $bank = BusinessSetting::where('type', 'bank ')->first();
        $paymentMethods = [];
        if ($bank->value == 1) {
            $paymentMethods["1"] = "Bank account";
        }
        if ($egy_mail->value == 1) {
            $paymentMethods["2"] = "Egyption Email";
        }
        if ($paypal_payment->value == 1) {
            $paymentMethods["3"] =  "Paypal";
        }
        return view('affiliate.payment.request_payment',
            compact(['totalEarning', 'orders', 'urls', 'affiliate_percentage', 'affiliate_max_discount','paymentMethods']));
    }

    public function store(Request $request)
    {
        /*
       Payhemt method  * "1"=>Bank account;        * "2" => Egyption Email;    * "3" => Paypal;
        */
        $totalEarning = $this->totalEarning(auth()->user()->Affiliate->id);
        $ordersGrandTotal = Order::whereIn('id', $request->order_ids)->sum('grand_total');
        $amount = 0;
        $affiliate_percentage = BusinessSetting::where('type', 'affiliate_percentage')->first();
//        foreach ($orders as $order) {
        $amount += $ordersGrandTotal * ($affiliate_percentage->value / 100);

//        }

        //calculate amount bu order_ids.
        if ($amount > $totalEarning['totalAvailableAmount']) {
            return redirect()->back()->withInput()->withErrors(["request_failed" => "You did not have suffient balance"]);
        }
        $payment_request = new PaymentRequest;
        $payment_request->affiliate_id = auth()->user()->Affiliate->id;
        $payment_request->amount = $amount;
        $payment_request->order_ids = json_encode($request->input('order_ids'));
        $payment_request->payment_method = $request->input('payment_method');
//        dd($payment_request->toArray());
        switch ($request->input("payment_method")) {
            case 1: //Bank payment method
                $payment_request->name = $request->input('national_name');
                $payment_request->national_id = $request->input('national_id');
                $payment_request->bank_name = $request->input('bank_name');
                $payment_request->banck_account_number = $request->input('bank_account_number');
                break;
            case 2://Egyption mail payment method
                $payment_request->name = $request->input('national_name');
                $payment_request->national_id = $request->input('national_id');
                break;
            case 3://Paypal payment method
                $payment_request->paypal_email = $request->input('paypal_email');
//                dd("3");
                break;
        }
        $payment_request->save();
        if (isset($payment_request->id) && !is_null($payment_request->id)) {
            Session::flash('success', 'Payment Requested succefully');
            return back();
        } else {
            Session::flash('fail', 'Payment Request failed');
            return redirect()->back()->withInput()->withErrors(["request_failed" => "Payment Request failed"]);
        }
    }

    public function totalEarning($affiliateId)
    {
        $totalEarning = ['totalAvailableAmount' => 0, 'totalpendingAmount' => 0, 'everyOrder' => []];
//        $urls = CouponUrl::where('affiliate_id', $affiliateId)->get();
//        $currency = auth()->user()->Country->Currency->code;
        $coupon = auth()->user()->Affiliate->Coupon;
        $affiliate_percentage = BusinessSetting::where('type', 'affiliate_percentage')->first();
        $affiliate_max_discount = BusinessSetting::where('type', 'affiliate_max_discount ')->first();
        if ($coupon->discount_type == "percent") {
            $totalOrders = Order::where('payment_status', 'paid')->where("payment_request", 0)
                ->where('affiliate_id', $affiliateId)->get('grand_total');
            foreach ($totalOrders as $order) {
                $orderProfit = $order->grand_total * ($affiliate_percentage->value / 100);
                if ($orderProfit > $affiliate_max_discount->value) {
                    $orderProfit = $affiliate_max_discount->value;
                }
                $totalEarning['totalAvailableAmount'] += $orderProfit;
            }
            $totalUnPaiedOrders = Order::where('payment_status', 'unpaid')->where('affiliate_id', $affiliateId)->get('grand_total');
            foreach ($totalUnPaiedOrders as $order) {
                $orderProfit = $order->grand_total * ($affiliate_percentage->value / 100);
                if ($orderProfit > $affiliate_max_discount->value) {
                    $orderProfit = $affiliate_max_discount->value;
                }
                $totalEarning['totalpendingAmount'] += $orderProfit;
            }
        } elseif ($coupon->discount_type == "amount") {
            $totalOrdersGrancount = Order::where('payment_status', 'paid')->where("payment_request", 0)->where('affiliate_id', $affiliateId)->count();
            $totalEarning['totalAvailableAmount'] += $totalOrdersGrancount * $coupon->discount;
            $totalUnPaiedOrdersSum = Order::where('payment_status', 'unpaid')->where('affiliate_id', $affiliateId)->count();
            $totalEarning['totalpendingAmount'] += $totalUnPaiedOrdersSum * $coupon->discount;
        }
        /* foreach ($urls as $url) {
            $coupon = Coupon::select('discount', 'discount_type')->where('id', $url->coupon_affiliate_id)->first();
            if ($coupon->discount_type == "percent") {
                $totalPaiedOrdersSum = Order::where('payment_status', 'paid')->where("payment_request", 0)
                    ->where('affiliate_id', $affiliateId)->where('coupon_url_id', $url->id)->sum('grand_total');;
                $totalEarning['totalAvailableAmount'] += $totalPaiedOrdersSum * ($coupon->discount / 100);
                $totalUnPaiedOrdersSum = Order::where('payment_status', 'unpaid')->where('affiliate_id', $affiliateId)->where('coupon_url_id', $url->id)->sum('grand_total');
                $totalEarning['totalpendingAmount'] += $totalUnPaiedOrdersSum * ($coupon->discount / 100);
            } elseif ($coupon->discount_type == "amount") {
                $totalPaiedOrdersSum = Order::where('payment_status', 'paid')->where("payment_request", 0)
                    ->where('affiliate_id', $affiliateId)->where('coupon_url_id', $url->id)->count();
                $totalEarning['totalAvailableAmount'] += $totalPaiedOrdersSum * $coupon->discount;
                $totalUnPaiedOrdersSum = Order::where('payment_status', 'unpaid')->where('affiliate_id', $affiliateId)->where('coupon_url_id', $url->id)->count();
                $totalEarning['totalpendingAmount'] += $totalUnPaiedOrdersSum * $coupon->discount;
            }
        }*/
        $totalPaymentRequest = PaymentRequest::where('affiliate_id', $affiliateId)->sum('amount');
        $totalEarning['totalAvailableAmount'] -= $totalPaymentRequest;
        if ($totalEarning['totalAvailableAmount'] < 0)
            $totalEarning['totalAvailableAmount'] = 0;
//        $totalEarning['totalAvailableAmount'] = $totalEarning['totalAvailableAmount'] . ' ' . $currency;
//        $totalEarning['totalpendingAmount'] = $totalEarning['totalpendingAmount'] . ' ' . $currency;
        return $totalEarning;
    }
}
