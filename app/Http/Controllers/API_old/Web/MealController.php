<?php

namespace App\Http\Controllers\API\Web;

use App\Category;
use App\Meal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MealController extends Controller
{
    public function index(Request $request)
    {
        $meals = Meal::latest();
        if ($request->input('q')){
            $meals = $meals->where('name_ar' , 'like' , '%'.$request->input('q').'%')->orWhere('name_en' , 'like' , '%'.$request->input('q').'q')->take(10)->get();
            return response()->json(['status' => 200 , 'data' => $meals ]);
        }
        if ($request->input('name')){
            $meals = $meals->where('name_ar' , 'like' , '%'.$request->input('name').'%')->orWhere('name_en' , 'like' , '%'.$request->input('name').'%');
        }
        if ($request->input('category_id')){
            $meals = $meals->where('category_id' , $request->input('category_id'));
        }
        if ($request->input('sub_category_id')){
            $meals = $meals->where('sub_category_id' , $request->input('sub_category_id'));
        }
        $meals = $meals->paginate(10);
        $mealsData = array();
        foreach ($meals->getCollection() as $meal) {
            $mealsData[] = [
                'id' => $meal->id,
                'name_ar' => $meal->name_ar,
                'name_en' => $meal->name_en,
                'desc_ar' => $meal->desc_ar,
                'desc_en' => $meal->desc_en,
                'thumb_img' => $meal->thumb_img,
                'photos' => json_decode($meal->photos),
                'tags' => json_decode($meal->tags),
                'price' => $meal->price,
                'category_id' => $meal->category_id,
                'orders_count' => $meal->orders_count,
                'is_fav' => $request->input('user_id') ? $meal->favourites->contains($request->input('user_id')) : false,
            ];
        }
        $data = [
            'current_page' => $meals->currentPage(),
            'data' => $mealsData,
            'count' => $meals->count(),
            'first_page_url' => $meals->url(1),
            'from' => 1,
            'last_page' => $meals->lastPage(),
            'last_page_url' => $meals->url($meals->lastPage()),
            'next_page_url' => $meals->nextPageUrl(),
            'path' => $meals->url(1),
            'per_page' => $meals->perPage(),
            'prev_page_url' => $meals->previousPageUrl(),
            'to' => count($meals->getCollection())/15 <= 1 ? 1 : round(count($meals->getCollection())/15),
            'total' => $meals->total(),
        ];
        return response()->json(['status' => 200 , 'data' => $data , 'category' => Category::find($request->input('category_id'))]);
    }

    public function show(Request $request)
    {
        $meal = Meal::with('Category' , 'SubCategory' , 'options' )->where('id' , $request->input('meal_id'))->first();
        $sizes = array();
        $meal_s = Meal::where('id' , $request->input('meal_id'))->first();
        foreach ($meal_s->sizes as $size) {
            $sizes[] = [
                'size' => $size,
                'price' => DB::table('meal_sizes')->where('meal_id' , $meal->id)->where('size_id' , $size->id)->first()->price,
            ];
        }
        return response()->json(['status' => 200 , 'data' => $meal , 'sizes' => $sizes]);
    }
}
