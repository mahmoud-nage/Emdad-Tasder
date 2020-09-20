<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Product;
use App\Variation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\HomeController\variant_price;

class ProductController extends Controller
{
    public function variant_price($product_id, $country_id)
    {
        $variants = [];
        $product = Product::find($product_id);
        $product_country = \Illuminate\Support\Facades\DB::table('product_countries')->where('product_id', $product->id)->where('country_id', $country_id)->first();
        $quantity = 0;
        $discount = 0;
        $tax = 0;
        $product_variations = Variation::where('product_id', $product->id)->where('product_country_id', $country_id)->get();
        
          //discount calculation
        $flash_deal = \App\FlashDeal::where('status', 1)->first();
        if ($flash_deal != null && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first() != null) {
            $flash_deal_product = \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->where('country_id', $country_id)->first();
        }
            
            
        if($product->Variations->count() >0){
        foreach ($product_variations as $variation) {
            $price = $variation->price;
            if(isset($flash_deal_product)){
            if ($flash_deal_product->discount_type == 'percent') {
                $price += ($price * $flash_deal_product->discount) / 100;
            } elseif ($flash_deal_product->discount_type == 'amount') {
                $price += $flash_deal_product->discount;
            }
        } else {
            if ($product_country->discount_type == 'percent') {
                $price -= ($price * $product_country->discount) / 100;
            } elseif ($product_country->discount_type == 'amount') {
                $price -= $product_country->discount;
            }
        }

        if ($product_country->tax_type == 'percent') {
            $price += ($price * $product_country->tax) / 100;
        } elseif ($product_country->tax_type == 'amount') {
            $price += $product_country->tax;
        }
            $variation->price = $price;
            $variants[] = $variation;
        }
}
            $price = $product_country->unit_price;
            if(isset($flash_deal_product)){
            if ($flash_deal_product->discount_type == 'percent') {
                $price += ($price * $flash_deal_product->discount) / 100;
            } elseif ($flash_deal_product->discount_type == 'amount') {
                $price += $flash_deal_product->discount;
            }
        } else {
            if ($product_country->discount_type == 'percent') {
                $price -= ($price * $product_country->discount) / 100;
            } elseif ($product_country->discount_type == 'amount') {
                $price -= $product_country->discount;
            }
        }

        if ($product_country->tax_type == 'percent') {
            $price += ($price * $product_country->tax) / 100;
        } elseif ($product_country->tax_type == 'amount') {
            $price += $product_country->tax;
        }
        $unit_price = $price;
        return array('variants' => $variants, 'unit_price' => $unit_price);
    }
    
     public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required',
            'subsubcategory_id' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'error' => 'Validation Error', 'message' => $validator->messages()]);
        }
        $lang = 'ar';
        if (!is_null($request->header('lang'))) {
            $lang = $request->header('lang');
        }

        $column = $lang == 'ar' ? 'name_ar' : 'name_en';
        $column_des = $lang == 'ar' ? 'description_ar' : 'description_en';
        
        $data = Product::join('product_countries', 'products.id', '=', 'product_countries.product_id')->where('product_countries.country_id', $request->input('country_id'))->where('products.subsubcategory_id','=',$request->input('subsubcategory_id'))
            ->select('products.id', $column . ' as name', 'thumbnail_img', 'featured_img', 'flash_deal_img', $column_des . ' as description', 'product_countries.unit_price',
                'product_countries.purchase_price','product_countries.discount',
                    'product_countries.discount_type')->latest('product_countries.id');
                    


                    
        if ($request->input('name')) {
            $data = $data->where('name_ar', 'like', '%' . $request->input('name') . '%')->orWhere('name_en', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->input('category_id')) {
            $data = $data->where('category_id', $request->input('category_id'));
        }
        if ($request->input('sub_category_id')) {
            $data = $data->where('subcategory_id', $request->input('sub_category_id'));
        }
        if ($request->input('brand')) {
            $data = $data->where('brand_id', $request->input('brand'));
        }
        if ($request->input('rate')) {
            $data = $data->where('rating', $request->input('rate'));
        }
        if ($request->input('from_price')) {
            $data = $data->whereBetween('product_countries.unit_price', [$request->input('from_price'), $request->input('to_price')]);
        }
        if ($request->input('seller_id')) {
            $data = $data->where('user_id', $request->input('seller_id'));
        }
        foreach($data->get() as $index => $product){
            $price = $product->api_get_price($product->id,$request->input('country_id'));
            $product->unit_price = $price['unit_price'];
        }
        return response()->json(['status' => 200, 'data' => $data->paginate()], 200);
    }

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required',
            'product_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'error' => 'Validation Error', 'message' => $validator->messages()], 200);
        }

        $lang = 'ar';
        if (!is_null($request->header('lang'))) {
            $lang = $request->header('lang');
        }

        $column = $lang == 'ar' ? 'name_ar' : 'name_en';
        $column_des = $lang == 'ar' ? 'description_ar' : 'description_en';
        $product = Product::where('id',$request->input('product_id'))->first();

        $product2 = Product::where('products.id', $request->input('product_id'))
        ->join('product_countries', 'products.id', '=', 'product_countries.product_id')
        ->where('product_countries.country_id', $request->input('country_id'))
        ->select('products.id', $column . ' as name', 'thumbnail_img', 'featured_img',
            'flash_deal_img', $column_des . ' as description', 'product_countries.unit_price',
            'product_countries.purchase_price', 'product_countries.discount',
            'product_countries.discount_type', 'product_countries.tax',
            'product_countries.tax_type')->latest('product_countries.id')->first();
            
            $variants = $this->variant_price($product->id,$request->input('country_id'));
            $Variations = $variants['variants'];

        $data = [
            'id' => $product->id,
            'name' => $lang=='ar' ? $product->name_ar : $product->name_en,
            'thumbnail_img' => $product->thumbnail_img,
            'photos' => json_decode($product->photos),
            'tags' => $product->tags,
            'description' => $lang=='ar' ? html_entity_decode(strip_tags($product->description_ar)): html_entity_decode(strip_tags($product->description_en)),
            'unit_price' => $variants['unit_price'],
            'main_quantity' => $product->main_quantity,
            'purchase_price' => $product2->purchase_price,
            'discount' => $product2->discount,
            'discount_type' => $product2->discount_type,
            'tax' => $product2->tax,
            'tax_type' => $product2->tax_type,
            'seller_name' => isset($product->user) ? $product->user->name : null,
            'choices' => $product->choices,
            'variations' => $Variations,
            'rating' => $product->rating,
            'reviews' => $product->reviews,
            // 'discount_price' => $product->discount_price,
        ];

        return response()->json(['status' => 200, 'data' => $data], 200);
    }
    
}
