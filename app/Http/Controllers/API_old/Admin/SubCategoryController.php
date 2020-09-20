<?php

namespace App\Http\Controllers\API\Admin;

use App\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        $subCategories = SubCategory::latest();
        if ($request->input('category_id')){
            $subCategories = $subCategories->where('category_id' , $request->input('category_id'));
        }
        return response()->json(['status' => 200 , 'data' => $subCategories->get()]);
    }

    public function destroy($id)
    {
        SubCategory::where('id', $id)->delete();
        return response()->json(['status' => 200, 'message' => 'تم المسح بنجاح'], 200);
    }
}
