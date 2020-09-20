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
        $column = app()->isLocale('ar') ? 'name_ar' : 'name_en';
        $categories = SubCategory::select('id' , $column .' as name')->latest();
        if ($request->input('category_id')){
            $categories = $categories->where('category_id' , $request->input('category_id'));
        }
        return response()->json(['status' => 200 , 'data' => $categories->get()]);
    }
}
