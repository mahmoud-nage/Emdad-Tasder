<?php

namespace App\Http\Controllers\API\Web;

use App\Meal;
use App\Offer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    public function index(Request $request)
    {
        $offers = Offer::with('Meal')->where('start_date', '<=', Carbon::now()->toDateString())->where('end_date', '>=', Carbon::now()->toDateString())->latest()->get();
        return response()->json(['status' => 200, 'data' => $offers]);
    }


    public function show(Request $request)
    {
        $offer = Offer::with('Meal' )->where('id' , $request->input('offer_id'))->first();
        $sizes = array();
        $meal_s = Meal::where('id' , $offer->meal_id)->first();
        foreach ($meal_s->sizes as $size) {
            $sizes[] = [
                'size' => $size,
                'price' => DB::table('meal_sizes')->where('meal_id' , $offer->meal_id)->where('size_id' , $size->id)->first()->price,
            ];
        }
        return response()->json(['status' => 200 , 'data' => $offer , 'sizes' => $sizes]);
    }
}
