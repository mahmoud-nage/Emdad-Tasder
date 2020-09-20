<?php

namespace App\Http\Controllers\API\Affiliate;

use App\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(['data' => SubCategory::where('category_id' , $request->input('category'))->get()]);
    }
}
