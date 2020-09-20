<?php

namespace App\Http\Controllers;

use App\Order;
use App\PaymentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class PaymentRequestController extends Controller
{
    public function index()
    {
        $currency = auth()->user()->Country->Currency->code;
//        $data = $totalPaymentRequest = PaymentRequest::select('*')->join('orders', 'orders.affiliate_id', '=', 'payment_requests.affiliate_id')
//            ->with("Affiliate")->get();
        $data = $totalPaymentRequest = PaymentRequest::all();
        return view('admin_payment.index', compact(['data', 'currency']));
    }

    public function show($id)
    {
        $currency = auth()->user()->Country->Currency->code;
        $paymentRequest = PaymentRequest::where('id', $id)->with('Affiliate')->first();
        $orders = Order::whereIn('id', json_decode($paymentRequest->order_ids))->paginate(10);
        return view('admin_payment.payment_info', compact(['paymentRequest', 'orders', 'currency']));
    }

    public function confirmPayment(Request $request)
    {
        $paymentRequest = PaymentRequest::where('id', $request->input('paymentId'))->first();
        if (isset($paymentRequest) && !is_null($paymentRequest)) {
            if ($request->hasFile('file')) {
                // Define folder path
                $filePath = '/uploads/admin_payments/confirmed';
                // Upload image
                $paymentRequest->file = $request->file('file')->store($filePath);
            }
            $paymentRequest->status = "confirmed";
            $confirmPayment = $paymentRequest->save();
//            Order::update(["payment_request"=> 1])->where('affiliate_id', $request->input('affiliateId'))->whereIn("id", json_decode($paymentRequest->order_ids));
            if ($confirmPayment) {
                $orders = Order::whereIn('id', json_decode($paymentRequest->order_ids))->where('affiliate_id', $request->input('affiliateId'))->get();
                foreach ($orders as $order) {
                    $order->update(["payment_request" => 1]);
                }
                Session::flash('success', 'Updated Successfully');
                return redirect()->back();
            } else {
                return redirect()->back()->withInput()->withErrors(['coupon' => 'This coupon already taken']);
            }
        }
        return redirect()->back();
        //change status of payment request to confirmed.
    }
}
