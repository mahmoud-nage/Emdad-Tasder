<?php

namespace App\Http\Controllers;

use App\Order;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PurchaseHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(9);
        if (auth()->user()->user_type == 'customer') {
            return view('frontend.purchase_history', compact('orders'));

        } elseif (auth()->user()->user_type == 'seller') {
            return view('frontend.seller.purchase_history', compact('orders'));
        }
    }

    public function purchase_history_details(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        return view('frontend.partials.order_details_customer', compact('order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    public function cancel($country, $id)
    {
        $order = Order::findOrFail($id);
        if ($order != null) {
            $order->is_cancelled = 0;
            $order->status_id = 5;
            $order->save();
            foreach ($order->orderDetails as $key => $orderDetail) {
                $orderDetail->delivery_status = 'Canceled';
                $qty = $orderDetail->quantity;
                if ($orderDetail->Variation) {
                    $orderDetail->Variation->qty += $qty;
                    $orderDetail->Variation->save();
                } else {
                    $orderDetail->product->main_quantity += $qty;
                    $orderDetail->product->save();
                }
                $orderDetail->save();
            }
            Session::flash('alert-success', 'Order has been Canceled successfully');
        } else {
            Session::flash('alert-danger', 'Something went wrong');
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($country, $id)
    {
        $order = Order::findOrFail($id);
        if ($order != null && $order->status_id == 1) {
            foreach ($order->orderDetails as $key => $orderDetail) {
                $orderDetail->delete();
            }
            $order->delete();
            Session::flash('alert-success', 'Order has been deleted successfully');
        } else {
            Session::flash('alert-danger', 'Something went wrong');
        }
        return back();
    }
    public function followPurchase(Request $request)
    {
        $this->validate(request(), [
            'code' => 'required|exists:orders,code',
        ]);

        $order = Order::where('code', $request->code)->first();
        if ($order->count() > 0) {
            flash(__('Order has been found successfully'))->success();

            return view('frontend.follow_purchase', compact('order'));
        } else {
            flash(__('Order has not been found'))->error();
            return view('frontend.follow_purchase');
        }
    }
}
