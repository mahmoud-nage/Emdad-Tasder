<?php

namespace App\Http\Controllers\API\Admin;

use App\Order;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('User' , 'Branch' , 'details', 'Status', 'Address')->latest();
        if ($request->input('status_id')){
            $orders = $orders->where('status_id' , $request->input('status_id'));
        }
        if ($request->input('name')){
            $users = User::where('name' , 'like' , '%'.$request->input('name').'%')->pluck('id')->toArray();
            $orders = $orders->whereIn('user_id' , $users);
        }
        return response()->json(['status' => 200 , 'data' => $orders->paginate(20)]);
    }

    public function update($id , Request $request)
    {
        Order::where('id' , $id)->update(['status_id' =>$request->input('status_id')]);
        return response()->json(['status' => 200, 'message' => 'تم التعديل'], 200);
    }

    public function destroy($id)
    {
        Order::where('id', $id)->delete();
        return response()->json(['status' => 200, 'message' => 'تم المسح'], 200);
    }
}
