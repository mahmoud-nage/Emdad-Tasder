<?php

namespace App\Http\Controllers\API;

use App\FlashDeal;
use App\FlashDealProduct;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FlashDealController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 200);
        }

        $flash_ids = FlashDeal::where('status', 1)->where('start_date', '<=', strtotime(date('d-m-Y')))->where('end_date', '>=', strtotime(date('d-m-Y')))->pluck('id')->toArray();
        $product_ids = FlashDealProduct::whereIn('flash_deal_id', $flash_ids)->pluck('product_id')->toArray();
        $flash_deal_products = Product::whereIn('id', $product_ids)->join('product_countries', 'products.id', '=', 'product_countries.product_id')->where('product_countries.country_id', $request->input('country_id'))
            ->select('products.id', 'name', 'thumbnail_img', 'featured_img', 'flash_deal_img', 'description', 'product_countries.unit_price', 'product_countries.discount',
                'product_countries.discount_type', 'products.rating')->latest('product_countries.id')->take(10)->get();
        $data = [
            'flash_deal' => $flash_deal_products,
        ];
        return response()->json(['status' => 200, 'data' => $data], 200);

    }
}
