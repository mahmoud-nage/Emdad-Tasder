<?php

namespace App\Http\Controllers\API;

use App\FlashDeal;
use App\FlashDealProduct;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FlashDealController extends Controller
{
    public function index()
    {
        $flash_ids = FlashDeal::where('status' , 1)->where('start_date' , '<=' ,  strtotime(date('d-m-Y')) )->where('end_date' , '>=' ,  strtotime(date('d-m-Y')) )->pluck('id')->toArray();
        $product_ids = FlashDealProduct::whereIn('flash_deal_id' , $flash_ids)->pluck('product_id')->toArray();
        $data = Product::whereIn('id' , $product_ids)->latest()->get();
        return response()->json(['status' => 200 , 'data' => $data]);
    }
}
