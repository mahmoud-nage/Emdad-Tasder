<?php

namespace App\Http\Controllers\API;

use App\Banner;
use App\Blog;
use App\Brand;
use App\Category;
use App\Country;
use App\FlashDeal;
use App\FlashDealProduct;
use App\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Package;
use App\Product;
use App\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 200);
        }

        $lang = 'ar';
        if (!is_null($request->header('lang'))) {
            $lang = $request->header('lang');
        }

        $column = $lang = 'ar' ? 'name_ar' : 'name_en';

        $column_des = $lang = 'ar' ? 'description_ar' : 'description_en';

        $flash_deal = FlashDeal::where('status', 1)->where('start_date', '<=', strtotime(date('d-m-Y')))->where('end_date', '>=', strtotime(date('d-m-Y')))->first();
        if ($flash_deal) {
            $flash_products = FlashDealProduct::where('flash_deal_id', $flash_deal->id)->get();
            $product_ids = FlashDealProduct::where('flash_deal_id', $flash_deal->id)->pluck('product_id')->toArray();

            $flash_deal_products = DB::table('products')->join('product_countries', 'products.id', '=', 'product_countries.product_id')
                ->where('product_countries.country_id', get_country()->id)
                ->whereIn('products.id', $product_ids)
                ->select('products.id', 'products.' . $column . ' as name', 'products.thumbnail_img', 'products.featured_img',
                    'flash_deal_img', $column_des . ' as description', 'product_countries.unit_price', 'product_countries.discount',
                    'product_countries.discount_type', 'rating', 'product_countries.purchase_price', 'products.slug')->latest('product_countries.id')->take(10)->get();


            foreach ($flash_deal_products as $flash_deal_product) {
                $flash_deal_product->discount = $flash_products->where('product_id', $flash_deal_product->id)->pluck('discount')[0];
                $flash_deal_product->discount_type = $flash_products->where('product_id', $flash_deal_product->id)->pluck('discount_type')[0];
            }
        } else {
            $flash_deal_products = [];
        }

        $country = Country::find($request->input('country_id'));
        $todays_deal = $data = DB::table('products')->where('products.todays_deal', '1')->where('products.published', '1')->join('product_countries', 'products.id', '=', 'product_countries.product_id')->where('product_countries.country_id', get_country()->id)
            ->select('products.id', 'products.' . $column . ' as name', 'products.thumbnail_img', 'products.featured_img',
                'flash_deal_img', $column_des . ' as description', 'product_countries.unit_price', 'product_countries.discount',
                'product_countries.discount_type', 'rating', 'product_countries.purchase_price', 'products.slug')->latest('product_countries.id')->take(10)->get();

        $packages = DB::table('products')->where('products.is_package', '1')->where('products.published', '1')->join('product_countries', 'products.id', '=', 'product_countries.product_id')
            ->where('product_countries.country_id', $request->input('country_id'))
            ->where('products.published', '1')
            ->select('products.id', $column . ' as name', 'thumbnail_img', 'featured_img',
                'flash_deal_img', $column_des . ' as description', 'product_countries.unit_price', 'product_countries.discount',
                'product_countries.discount_type', 'rating', 'product_countries.purchase_price')->latest('product_countries.id')->take(4)->get();

        $generalSettings = GeneralSetting::first();
        $generalSettings->secondary_banner = unserialize($generalSettings->secondary_banner);

        $categories = Category::select('id', $column . ' as name', 'banner', 'icon')->get();

        foreach ($categories as $index => $category) {
            $products = DB::table('products')->where('products.category_id', $category->id)
                ->join('product_countries', 'products.id', '=', 'product_countries.product_id')
                ->where('products.published', '1')
                ->where('product_countries.country_id', $request->input('country_id'))
                ->select('products.id', $column . ' as name', 'thumbnail_img', 'featured_img',
                    'flash_deal_img', $column_des . ' as description', 'product_countries.unit_price', 'product_countries.discount',
                    'product_countries.discount_type', 'products.rating')->take(10)->get();
            foreach ($products as $product) {
                $product_new = new Product;
                $price = $product_new->api_get_price($product->id, $request->input('country_id'));
                $product->discount_price = $price['unit_price'];
            }
            $category->products = $products;
            $categories[$index] = $category;
        }
        $newCategories = [];
        foreach ($categories as $index => $category) {
            if (count($category->products) > 0) {
                $newCategories[] = $category;
            }
        }
        $categories = $newCategories;

        $data = [
            'banner' => Banner::where('published', 1)->where('country_id', $request->country_id)->where('type', 'mobile')->where('type1', 0)->where('type2', 0)->select('id', 'photo', 'url')->first(),
            'women_slider' => Slider::where('published', 1)->where('type', 'mobile')->where('country_id', $request->country_id)->where('type1', 2)->where('type2', 0)->select('id', 'photo', 'url')->get(),
            'man_slider' => Slider::where('published', 1)->where('type', 'mobile')->where('country_id', $request->country_id)->where('type1', 1)->where('type2', 0)->select('id', 'photo', 'url')->get(),
            'categories' => $categories,
            'brands' => Brand::select('id', 'name', 'logo')->take(10)->get(),
            'todays_deal' => $todays_deal,
            'flash_deal' => $flash_deal_products,
            'settings' => $generalSettings,
            'blogs' => Blog::orderBy('id', 'desc')->select('id', 'image')->take(5)->get(),
            'packages' => $packages
        ];
        return response()->json(['status' => 200, 'data' => $data], 200);
    }

    public function getBanner()
    {
        $data = [
            'banner' => Banner::where('published', 1)->where('position', 1)->where('type', 'mobile')->select('id', 'photo', 'url')->first()
        ];
        return response()->json(['status' => 200, 'data' => $data], 200);
    }

    public function getSlider()
    {
        $data = [
            'slider' => Slider::where('published', 1)->where('type', 'mobile')->select('id', 'photo')->get(),
        ];
        return response()->json(['status' => 200, 'data' => $data], 200);
    }

    public function getCategories()
    {
        $data = [
            'categories' => Category::where('featured', 1)->where('top', 1)->select('id', 'name', 'banner', 'icon')->get(),
        ];
        return response()->json(['status' => 200, 'data' => $data], 200);
    }

    public function getFeaturedProducts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 200);
        }

        $featured_products = $data = Product::where('featured', 1)->join('product_countries', 'products.id', '=', 'product_countries.product_id')->where('product_countries.country_id', $request->input('country_id'))
            ->select('products.id', 'name', 'thumbnail_img', 'featured_img', 'flash_deal_img', 'description', 'product_countries.unit_price', 'product_countries.discount',
                'product_countries.discount_type', 'products.rating')->latest('product_countries.id');
        $data = [
            'featured_products' => filter_products($featured_products)->limit(6)->get(),
        ];
        return response()->json(['status' => 200, 'data' => $data], 200);
    }

    public function getLatestProducts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 200);
        }

        $latest_products = $data = Product::join('product_countries', 'products.id', '=', 'product_countries.product_id')->where('product_countries.country_id', $request->input('country_id'))
            ->select('products.id', 'name', 'thumbnail_img', 'featured_img', 'flash_deal_img', 'description', 'product_countries.unit_price', 'product_countries.discount',
                'product_countries.discount_type', 'products.rating')->latest('product_countries.id');
        $data = [
            'latest_products' => filter_products($latest_products)->latest('products.id')->limit(20)->get()->shuffle(),
        ];
        return response()->json(['status' => 200, 'data' => $data], 200);
    }

    public function getBestSelling(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 200);
        }

        $best_selling = $data = Product::orderBy('num_of_sale', 'desc')->join('product_countries', 'products.id', '=', 'product_countries.product_id')->where('product_countries.country_id', $request->input('country_id'))
            ->select('products.id', 'name', 'thumbnail_img', 'featured_img', 'flash_deal_img', 'description', 'product_countries.unit_price', 'product_countries.discount',
                'product_countries.discount_type', 'products.rating')->latest('product_countries.id');
        $data = [
            'best_selling' => filter_products($best_selling)->limit(20)->get(),
        ];
        return response()->json(['status' => 200, 'data' => $data], 200);
    }

    public function getTodaysDeal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 200);
        }

        $todays_deal = $data = Product::where('todays_deal', '1')->join('product_countries', 'products.id', '=', 'product_countries.product_id')->where('product_countries.country_id', $request->input('country_id'))
            ->select('products.id', 'name', 'thumbnail_img', 'featured_img', 'flash_deal_img', 'description', 'product_countries.unit_price', 'product_countries.discount',
                'product_countries.discount_type', 'products.rating')->latest('product_countries.id');
        $data = [
            'todays_deal' => filter_products($todays_deal)->get(),
        ];
        return response()->json(['status' => 200, 'data' => $data], 200);
    }

    public function getFlashDeal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 200);
        }

        $flash_ids = FlashDeal::where('status', 1)->where('start_date', '<=', strtotime(date('d-m-Y')))->where('end_date', '>=', strtotime(date('d-m-Y')))->pluck('id')->toArray();
        $product_ids = FlashDealProduct::whereIn('flash_deal_id', $flash_ids)->pluck('product_id')->toArray();
        $flash_deal_products = Product::whereIn('id', $product_ids)->join('product_countries', 'products.id', '=', 'product_countries.product_id')->where('product_countries.country_id', $request->input('country_id'))
            ->select('products.id', 'name', 'thumbnail_img', 'featured_img', 'flash_deal_img', 'description', 'product_countries.unit_price', 'product_countries.discount',
                'product_countries.discount_type', 'products.rating')->latest('product_countries.id')->take(10)->get();
        $data = [
            'flash_deal' => $flash_deal_products,
        ];
        return response()->json(['status' => 200, 'data' => $data], 200);
    }

    public function getBrands()
    {

        $data = [
            'brands' => Brand::where('top', 1)->select('id', 'name', 'logo')->get(),
        ];
        return response()->json(['status' => 200, 'data' => $data], 200);
    }

    public function getSettings()
    {
        $data = [
            'settings' => GeneralSetting::first(),
        ];
        return response()->json(['status' => 200, 'data' => $data], 200);
    }

    public function getNewCollection(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 200);
        }

        $new_collection = $data = Product::whereBetween('products.created_at', [Carbon::now(), Carbon::now()->addDays(20)])->join('product_countries', 'products.id', '=', 'product_countries.product_id')->where('product_countries.country_id', $request->input('country_id'))
            ->select('products.id', 'name', 'thumbnail_img', 'featured_img', 'flash_deal_img', 'description', 'product_countries.unit_price', 'product_countries.discount',
                'product_countries.discount_type', 'products.rating')->latest('product_countries.id');
        $data = [
            'new_collection' => filter_products($new_collection)->get(),
        ];
        return response()->json(['status' => 200, 'data' => $data], 200);
    }

    public function getBlog()
    {
        $data = [
            'blogs' => Blog::orderBy('id', 'desc')->take(5)->get()
        ];
        return response()->json(['status' => 200, 'data' => $data], 200);
    }

    public function newFaceoffers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 200);
        }

        $lang = 'ar';
        if (!is_null($request->header('lang'))) {
            $lang = $request->header('lang');
        }
        $column = $lang = 'ar' ? 'name_ar' : 'name_en';

        $column_des = $lang = 'ar' ? 'description_ar' : 'description_en';

        $banners = \App\Banner::where('type', 'mobile')->where('type1', 2)->pluck('photo')->toArray();
        $sliders = \App\Slider::where('type', 'mobile')->where('type1', 2)->pluck('photo')->toArray();

        $offers = Product::where('products.published', 1)->where('product_countries.discount', '!=', 'NULL')
            ->join('product_countries', 'products.id', '=', 'product_countries.product_id')
            ->where('product_countries.country_id', $request->input('country_id'))
            ->select('products.id', $column . ' as name', 'products.thumbnail_img', 'products.rating', 'products.featured_img',
                'flash_deal_img', $column_des . ' as description', 'product_countries.unit_price',
                'product_countries.purchase_price', 'product_countries.discount',
                'product_countries.discount_type')->latest('product_countries.id')->get();
        foreach ($offers as $offer) {
            $product_new = new Product;
            $price = $product_new->api_get_price($offer->id, $request->input('country_id'));
            $offer->discount_price = $price['unit_price'];
        }
        $data = [
            'offers' => $offers,
            'banners' => $banners,
            'sliders' => $sliders,
        ];
        return response()->json(['status' => 200, 'data' => $data], 200);
    }

}
