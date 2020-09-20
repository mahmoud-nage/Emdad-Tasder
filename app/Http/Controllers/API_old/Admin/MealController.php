<?php

namespace App\Http\Controllers\API\Admin;

use App\Meal;
use App\Offer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MealController extends Controller
{
    public function index()
    {
        $meals = Meal::orderBy('orders_count' , 'desc')->with('options', 'sizes', 'orderDetails', 'points', 'Category', 'SubCategory')->latest();
        return response()->json(['status' => 200, 'data' => $meals->paginate(30) ], 200);
    }

    public function destroy($id)
    {
        Meal::where('id' , $id)->delete();
        Offer::where('meal_id' , $id)->delete();
        return response()->json(['status' => 200, 'message' => 'تم المسح بنجاح' ], 200);
    }
}
