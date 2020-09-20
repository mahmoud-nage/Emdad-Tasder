<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralSettingController;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\Seller;
use App\SellerPayment;
use App\Shop;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sellers = Seller::orderBy('created_at', 'desc')->get();
        return view('sellers.index', compact('sellers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sellers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|min:8',
        ]);

        if (User::where('email', $request->email)->first() != null) {
            flash(__('Email already exists!'))->error();
            return back();
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_type = "seller";
        $user->password = Hash::make($request->password);
        if ($user->save()) {
            $seller = new Seller;
            $seller->user_id = $user->id;
            if ($seller->save()) {
                $shop = new Shop;
                $shop->user_id = $user->id;
                $shop->slug = 'demo-shop-' . $user->id;
                $shop->save();
                flash(__('Seller has been inserted successfully'))->success();
                return redirect()->route('sellers.index');
            }
        }

        flash(__('Something went wrong'))->error();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $seller = Seller::findOrFail($id);
        // dd($seller);
        return view('sellers.info', compact('seller'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($country,$id)
    {
        $seller = Seller::findOrFail(decrypt($id));
        return view('sellers.edit', compact('seller'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $country, $id)
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required',
        ]);

        $seller = Seller::findOrFail($id);
        $user = $seller->user;
        $user->name = $request->name;
        $user->email = $request->email;
        if (strlen($request->password) > 0) {
            $user->password = Hash::make($request->password);
        }
        if ($user->save()) {
            if ($seller->save()) {
                flash(__('Seller has been updated successfully'))->success();
                return redirect()->route('sellers.index',get_country()->code);
            }
        }

        flash(__('Something went wrong'))->error();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $seller = Seller::findOrFail($id);
        Shop::destroy($seller->user->id);
        Product::where('user_id', $seller->user->id)->delete();
        Order::where('user_id', $seller->user->id)->delete();
        OrderDetail::where('seller_id', $seller->user->id)->delete();
        User::destroy($seller->user->id);
        if (Seller::destroy($id)) {
            flash(__('Seller has been deleted successfully'))->success();
            return redirect()->route('sellers.index');
        }

        flash(__('Something went wrong'))->error();
        return back();
    }

    public function show_verification_request($id)
    {
        $seller = Seller::findOrFail($id);
        return view('sellers.verification', compact('seller'));
    }

    public function approve_seller($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->verification_status = 1;
        if ($seller->save()) {
            if ($request->ajax()) {
                return response()->json(['status' => 200]);
            }
            flash(__('Seller has been approved successfully'))->success();
            return redirect()->route('sellers.index');
        }
        flash(__('Something went wrong'))->error();
        return back();
    }

    public function reject_seller($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->verification_status = 0;
        $seller->verification_info = null;
        if ($seller->save()) {
            flash(__('Seller verification request has been rejected successfully'))->success();
            return redirect()->route('sellers.index');
        }
        flash(__('Something went wrong'))->error();
        return back();
    }

    public function update_verify_ajax(Request $request)
    {
        $seller = Seller::findOrFail($request->id);
        $seller->verification_status = $request->status;
        if ($seller->save()) {
            if ($request->ajax()) {
                return 1;
            }
        }

    }

    public function payment_modal(Request $request)
    {
        $seller = Seller::findOrFail($request->id);
        return view('sellers.payment_modal', compact('seller'));
    }

    public function seller_payments(Request $request)
    {
        if ($request->has('seller_id')) {
            $payments = SellerPayment::where('seller_id', $request->seller_id)->orderBy('id', 'desc')->get();
            $seller = Seller::where('user_id', $request->seller_id)->first();
            // dd($seller);
            return view('sellers.seller_payments', compact('payments', 'seller'));
        }
        $payments = SellerPayment::orderBy('id', 'desc')->paginate(9);
        return view('sellers.payment_histories', compact('payments'));
    }

    public function seller_payment_request(Request $request)
    {
        $this->validate(request(), [
            'seller_id' => 'required|exists:sellers,id',
            'email' => 'required',
        ]);

        $general_setting = GeneralSettingController::first();
        $total = 0;
        $orders = DB::table('orders')
            ->orderBy('id', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->where('order_details.seller_id', $request->seller_id)
            ->where('orders.payment_request', 0)
            ->where('order_details.payment_status', 'paid')
            ->select('orders.id')
            ->distinct()
            ->get()->toArray();

        $order_ids = [];
        if ($orders != null) {
            foreach ($orders as $key => $order_id) {
                $order = Order::find($order_id->id);
                if (strtotime("+" . $general_setting->withdrawal_duration . " day", strtotime($order->created_at)) <= strtotime(now())) {
                    $order_ids[] = $order->id;
                }

            }
        }
        $payment_seller = new SellerPayment;
        $payment_seller->seller_id = $request->seller_id;
        $payment_seller->payment_method = $request->payment_method;
        $payment_seller->amount = $request->amount;
        $payment_seller->order_ids = json_encode($order_ids);
        if ($payment_seller->save()) {
            $orderDetails = DB::table('order_details')
                ->orderBy('id', 'desc')
                ->join('orders', 'orders.id', '=', 'order_details.order_id')
                ->where('orders.payment_request', 0)
                ->where('order_details.seller_id', $request->seller_id)
                ->where('orders.payment_status', 'paid')
                ->select('order_details.id')
                ->get();
            if ($orderDetails != null) {
                foreach ($orderDetails as $orderDetail_id) {
                    $orderDetail = OrderDetail::find($orderDetail_id->id);
                    if (strtotime("+" . $general_setting->withdrawal_duration . " day", strtotime($orderDetail->created_at)) <= strtotime(now())) {
                        $total += $orderDetail->price - $orderDetail->commission;
                    }

                }
                $seller = Seller::where('user_id', $request->seller_id)->first();
                $seller->admin_to_pay = $total;
                $seller->save();
            }

            flash(__('general.payment_seller_msg'))->success();
            return redirect()->back();
        }
        flash(__('Something went wrong'))->error();
        return redirect()->back();
    }

    public function confirmPayment(Request $request)
    {
        $this->validate(request(), [
            'paymentId' => 'required|exists:seller_payments,id',
        ]);

        $paymentRequest = SellerPayment::where('id', $request->input('paymentId'))->first();
        if (isset($paymentRequest) && !is_null($paymentRequest)) {
            if ($request->hasFile('file')) {
                // Define folder path
                $path = 'uploads/admin_payments/confirmed';
                $name = resizeUploadImage($request->icon, $path, $resize_width = 100, $resize_height = 100);
                $paymentRequest->file = $name;
            }
            $paymentRequest->status = 2;
            $confirmPayment = $paymentRequest->save();

//            Order::update(["payment_request"=> 1])->where('affiliate_id', $request->input('affiliateId'))->whereIn("id", json_decode($paymentRequest->order_ids));
            if ($confirmPayment) {
                $orders = Order::whereIn('id', json_decode($paymentRequest->order_ids))->get();
                foreach ($orders as $order) {
                    $order->update(["payment_request" => 1]);
                }
                Session::flash('success', 'Updated Successfully');
                return redirect()->back();
            } else {
                return redirect()->back()->withInput()->withErrors(['coupon' => 'This coupon already taken']);
            }
            $seller = Seller::where('user_id', $request->seller_id)->first();
            $seller->admin_to_pay = 0;
            $seller->save();
        }
        return redirect()->back();
        //change status of payment request to confirmed.
    }

}
