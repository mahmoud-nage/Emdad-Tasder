<?php

namespace App\Http\Controllers\API;

use App\Country;
use App\Product;
use App\Review;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerController extends Controller
{
    public function index(Request $request)
    {
        $country = Country::find($request->input('country_id'));
        $data = User::where('user_type' , 'seller')->where('country' , $country->code)->get();
        return response()->json(['status' => 200 , 'data' => $data]);
    }
    public function show(Request $request)
    {
        $column = app()->isLocale('ar') ? 'name_ar' : 'name_en';
        $column_des = app()->isLocale('ar') ? 'description_ar' : 'description_en';
        $user = User::where('id' , $request->input('seller_id'))->first();
        $country = Country::where('code' , $user->country)->first();
        $productsId = Product::where('user_id' , $user->id)->pluck('id')->toArray();
        $reviews = Review::whereIn('product_id' , $productsId)->select('id' , 'rating' , 'comment')->where('status', 1)->get();
        $products = Product::join('product_countries', 'products.id', '=', 'product_countries.product_id')->whereIn('products.id' , $productsId)->where('product_countries.country_id' , $country->id)
            ->select('products.id', $column .' as name' , 'thumbnail_img' , 'featured_img' , 'flash_deal_img', $column_des.' as description' , 'product_countries.unit_price' ,
                'product_countries.purchase_price')->latest('product_countries.id')->get();

        return response()->json(['status' => 200 , 'seller' => $user , 'products' => $products,'reviews' => $reviews]);
    }
}
