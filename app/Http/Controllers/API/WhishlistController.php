<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Wishlist;

class WhishlistController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 200);
        }
        $data = Wishlist::where('user_id', $request->input('user_id'))->with('product')->latest()->get();
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 200);
        }

        $data = Wishlist::create([
            'user_id' => $request->input('user_id'),
            'product_id' => $request->input('product_id'),
        ]);
        return response()->json(['status' => 200, 'message' => 'success']);
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'whishlist_id' => 'required|exists:wishlists,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 200);
        }

        Wishlist::where('id', $request->input('whishlist_id'));
        return response()->json(['status' => 200, 'message' => 'success']);
    }
}
