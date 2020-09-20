<?php

namespace App\Http\Controllers\API;

use App\Meal;
use App\Offer;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    public function index(Request $request)
    {
        dd($request);
        $column = app()->isLocale('ar') ? 'name_ar' : 'name_en';
        $column_des = app()->isLocale('ar') ? 'description_ar' : 'description_en';
        $offers = Product::where('products.published', 1)->where('products.discount','!=', 'NULL')
            ->join('product_countries', 'products.id', '=', 'product_countries.product_id')
            ->where('product_countries.country_id', $request->input('country_id'))
            ->select('products.id', $column . ' as name', 'thumbnail_img', 'rating', 'featured_img',
                'flash_deal_img', $column_des . ' as description', 'product_countries.unit_price',
                'product_countries.purchase_price', 'products.discount',
                'products.discount_type')->latest('product_countries.id')->get();
        return response()->json(['status' => 200, 'data' => offers], 200);
//
//        for ($x = 10; $x <= 100; $x = $x + 5) {
//            $allOffers = array();
//            $offers = Offer::where('start_date', '<=', Carbon::now()->toDateString())->where('end_date', '>=', Carbon::now()->toDateString())->where('discount', $x)->latest()->get();
//            foreach ($offers as $offer) {
//                $days_left = Carbon::parse($offer->end_date)->diffInDays(Carbon::now());
//                $hours_left = Carbon::parse($offer->end_date)->diffInHours(Carbon::now());
//                $allOffers[] = [
//                    'id' => $offer->id,
//                    'title_ar' => $offer->title_ar,
//                    'title_en' => $offer->title_en,
//                    'desc_ar' => $offer->desc_ar,
//                    'desc_en' => $offer->desc_en,
//                    'meta_title' => $offer->meta_title,
//                    'meta_description' => $offer->meta_description,
//                    'start_date' => $offer->start_date,
//                    'end_date' => $offer->end_date,
//                    'days_left' => $days_left,
//                    'hours_left' => $hours_left,
//                    'discount' => $offer->discount,
//                    'discount_type' => $offer->discount_type,
//                    'meal_id' => $offer->meal_id,
//                    'thumb_img' => $offer->thumb_img,
//                    'price' => $offer->price,
//                    'meal' => $offer->Meal,
//                    'created_at' => $offer->created_at,
//                    'updated_at' => $offer->updated_at,
//                ];
//            }
//            $data[$x . '%'] = $allOffers;
//        }
//        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function show(Request $request)
    {
        $offer = Offer::find($request->input('offer_id'));
        $meal = Meal::with('Category', 'SubCategory', 'options')->where('id', $offer->meal_id)->first();
        $sizes = array();
        $data = [
            "id" => $meal->id,
            "name_en" => $meal->name_en,
            "name_ar" => $meal->name_ar,
            "desc_ar" => $meal->desc_ar,
            "desc_en" => $meal->desc_en,
            "thumb_img" => $offer->thumb_img,
            "photos" => json_decode($meal->photos),
            "tags" => json_decode($meal->tags),
            "price" => $offer->price,
            "category_id" => $meal->category_id,
            "category" => $meal->Category,
            "options" => $meal->options,
        ];
        $meal_s = Meal::where('id', $offer->meal_id)->first();
        foreach ($meal_s->sizes as $size) {
            $sizes[] = [
                'size' => $size,
                'price' => DB::table('meal_sizes')->where('meal_id', $meal->id)->where('size_id', $size->id)->first()->price,
            ];
        }
        return response()->json(['status' => 200, 'data' => $data, 'sizes' => $sizes]);
    }

}
