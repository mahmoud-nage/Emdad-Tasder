<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Review;
use App\Product;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{

    public function index()
    {
        $reviews = Review::all();
        return response()->json(['status' => 200, 'data' => $reviews], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required',
            'comment' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'error' => 'Validation Error', 'message' => $validator->messages()], 200);
        }
        $review = new Review;
        $review->product_id = $request->product_id;
        $review->user_id = $request->user_id;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        if ($review->save()) {
            $product = Product::findOrFail($request->product_id);
            if (count(Review::where('product_id', $product->id)->where('status', 1)->get()) > 0) {
                $product->rating = Review::where('product_id', $product->id)->where('status', 1)->sum('rating') / count(Review::where('product_id', $product->id)->where('status', 1)->get());
            } else {
                $product->rating = 0;
            }
            $product->save();
            return response()->json(['status' => 200, 'data' => $review, 'message' => 'Review has been submitted successfully'], 200);
        }
        return response()->json(['status' => 500, 'message' => 'Something went wrong'], 200);

    }
}
