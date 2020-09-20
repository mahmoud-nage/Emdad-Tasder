<?php

namespace App\Http\Controllers\API\Web;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->input('type')){
            if ($request->input('type') == 'all_orders'){
                $order = Order::with('details','Status')
                    ->where('user_id' , $request->input('user_id'))
                    ->latest()->get();
                return response()->json(['status' => 200 , 'data' => $order]);
            }
        }
        $order = Order::with('details','Status','User')->where('user_id' , $request->input('user_id'))->whereNotIn('status_id' , [4,5] )->latest()->first();
        $time = isset($order) ? $order->created_at->toTimeString() : null;
        $day = isset($order) ? $order->created_at->format('l') : null;
        return response()->json(['status' => 200 , 'data' => $order , 'day' => $day , 'time' => $time]);
    }
    public function show(Request $request)
    {
        $order = Order::with('details','Status','Address','Branch','User')->where('id' , $request->input('order_id'))->first();
        $time = isset($order) ? $order->created_at->toTimeString() : null;
        $day = isset($order) ? $order->created_at->format('l') : null;
        return response()->json(['status' => 200 , 'data' => $order , 'day' => $day , 'time' => $time]);
    }
    public function cancel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 500);
        }
        Order::where('id' , $request->input('order_id'))->update(['status_id' => 5]);
        return response()->json(['status' => 200, 'message' => 'Order Canceled Successfully'], 200);
    }
}
