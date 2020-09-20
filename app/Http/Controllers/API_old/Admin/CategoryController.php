<?php

namespace App\Http\Controllers\API\Admin;

use App\Category;
use App\City;
use App\Meal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return response()->json(['status' => 200 , 'data' => $categories]);
    }

    public function destroy($id)
    {
        Category::where('id', $id)->delete();
        Meal::where('category_id' , $id)->delete();
        return response()->json(['status' => 200, 'message' => 'تم المسح بنجاح'], 200);
    }
}
