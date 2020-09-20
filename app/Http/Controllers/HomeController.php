<?php

namespace App\Http\Controllers;

use App\Blog;
use App\BlogDepartment;
use App\Brand;
use App\Category;
use App\Choice;
use App\FlashDeal;
use App\FlashDealProduct;
use App\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SearchController;
use App\Option;
use App\Order;
use App\Product;
use App\Seller;
use App\Shop;
use App\Slider;
use App\SubCategory;
use App\SubSubCategory;
use App\User;
use App\Variation;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use GeoIP;


class HomeController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('home',auth()->user()->country);
            session()->put('country', auth()->user()->country);
        }
        return view('frontend.user_login');
    }

    public function change_country(Request $request)
    {
        $this->validate(request(), [
            'country' => 'required',
        ]);

        $request->session()->put('country', $request->input('country'));
        if($request->has('type') && $request->type){
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('home',$request->input('country'));
    }

    public function registration()
    {
        if (Auth::check()) {
            session()->put('country', auth()->user()->country);
            return redirect()->route('home');
        }
        return view('frontend.user_registration');
    }

    public function cart_login(Request $request)
    {
        $this->validate(request(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::whereIn('user_type', ['customer', 'seller'])->where('email', $request->email)->first();
        if ($user != null) {
            updateCartSetup();
            if (Hash::check($request->password, $user->password)) {
                if ($request->has('remember')) {
                    auth()->login($user, true);
                } else {
                    auth()->login($user, false);
                }
            }
        }
        return back();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_dashboard()
    {
        $categories = \App\Category::all();
        return view('dashboard', compact('categories'));
    }

    /**
     * Show the customer/seller dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        if(Auth::user()->user_type == 'seller') {
            return view('frontend.seller.dashboard');
        }elseif (Auth::user()->user_type == 'customer') {
            return view('frontend.customer.dashboard');
        }else {
            abort(404);
        }
    }

    public function profile(Request $request)
    {
        if (Auth::user()->user_type == 'customer') {
            return view('frontend.customer.profile');
        } elseif (Auth::user()->user_type == 'seller') {
            return view('frontend.seller.profile');
        }
    }

    public function customer_update_profile(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'address' => 'required',
            'area' => 'required',
            'phone' => 'required|min:10',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->area = $request->area;
        $user->zone = $request->zone;
        $user->postal_code = $request->postal_code;
        $user->phone = $request->phone;

        if ($request->new_password != null && ($request->new_password == $request->confirm_password)) {
            $user->password = Hash::make($request->new_password);
        }

        if ($request->hasFile('photo')) {
            $old_logo = $user->avatar;
            $path = 'uploads/users';
            $name = resizeUploadImage($request->photo, $path, $resize_width = 60, $resize_height = 60);
            $user->avatar = $name;
            deleteImage($old_logo);
        }

        if ($user->save()) {
            flash(__('Your Profile has been updated successfully!'))->success();
            return back();
        }

        flash(__('Sorry! Something went wrong.'))->error();
        return back();
    }

    public function seller_update_profile(Request $request)
    {

        $this->validate(request(), [
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'city' => 'required',
            'phone' => 'required|min:10',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;
        $user->phone = $request->phone;

        if ($request->new_password != null && ($request->new_password == $request->confirm_password)) {
            $user->password = Hash::make($request->new_password);
        }

        if ($request->hasFile('photo')) {
            $old_logo = $user->avatar_original;
            $path = 'uploads';
            $name = resizeUploadImage($request->photo, $path, $resize_width = 60, $resize_height = 60);
            $user->avatar_original = $name;
            deleteImage($old_logo);
        }

        $seller = $user->seller;
        $seller->postal_status = $request->postal_status;
        $seller->postal_national_id = $request->postal_national_id;
        $seller->postal_client_name = $request->postal_client_name;
        $seller->vodafone_status = $request->vodafone_status;
        $seller->vodafone_number = $request->vodafone_number;

        $seller->bank_account_status = $request->bank_account_status;
        $seller->bank_name = $request->bank_name;
        $seller->bank_account_username = $request->bank_account_username;
        $seller->bank_account_number = $request->bank_account_number;
        $seller->bank_branch = $request->bank_branch;

        if ($user->save() && $seller->save()) {
            flash(__('Your Profile has been updated successfully!'))->success();
            return back();
        }

        flash(__('Sorry! Something went wrong.'))->error();
        return back();
    }

    /**
     * Show the application frontend home.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
//               $countryShortcode = $request->route('country');  //get country part from url
//               if ($countryShortcode === null) {
////                $geoip = GeoIP::setIp(request()->ip());
//                $geoip = GeoIP::setIp('192.168.1.6');
//                $country_coude = $geoip->getCountryCode();
//                dd($country_coude);
//                $country = \App\Country::where('status',1)->where('code', $country_coude)->first();
//                if($country->count()>0){
//                    session()->put('country', $country->code);
//                    return redirect()->route('home', $country->code);
//                }else{
//                    $country = \App\Country::where('status',1)->where('default', 1)->first();
//                    session()->put('country', $country->code);
//                    return redirect()->route('home', $country->code);
//                }
//
//       }
        $column = app()->isLocale('ar') ? 'name_ar' : 'name_en';
        $column_des = app()->isLocale('ar') ? 'description_ar' : 'description_en';

        $settings = GeneralSetting::first();
        $slider = Slider::where('published', 1)->where('type', 'mobile')->select('id', 'photo')->latest()->take(10)->get();
        $webSlidersMan = Slider::where('published', 1)->where('type', 'web')->where('type2', 2)->select('id', 'photo')->latest()->take(10)->get();
        $webSlidersWomen = Slider::where('published', 1)->where('type', 'web')->where('type2', 1)->select('id', 'photo')->latest()->take(10)->get();

        $todays_deal = $data = DB::table('products')->where('products.published', '1')->where('products.todays_deal', '1')->join('product_countries', 'products.id', '=', 'product_countries.product_id')->where('product_countries.country_id', get_country()->id)
            ->select('products.id', 'products.' . $column . ' as name', 'products.thumbnail_img', 'products.featured_img',
                'flash_deal_img', $column_des . ' as description', 'product_countries.unit_price', 'product_countries.discount',
                'product_countries.discount_type', 'rating', 'product_countries.purchase_price', 'products.slug')->latest('product_countries.id')->take(10)->get();

        $flash_deal_products = [];
        $flash_deal = FlashDeal::where('status', 1)->where('country_id', get_country()->id)->where('start_date', '<=', strtotime(date('d-m-Y')))->where('end_date', '>=', strtotime(date('d-m-Y')))->first();
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
        }

        $categories = Category::all();

        foreach ($categories as $index => $category) {
            $products = DB::table('products')->where('products.published', '1')->where('category_id', $category->id)
                ->join('product_countries', 'products.id', '=', 'product_countries.product_id')
                ->where('product_countries.country_id', get_country()->id)
                ->select('products.id', 'products.' . $column . ' as name', 'products.thumbnail_img', 'products.featured_img',
                    'flash_deal_img', $column_des . ' as description', 'product_countries.unit_price', 'product_countries.discount',
                    'product_countries.discount_type', 'rating', 'product_countries.purchase_price', 'products.slug')->latest('product_countries.id')->take(10)->get();
            $category->products = $products;
            $categories[$index] = $category;
        }
        $newCategories = [];
        foreach ($categories as $index => $category) {
            if (count($category->products) > 0) {
                $newCategories[] = $category;
            }
        }
        $home_categories = $newCategories;

        return view('frontend.index2', compact(['settings', 'slider', 'webSlidersWomen', 'webSlidersMan', 'todays_deal', 'home_categories', 'flash_deal_products']));
    }

    public function trackOrder(Request $request, $country,$order_id = null)
    {
        if ($order_id) {
            $order = Order::where('code', $order_id)->first();
            if ($order != null) {
                return view('frontend.track_order', compact('order'));
            }
        }
        return view('frontend.track_order');
    }

    public function product($country,$slug)
    {
        $product = Product::where('slug', $slug)->first();
        if ($product != null) {
//            updateCartSetup();
            return view('frontend.product_details', compact('product'));
        }
        abort(404);
    }

    public function shop($country,$slug)
    {
        $shop = Shop::where('slug', $slug)->first();
        if ($shop != null) {
            $products = $shop->user->products->where('published', 1)->where('featured', 1);
            return view('frontend.seller_shop', compact('shop', 'products'));
        }
        abort(404);
    }

    public function filter_shop($country,$slug, $type)
    {
        $shop = Shop::where('slug', $slug)->first();
        if ($shop != null && $type != null) {
            return view('frontend.seller_shop', compact('shop', 'type'));
        }
        abort(404);
    }

    public function listing(Request $request)
    {
        $products = filter_products(get_country()->products()->orderBy('created_at', 'desc'))->paginate(20);
        return view('frontend.product_listing', compact('products'));
    }

    public function all_categories(Request $request)
    {
        $type = 1;
        if($request->has('id')){
            $type = 0;
            $records = SubCategory::where('category_id', $request->id)->paginate(12);
        }else{
            $records = Category::paginate(12);
        }
        return view('frontend.all_category', compact('records','type'));
    }

    public function all_brands(Request $request)
    {
        $categories = Category::all();
        return view('frontend.all_brand', compact('categories'));
    }

    public function show_product_upload_form(Request $request)
    {
        $categories = Category::all();
        return view('frontend.seller.product_upload', compact('categories'));
    }

    public function show_product_edit_form(Request $request, $country,$id)
    {
        $categories = Category::all();
        $product = Product::find(decrypt($id));
        return view('frontend.seller.product_edit', compact('categories', 'product'));
    }

    public function seller_product_list(Request $request)
    {
        $products = Product::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
        return view('frontend.seller.products', compact('products'));
    }

    public function ajax_search(Request $request)
    {
        $keywords = array();
        $products = get_country()->products()->where('published', 1)->where('tags', 'like', '%' . $request->search . '%')->get();
        foreach ($products as $key => $product) {
            foreach (explode(',', $product->tags) as $key => $tag) {
                if (stripos($tag, $request->search) !== false) {
                    if (sizeof($keywords) > 5) {
                        break;
                    } else {
                        if (!in_array(strtolower($tag), $keywords)) {
                            array_push($keywords, strtolower($tag));
                        }
                    }
                }
            }
        }

        $products = filter_products(get_country()->products()->where('published', 1)->where('name', 'like', '%' . $request->search . '%'))->get()->take(3);

        $subsubcategories = SubSubCategory::where('name_ar', 'like', '%' . $request->search . '%')->orWhere('name_en', 'like', '%' . $request->search . '%')->get()->take(3);

        $shops = Shop::where('name', 'like', '%' . $request->search . '%')->get()->take(3);

        if (sizeof($keywords) > 0 || sizeof($subsubcategories) > 0 || sizeof($products) > 0 || sizeof($shops) > 0) {
            return view('frontend.partials.search_content', compact('products', 'subsubcategories', 'keywords', 'shops'));
        }
        return '0';
    }

    public function search(Request $request)
    {
        $offers = null;
        $discounts = null;
        $query = $request->q;
        $brand_id = (Brand::where('slug', $request->brand)->first() != null) ? Brand::where('slug', $request->brand)->first()->id : null;
        $sort_by = $request->sort_by;
        $category_id = (Category::where('slug', $request->category)->first() != null) ? Category::where('slug', $request->category)->first()->id : null;
        $subcategory_id = (SubCategory::where('slug', $request->subcategory)->first() != null) ? SubCategory::where('slug', $request->subcategory)->first()->id : null;
        $subsubcategory_id = (SubSubCategory::where('slug', $request->subsubcategory)->first() != null) ? SubSubCategory::where('slug', $request->subsubcategory)->first()->id : null;
        $min_price = $request->min_price;
        $max_price = $request->max_price;
        $seller_id = $request->seller_id;
        $flash_deal = null;

        $rating = (int) $request->rating;

        $conditions = ['published' => 1];

        if ($request->has('offers') && $request->offers != null) {
            $conditions = array_merge($conditions, ['todays_deal' => 1]);
            $offers = 'offers';
        }
        if ($brand_id != null) {
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        }
        if ($category_id != null) {
            $conditions = array_merge($conditions, ['category_id' => $category_id]);
        }
        if ($subcategory_id != null) {
            $conditions = array_merge($conditions, ['subcategory_id' => $subcategory_id]);
        }
        if ($subsubcategory_id != null) {
            $conditions = array_merge($conditions, ['subsubcategory_id' => $subsubcategory_id]);
        }
        if ($seller_id != null) {
            $conditions = array_merge($conditions, ['user_id' => Seller::findOrFail($seller_id)->user->id]);
        }
        if ($request->has('flash_deal') && $request->flash_deal = 'flash_deal') {
            $flash_deal = 'flash_deal';
            $flash_deals = \App\FlashDeal::where('status', 1)->where('country_id', get_country()->id)->first();
            $product_ids = $flash_deals->flash_deal_products->pluck('product_id');
            $productss = get_country()->products()->whereIn('product_id', $product_ids)->where($conditions);
        } elseif ($query != null) {
            $searchController = new SearchController;
            $searchController->store($request);
            $productss = get_country()->products()->where($conditions)->where('name_ar', 'like', '%' . $query . '%')->orWhere('name_en', 'like', '%' . $query . '%');
        } else {
            $productss = get_country()->products()->where($conditions);
        }

        if ($request->has('discounts') && $request->discounts != null) {
            $discounts = 'discounts';
            $productss = $productss->where('product_countries.discount', '>', 0);
        }
        if ($min_price != null && $max_price != null) {
            $productss = $productss->where('product_countries.unit_price', '>=', $min_price)->where('product_countries.unit_price', '<=', $max_price);
        }

        if ($sort_by != null) {
            switch ($sort_by) {
                case '1':
                    $productss->orderBy('created_at', 'desc');
                    break;
                case '2':
                    $productss->orderBy('created_at', 'asc');
                    break;
                case '3':
                    $productss->orderBy('product_countries.unit_price', 'asc');
                    break;
                case '4':
                    $productss->orderBy('product_countries.unit_price', 'desc');
                    break;
                default:
                    // code...
                    break;
            }
        }
        if ($rating != null) {

            switch ($rating) {
                case '1':
                    $productss->orderBy('rating', 'asc');
                    break;
                case '5':
                    $productss->orderBy('rating', 'desc');
                    break;
                default:
                    // code...
                    break;
            }
        }

        $productss = filter_products($productss)->paginate(12)->appends(request()->query());
        return view('frontend.product_listing', compact('productss', 'query', 'flash_deal', 'offers', 'discounts', 'category_id', 'rating', 'subcategory_id', 'subsubcategory_id', 'brand_id', 'sort_by', 'seller_id', 'min_price', 'max_price'));

    }

    public function product_content(Request $request)
    {
        $connector = $request->connector;
        $selector = $request->selector;
        $select = $request->select;
        $type = $request->type;
        productDescCache($connector, $selector, $select, $type);
    }

    public function home_settings(Request $request)
    {
        return view('home_settings.index');
    }

    public function top_10_settings(Request $request)
    {
        foreach (Category::all() as $key => $category) {
            if (in_array($category->id, $request->top_categories)) {
                $category->top = 1;
                $category->save();
            } else {
                $category->top = 0;
                $category->save();
            }
        }

        foreach (Brand::all() as $key => $brand) {
            if (in_array($brand->id, $request->top_brands)) {
                $brand->top = 1;
                $brand->save();
            } else {
                $brand->top = 0;
                $brand->save();
            }
        }

        flash(__('Top 10 categories and brands have been updated successfully'))->success();
        return redirect()->route('home_settings.index');
    }

    public function variant_price(Request $request)
    {
        $arr = [];
        $product = Product::find($request->id);
        $product_country = \Illuminate\Support\Facades\DB::table('product_countries')->where('product_id', $product->id)->where('country_id', get_country()->id)->first();
        $quantity = 0;
        $chosen_variation = null;
        $a = array();
        // dd($request->options);
        if ($request->has('options')) {
            $options = $request->input('options');
            $case = 0;
            if (count($options) > 0) {
                $product_variations = Variation::where('product_id', $product->id)->where('product_country_id', get_country()->id)->get();
                foreach ($product_variations as $variation) {
                    $arr = json_decode($variation->choices_values);
                    foreach ($options as $option) {
                        $op = (int) $option;
                        if (in_array($op, $arr)) {
                            $case++;
                        }
                    }
                    if ($case == count($arr)) {
                        $chosen_variation = $variation;
                        break;
                    } else {
                        $case = 0;
                    }
                    // $a[$key] = array('price' => $case, 'pro' => count($arr));
                    // if ($case == true) {
                    //     $chosen_variation = $variation;
                    //     // continue;
                    // }
                }
                // return array('pro' => $a);
            }
        }
        // return array('pro' => $chosen_variation);
$discount = 0 ;
        if ($chosen_variation != null) {
            $price = $chosen_variation->price;
            $quantity = $chosen_variation->qty;
        } else {
            $price = $product_country->unit_price;
            $quantity = count(Variation::where('product_id', $product->id)->where('product_country_id', get_country()->id)->get()) > 0 ? Variation::where('product_id', $product->id)->where('product_country_id', get_country()->id)->sum('qty') : $product->main_quantity;
        }
        //discount calculation
        $flash_deal = \App\FlashDeal::where('status', 1)->where('country_id', get_country()->id)->first();
        if ($flash_deal != null && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first() != null) {
            $flash_deal_product = \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->where('country_id', get_country()->id)->first();
            if ($flash_deal_product->discount_type == 'percent') {
                $discount = ($price * $flash_deal_product->discount) / 100;
                $price -= $discount;
            } elseif ($flash_deal_product->discount_type == 'amount') {
                $discount = $flash_deal_product->discount;
                $price -= $discount;
            }
        } else {
            if ($product_country->discount_type == 'percent') {
                $discount = ($price * $product_country->discount) / 100;
                $price -= $discount;
                } elseif ($product_country->discount_type == 'amount') {
                $discount = $product_country->discount;
                $price -= $discount;
            }
        }

        if ($product_country->tax_type == 'percent') {
            $price += ($price * $product_country->tax) / 100;
        } elseif ($product_country->tax_type == 'amount') {
            $price += $product_country->tax;
        }

        return array('unit' => single_price($price), 'price' => single_price($price * $request->quantity), 'quantity' => $quantity, 'discount' => single_price($discount * $request->quantity));
    }

    public function variant_options(Request $request)
    {
        $chi_options = array();
        $product = Product::find($request->id);
        $product_country = \Illuminate\Support\Facades\DB::table('product_countries')->where('product_id', $product->id)->where('country_id', get_country()->id)->first();
        $quantity = 0;
        $chosen_variation = null;

        if ($request->input('option')) {
            $option = $request->input('option');
            $case = false;

            if ($option) {
                $product_variations = Variation::where('product_id', $product->id)->where('product_country_id', get_country()->id)->get();
                foreach ($product_variations as $variation) {
                    $arr = json_decode($variation->choices_values);
                    $case = in_array($option, $arr);
                    if ($case == true && $variation->status == 1) {
                        foreach ($arr as $opt) {
                            if ($opt != $option) {
                                $chi_options[] = Option::find($opt);
                            }
                            $case = false;
                        }
                    }
                }
            }

        }

        // if ($chosen_variation != null) {
        //     $price = $chosen_variation->price;
        //     $quantity = $chosen_variation->qty;
        // } else {
        //     $price = $product_country->unit_price;
        // }
        //discount calculation
        return view('frontend.partials.variant_options')->with(['options' => $chi_options, 'choice' => $request->choice + 1, 'product' => $request->id]);
    }

    public function main_banners(Request $request)
    {
//        dd($request->input('secondary_banner'));
        $settings = GeneralSetting::first();
        $settings->update(['main_banner' => $request->input('main_banner'),
            'secondary_banner' => serialize($request->input('secondary_banner'))]);
        flash(__('Banners updated successfully'))->success();
        return redirect()->route('home_settings.index');
    }

    public function sellerpolicy()
    {
        return view("frontend.policies.sellerpolicy");
    }

    public function returnpolicy()
    {
        return view("frontend.policies.returnpolicy");
    }

    public function supportpolicy()
    {
        return view("frontend.policies.supportpolicy");
    }

    public function terms()
    {
        return view("frontend.policies.terms");
    }

    public function privacypolicy()
    {
        return view("frontend.policies.privacypolicy");
    }

    /**
     * Show the application frontend home.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function blog()
    {
        $blogSliders = Blog::orderBy('id', 'desc')->take(4)->get();
        $blogDepartments = BlogDepartment::with('blogs')->get();
        $blogs = Blog::orderBy('created_at', 'desc')->get();
        $moreReads = Blog::orderBy('read_number', 'desc')->take(3)->get();
        $otherBlogs = Blog::inRandomOrder()->limit(5)->get();
        return view('frontend.blog', compact(['blogSliders', 'blogs', 'blogDepartments', 'moreReads', 'otherBlogs']));
    }

    /**
     * Show the application frontend home.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function blogShow($country,$id)
    {
        $blogSliders = Blog::orderBy('id', 'desc')->take(4)->get();
        $blogshow = Blog::find($id);
        if (!is_null($blogshow->read_number)) {
            $number = $blogshow->read_number + 1;
        } else {
            $number = 1;
        }

        $blogshow->update(['read_number' => $number]);
        $blogDepartments = BlogDepartment::with('blogs')->get();
        $blogs = Blog::orderBy('created_at', 'desc')->get();
        $moreReads = Blog::orderBy('read_number', 'desc')->take(3)->get();
        $otherBlogs = Blog::inRandomOrder()->limit(5)->get();
        return view('frontend.single_blog', compact(['blogshow', 'blogSliders', 'blogs', 'blogDepartments', 'moreReads', 'otherBlogs']));
    }

}
