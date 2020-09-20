<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Zone;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductReviewController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 200);
        }
        $reiews = Review::where('user_id', $request->user_id)->with('product')->get();
        return response()->json(['status' => 200, 'data' => $reiews->toArray()],200);
    }

    public function product(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required_without:user_id',
            'user_id' => 'required_without:product_id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 200, 'message' => $validator->errors()->messages()]);
        }
        if (isset($request->product_id))
            $reiews = Review::where('product_id', $request->product_id)->where('status', 1)->with('user')->get();
        if (isset($request->user_id))
            $reiews = Review::where('user_id', $request->user_id)->where('status', 1)->with('product')->get();
        return response()->json(['status' => 200, 'data' => $reiews->toArray()],200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'product_id' => 'required',
            'rating' => 'required',
            'comment' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()],200);
        }
        $orderIds = Order::where('user_id', $request->input('user_id'))->pluck('id');
        $orderDetails_productIds = OrderDetail::whereIn('order_id', $orderIds)->pluck('product_id');
        if (in_array($request->input('product_id'),$orderDetails_productIds->toArray())){
            $reiew = Review::create($request->all());
            $product = Product::findOrFail($request->product_id);
            if (count(Review::where('product_id', $product->id)->where('status', 1)->get()) > 0) {
                $product->rating = Review::where('product_id', $product->id)->where('status', 1)->sum('rating') / count(Review::where('product_id', $product->id)->where('status', 1)->get());
            } else {
                $product->rating = 0;
            }
            $product->save();
            return response()->json(['status' => 200, 'data' => $reiew],200);
        }
        return response()->json(['status' => 400, 'message' => "You should buy this product to be able to review it!"],200);
    }

    public function getUserReviews(Request $request)
    {
        dd($request->all());
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 200);
        }
        $reiews = Review::where('user_id', $request->user_id)->with('product')->get();
        return response()->json(['status' => 200, 'data' => $reiews->toArray()],200);
    }
}
