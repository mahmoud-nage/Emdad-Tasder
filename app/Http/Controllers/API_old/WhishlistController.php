<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Wishlist;

class WhishlistController extends Controller
{
    public function index(Request $request)
    {
        $data = Wishlist::where('user_id' , $request->input('user_id'))->with('product')->latest()->get();
        return response()->json(['status' => 200 , 'data' => $data]);
    }

    public function store(Request $request)
    {
        $data = Wishlist::create([
            'user_id' => $request->input('user_id'),
            'product_id' => $request->input('product_id'),
        ]);
        return response()->json(['status' => 200 , 'message' => 'success']);
    }

    public function destroy(Request $request)
    {
        Wishlist::where('id' , $request->input('whishlist_id'));
        return response()->json(['status' => 200 , 'message' => 'success']);
    }
}
