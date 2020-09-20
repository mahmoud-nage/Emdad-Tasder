<?php

namespace App\Http\Controllers\API\Affiliate;

use App\Affiliate;
use App\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $affiliate = Affiliate::find($request->input('affiliate_id'));
        $column = app()->isLocale('ar') ? 'name_ar' : 'name_en';

        if ($request->input('country')){
            $country = Country::find($request->input('country'));
            $products = $country->products();

            if ($request->input('category')){
                $products = $products->where('category_id' , $request->input('category'));
            }
            if ($request->input('sub_category')){
                $products = $products->where('subcategory_id' , $request->input('sub_category'));
            }

            if ($request->input('keyword')){
                $products = $products->where($column , 'like' , '%'.$request->input('keyword').'%');
            }
            $products = $products->paginate(20);
            $productsData = array();
            foreach ($products->getCollection() as $product) {
                $productsData[] = [
                    'name' => $product->$column ,
                    'image' => $product->thumbnail_img,
                    'price' => $product->get_price($request->input('country')).' '.$country->Currency->symbol,
                    'url' => route('product' , $product->slug).'?aff='.encrypt($affiliate->id).'&cc-p='.encrypt($affiliate->Coupon->id).
                        '&u_as='.$request->input('tag1').'|'.$request->input('tag1').'|'.$request->input('tag2').'|'.$request->input('tag3').'|'.
                        $request->input('tag4').'|'.$request->input('tag5'),
                ];
            }
            $data = [
                'current_page' => $products->currentPage(),
                'data' => $productsData,
                'count' => $products->count(),
                'first_page_url' => $products->url(1),
                'from' => 1,
                'last_page' => $products->lastPage(),
                'last_page_url' => $products->url($products->lastPage()),
                'next_page_url' => $products->nextPageUrl(),
                'path' => $products->url(1),
                'per_page' => $products->perPage(),
                'prev_page_url' => $products->previousPageUrl(),
                'to' => count($products->getCollection())/15 <= 1 ? 1 : round(count($products->getCollection())/15),
                'total' => $products->total(),
            ];
            return response(['data' => $data]);
        }
    }
}
