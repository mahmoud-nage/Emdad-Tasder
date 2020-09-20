<?php

namespace App\Http\Controllers\API\Web;

use App\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $reviews = Review::where('doctor_id', $request->input('doctor_id'))->with('User')->latest()->get();
        return response()->json(['status' => 200, 'data' => $reviews]);
    }

    public function store(Request $request)
    {
        $review = Review::where('user_id' , $request->input('user_id'))->where('doctor_id' , $request->input('doctor_id'))->first();
        if (isset($review)){
            return response()->json(['status' => 200, 'message' => 'Already Reviewed' , 'review' => $review]);
        }
        $review = Review::create([
            'user_id' => $request->input('user_id'),
            'doctor_id' => $request->input('doctor_id'),
            'value' => $request->input('value'),
            'body' => $request->input('body'),
        ]);
        return response()->json(['status' => 200, 'message' => 'done successfully' , 'review' => $review]);
    }
}
