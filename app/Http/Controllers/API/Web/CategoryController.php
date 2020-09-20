<?php

namespace App\Http\Controllers\API\Web;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $locale = $request->input('locale');
        $data = array();
        foreach ($categories as $category) {
            $data[] =[
                'id' => $category->id,
                'name' => $locale == 'en' ?  $category->name_en : $category->name_ar,
            ];
        }
        return response()->json(['status' => 200 , 'data' => $data]);
    }
}
