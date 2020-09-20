<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
{

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'error' => 'Validation Error' , 'message' => $validator->messages()] , 200);
        }
        $lang = 'ar';
        if (!is_null($request->header('lang'))) {
            $lang = $request->header('lang');
        }

        $column = $lang == 'ar' ? 'name_ar' : 'name_en';
        $categories = SubCategory::select('id' , $column .' as name')->latest();
        if ($request->input('category_id')){
            $categories = $categories->where('category_id' , $request->input('category_id'));
        }
        return response()->json(['status' => 200 , 'data' => $categories->get()]);
    }
}
