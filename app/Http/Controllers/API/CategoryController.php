<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Product;
use App\SubSubCategory;
use App\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $banners = \App\Banner::where('type', 'mobile')->where('published',1)->where('type1',2)->pluck('photo')->toArray();
        $sliders = \App\Slider::where('type' , 'mobile')->where('published',1)->where('type1',2)->pluck('photo')->toArray();
        
        $column = app()->isLocale('ar') ? 'name_ar' : 'name_en';
        $categories = Category::all();
        $data = array();
        foreach ($categories as $category) {
            $subs = array();
            $subCategories = SubCategory::where('category_id' , $category->id)->get();
            foreach ($subCategories as $subCategory) {
                $subsubCategories = SubSubCategory::where('sub_category_id' , $subCategory->id)->get();
                foreach ($subsubCategories as $sunsubCategory) {
                $subsub[] = [
                    'id' => $sunsubCategory->id,
                    'name' => $sunsubCategory->$column,
                    'products_num' => Product::where('subsubcategory_id' , $sunsubCategory->id)->count(),
                    'icon' => $sunsubCategory->image,
                ];
                }
                $subs[] = [
                    'id' => $subCategory->id,
                    'name' => $subCategory->$column,
                    'products_num' => Product::where('subcategory_id' , $subCategory->id)->count(),
                    'icon' => $subCategory->image,
                    'sub_sub_categories' => $subsub,
                ];
                $subsub=[];
            }
            $data[] = [
                'id' => $category->id,
                'name' => $category->$column,
                'icon' => $category->icon,
                'banner' => $category->banner,
                'banners' => $banners,
                'sliders' => $sliders,
                'products_num' => Product::where('category_id' , $category->id)->count(),
                'sub_categories' => $subs,
            ];
            $subs =[];
        }
        return response()->json(['status' => 200 , 'data' => $data]);
    }

}
