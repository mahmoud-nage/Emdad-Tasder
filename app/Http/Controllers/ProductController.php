<?php

namespace App\Http\Controllers;

use App\Choice;
use App\Color;
use App\Option;
use App\Variation;
use Illuminate\Http\Request;
use App\Product;
use App\Seller;
use App\Category;
use App\Language;
use Auth;
use App\SubSubCategory;
use Illuminate\Support\Facades\DB;
use Session;
use ImageOptimizer;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_products(Request $request)
    {
        $cat = 0;
        $type = 'In House';
        if ($request->has('category_id') && !is_null($request->category_id)) {
            $cat = $request->category_id;
            $products = Product::where('added_by', 'admin')->where('category_id', $request->category_id)->orderBy('created_at', 'desc')->get();
            return view('products.index', compact('products', 'type', 'cat'));
        }
        $products = null;
        return view('products.index', compact('products', 'type', 'cat'));
    }

    public function packages(Request $request)
    {
        $cat = 0;
        $type = 'Packages';
        if ($request->has('category_id') && !is_null($request->category_id)) {
            $cat = $request->category_id;
            $products = Product::where('added_by', 'admin')->where('category_id', $request->category_id)->where('is_package', 1)->orderBy('created_at', 'desc')->get();
            return view('products.index', compact('products', 'type', 'cat'));
        }
        $products = null;
        return view('products.index', compact('products', 'type', 'cat'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function seller_products(Request $request)
    {
        $cat = 0;
        $type = 'Seller';
        $seller_id = $request->has('seller_id') ? $request->seller_id : auth()->user()->id;
        $view = $request->has('seller_id') ? 'sellers.products' : '{{route("seller_products")}}';
        if ($request->has('seller_id') || auth()->user()->user_type != 'admin') {
            $products = Product::where('user_id', $seller_id)->orderBy('id', 'desc')->get();
            $seller = Seller::where('user_id', $seller_id)->first();
            return view($view, compact('products', 'seller', 'type'));
        }
        if ($request->has('category_id') && !is_null($request->category_id)) {
            $cat = $request->category_id;
            $products = Product::where('added_by', 'seller')->where('category_id', $request->category_id)->orderBy('created_at', 'desc')->get();
            return view('products.index', compact('products', 'type', 'cat'));
        }
        $products = null;
        return view('products.index', compact('products', 'type', 'cat'));
    }

    public function seller_pendding_products(Request $request)
    {
        $cat = 0;
        $type = 'Pendding Seller';
        if ($request->has('category_id') && !is_null($request->category_id)) {
            $cat = $request->category_id;
            $products = Product::where('added_by', 'seller')->where('category_id', $request->category_id)->where('published', 0)->orderBy('created_at', 'desc')->get();
            return view('products.index', compact('products', 'type', 'cat'));
        }
        $products = null;
        return view('products.index', compact('products', 'type', 'cat'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'name_ar' => 'required',
            'name_en' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'unit_id' => 'required|exists:units,id',
            'photos.*' => 'required|image|mimes:jpg,jpeg,png,tiff,webp,gif',
            'thumbnail_img' => 'required|image|mimes:jpg,jpeg,png,tiff,webp,gif',
            'featured_img' => 'required|image|mimes:jpg,jpeg,png,tiff,webp,gif',
            'flash_deal_img' => 'required|image|mimes:jpg,jpeg,png,tiff,webp,gif',
            'description_en' => 'required',
            'description_ar' => 'required',
            'Season_msg_ar' => 'required',
            'Season_msg_en' => 'required',
            'Season_from' => 'required|date|before:Season_to',
            'Season_to' => 'required|date|after:Season_from',
            'unit_price' => 'required',
            'tax_type' => 'required_with:tax',
            'discount_type' => 'required_with:discount',
            'choice_ar.*' => 'required_with:choice_no',
            'choice_en.*' => 'required_with:choice_no',
            'choice_options_ar.*' => 'required_with:choice_no',
            'choice_options_.*' => 'required_with:choice_no',
        ]);

        $product = new Product;
        $product->name_ar = $request->name_ar;
        $product->name_en = $request->name_en;
        $product->added_by = $request->added_by;
        $product->user_id = Auth::user()->id;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->unit_id = $request->unit_id;
        $product->tags = implode('|', $request->tags);
        $product->description_ar = $request->description_ar;
        $product->description_en = $request->description_en;
        $product->Season_msg_ar = $request->Season_msg_ar;
        $product->Season_msg_en = $request->Season_msg_en;
        $product->Season_from = strtotime($request->Season_from);
        $product->Season_to = strtotime($request->Season_to);
        $countries = $request->countries;
        $unit_price = $request->unit_price;
        $tax = $request->tax;
        $tax_type = $request->tax_type;
        $discount = $request->discount;
        $discount_type = $request->discount_type;
        $product->shipping_type = $request->shipping_type;
        $product->meta_title = $request->meta_title ? $request->meta_title : $request->name_en;
        $product->meta_description = $request->meta_description ? $request->meta_description : substr($request->description_en, 0, 100);


        $photos = array();
        if ($request->hasFile('photos')) {
            foreach ($request->photos as $key => $photo) {
                $path = 'uploads/products/photos';
                $name = resizeUploadImage($photo, $path, $resize_width = 450, $resize_height = 450);
                array_push($photos, $name);
            }
            $product->photos = json_encode($photos);
        }

        if ($request->hasFile('thumbnail_img')) {
            $path = 'uploads/products/thumbnail';
            $name = resizeUploadImage($request->thumbnail_img, $path, $resize_width = 200, $resize_height = 230);
            $product->thumbnail_img = $name;
        }

        if ($request->hasFile('featured_img')) {
            $path = 'uploads/products/featured';
            $name = resizeUploadImage($request->featured_img, $path, $resize_width = 200, $resize_height = 230);
            $product->featured_img = $name;
        }

        if ($request->hasFile('flash_deal_img')) {
            $path = 'uploads/products/flash_deal';
            $name = resizeUploadImage($request->flash_deal_img, $path, $resize_width = 200, $resize_height = 230);
            $product->flash_deal_img = $name;
        }


        if ($request->shipping_type == 'free') {
            $product->shipping_cost = 0;
        } elseif ($request->shipping_type == 'local_pickup') {
            $product->shipping_cost = $request->local_pickup_shipping_cost;
        } elseif ($request->shipping_type == 'flat_rate') {
            $product->shipping_cost = $request->flat_shipping_cost;
        }

        if ($request->hasFile('meta_img')) {
            $path = 'uploads/products/meta';
            $name = resizeUploadImage($request->meta_img, $path, $resize_width = 200, $resize_height = 230);
            $product->meta_img = $name;
        }

        $product->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . str_random(5);

        $choice_photos = array();
        $choice_options = array();
        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $str_ar = 'choice_options_ar' . $no;
                $str_en = 'choice_options_' . $no;
                $item['name'] = 'choice_' . $no;
                $item['title_ar'] = $request->choice_ar[$key];
                $item['title_en'] = $request->choice[$key];
                $item['options_ar'] = explode('|', implode('|', $request[$str_ar]));
                $item['options_en'] = explode('|', implode('|', $request[$str_en]));
                if (count($request[$str_en]) > 0) {
                    foreach ($request[$str_en] as $option_name) {
                        $name_en = 'choice_photos' . $no . '_' . $option_name;
                        if (isset($request[$name_en]) && $request->hasFile($name_en)) {
                            $photoo = $request[$name_en];
                            $photo = $photoo->store('uploads/products/photos');
                        } else {
                            $photo = null;
                        }
                        $item[$name_en] = isset($photo) ? $photo : null;
                    }
                }
                array_push($choice_options, $item);
                $item = [];
            }
        }

        $product->choice_options = json_encode($choice_options);

        $variations = array();
        //combinations start
        $options = array();
        $options_arr = array();
        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name_en = 'choice_options_' . $no;
                $my_str_en = implode('|', $request[$name_en]);
                $name_ar = 'choice_options_ar' . $no;
                $my_str_ar = implode('|', $request[$name_ar]);
                array_push($options, explode('|', $my_str_en));
                array_push($options_arr, explode('|', $my_str_ar));
            }
        }

        $data = openJSONFile('en');
        $data[$product->name_en] = $product->name_en;
        saveJSONFile('en', $data);

        if ($product->save()) {
            $all_options = json_decode($product->choice_options);


            foreach ($all_options as $key => $option) {
                $choice = Choice::create([
                    'name_ar' => $option->title_ar,
                    'name_en' => $option->title_en,
                    'product_id' => $product->id,
                    'product_country_id' => get_country()->id,
                ]);
                foreach ($option->options_en as $key1 => $option_val) {
                    $name_en = 'choice_photos' . $key . '_' . $option_val;
                    if (isset($option->$name_en)) {
                        $photo = $option->$name_en;
                    } else {
                        $photo = null;
                    }
                    Option::create([
                        'value_en' => $option_val,
                        'value_ar' => $option->options_ar[$key1],
                        'image' => $photo,
                        'choice_id' => $choice->id
                    ]);
                }
            }
            $choices = $product->choices;
            $var_options = array();
            foreach ($choices as $choice) {
                $var_options[] = $choice->options()->pluck('id')->toArray();
            }
            $combinations_var = combinations($var_options);
            foreach ($countries as $country_key => $country) {
                $combinations = combinations($options);
                if (count($combinations[0]) > 0) {
                    foreach ($combinations as $comb_key => $combination) {
                        $str = '';
                        $vars = '';
                        foreach ($combination as $key => $item) {
                            if ($key > 0) {
                                $str .= '-' . str_replace(' ', '', $item);
                                $vars .= '-' . str_replace(' ', '', $item);
                            } else {
                                if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
                                    $vars .= $item;
                                    $color_name = \App\Color::where('code', $item)->first()->name;
                                    $str .= $color_name;
                                } else {
                                    $str .= str_replace(' ', '', $item);
                                    $vars .= str_replace(' ', '', $item);
                                }
                            }
                        }


                        $item = array();
                        $check = isset($request['check_' . str_replace('.', '_', $str)][$country_key]) ? 1 : 0;
                        $item['status'] = $check;
                        $item['price'] = $request['price_' . str_replace('.', '_', $str)][$country_key];
                        $item['sku'] = $request['sku_' . str_replace('.', '_', $str)][$country_key];
//                        $item['qty'] = $request['qty_' . str_replace('.', '_', $str)][$country_key];

                        Variation::create([
                            'choices_values' => json_encode($combinations_var[$comb_key]),
                            'sku' => $item['sku'],
                            'status' => $item['status'],
//                            'qty' => $item['qty'],
                            'price' => $item['price'],
                            'product_id' => $product->id,
                            'product_country_id' => $country,
                        ]);
                        $variations[$str] = $item;
                    }
                }
                if ($country_key == 0) {

                    if (isset($variations) && !is_null($variations)) {
                        $product->variations = json_encode($variations);
                    }
                    $product->update();
                }
                //combinations end

                if ($request->main_quantity) {
                    $product->main_quantity = $request->main_quantity;
                }
                $product->update();

                $product->countries()->attach($countries[$country_key], ['variations' => json_encode($variations), 'unit_price' => $unit_price[$country_key],
                    'discount' => $discount[$country_key], 'discount_type' => $discount_type[$country_key], 'tax' => $tax[$country_key],
                    'tax_type' => $tax_type[$country_key]]);
            }
            flash(__('messages.product_inserted_successfully'))->success();
            if (Auth::user()->user_type == 'admin') {
                return redirect()->route('products.admin');
            } else {
                return redirect()->route('seller_products', get_country()->code)->with('success', __('messages.product_inserted_successfully'));
            }
        } else {
            flash(__('messages.error_msg'))->error();
            return back()->with('danger', __('messages.error_msg'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function admin_product_edit($id)
    {
        $product = Product::findOrFail(decrypt($id));
        //dd(json_decode($product->price_variations)->choices_0_S_price);
        $tags = json_decode($product->tags);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories', 'tags'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function seller_product_edit($id)
    {
        $product = Product::findOrFail(decrypt($id));
        //dd(json_decode($product->price_variations)->choices_0_S_price);
        $tags = json_decode($product->tags);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'name_ar' => 'required',
            'name_en' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'unit_id' => 'required|exists:units,id',
            'photos.*' => 'required_without:previous_photos|image|mimes:jpg,jpeg,png,tiff,webp,gif',
            'thumbnail_img' => 'required_without:previous_thumbnail_img|image|mimes:jpg,jpeg,png,tiff,webp,gif',
            'featured_img' => 'required_without:previous_featured_img|image|mimes:jpg,jpeg,png,tiff,webp,gif',
            'flash_deal_img' => 'required_without:previous_flash_deal_img|image|mimes:jpg,jpeg,png,tiff,webp,gif',
            'meta_img' => 'required_without:previous_meta_img|image|mimes:jpg,jpeg,png,tiff,webp,gif',
            'description_en' => 'required',
            'description_ar' => 'required',
            'Season_msg_ar' => 'required',
            'Season_msg_en' => 'required',
            'Season_from' => '',
            'Season_to' => '',
            'unit_price' => 'required',
            'tax_type' => 'required_with:tax',
            'discount_type' => 'required_with:discount',
        ]);

        $product = Product::findOrFail($id);
        $product->name_ar = $request->name_ar;
        $product->name_en = $request->name_en;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->unit_id = $request->unit_id;
        $product->tags = implode('|', $request->tags);
        $product->description_ar = $request->description_ar;
        $product->description_en = $request->description_en;
        $product->Season_msg_ar = $request->Season_msg_ar;
        $product->Season_msg_en = $request->Season_msg_en;
        $product->Season_from = strtotime($request->Season_from);
        $product->Season_to = strtotime($request->Season_to);
        $countries = $request->countries;
        $unit_price = $request->unit_price;
        $tax = $request->tax;
        $tax_type = $request->tax_type;
        $discount = $request->discount;
        $discount_type = $request->discount_type;
        $product->shipping_type = $request->shipping_type;
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;

        if ($request->has('previous_photos')) {
            $photos = $request->previous_photos;
        } else {
            $photos = array();
        }

        if ($request->hasFile('photos')) {
            foreach ($request->photos as $key => $photo) {
                $path = 'uploads/products/photos';
                $name = resizeUploadImage($photo, $path, $resize_width = 450, $resize_height = 450);
                array_push($photos, $name);
            }
            $product->photos = json_encode($photos);
        }

        if ($request->hasFile('thumbnail_img')) {
            $old_name = $product->thumbnail_img;
            $path = 'uploads/products/thumbnail';
            $name = resizeUploadImage($request->thumbnail_img, $path, $resize_width = 200, $resize_height = 230);
            $product->thumbnail_img = $name;
            deleteImage($old_name);
        }

        if ($request->hasFile('featured_img')) {
            $old_name = $product->featured_img;
            $path = 'uploads/products/featured';
            $name = resizeUploadImage($request->featured_img, $path, $resize_width = 200, $resize_height = 230);
            $product->featured_img = $name;
            deleteImage($old_name);
        }

        if ($request->hasFile('flash_deal_img')) {
            $old_name = $product->flash_deal_img;
            $path = 'uploads/products/flash_deal';
            $name = resizeUploadImage($request->flash_deal_img, $path, $resize_width = 200, $resize_height = 230);
            $product->flash_deal_img = $name;
            deleteImage($old_name);
        }


        if ($request->shipping_type == 'free') {
            $product->shipping_cost = 0;
        } elseif ($request->shipping_type == 'local_pickup') {
            $product->shipping_cost = $request->local_pickup_shipping_cost;
        } elseif ($request->shipping_type == 'flat_rate') {
            $product->shipping_cost = $request->flat_shipping_cost;
        }


        $product->meta_img = $request->previous_meta_img;
        if ($request->hasFile('meta_img')) {
            $old_name = $product->meta_img;
            $path = 'uploads/products/meta';
            $name = resizeUploadImage($request->meta_img, $path, $resize_width = 200, $resize_height = 230);
            $product->meta_img = $name;
            deleteImage($old_name);
        }

        if ($request->hasFile('pdf')) {
            $product->pdf = $request->pdf->store('uploads/products/pdf');
        }

        $product->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . substr($product->slug, -5);

        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $product->colors = json_encode($request->colors);
        } else {
            $colors = array();
            $product->colors = json_encode($colors);
        }

        $choice_options1 = json_decode($product->choice_options);

        $choice_photos = array();
        $choice_options = array();
        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {

                $str_ar = 'choice_options_ar' . $no;
                $str_en = 'choice_options_' . $no;
                $item['name'] = 'choice_' . $no;
                $item['title_ar'] = $request->choice_ar[$key];
                $item['title_en'] = $request->choice[$key];
                $item['options_ar'] = explode('|', implode('|', $request[$str_ar]));
                $item['options_en'] = explode('|', implode('|', $request[$str_en]));
                if (count($request[$str_en]) > 0) {
                    foreach ($request[$str_en] as $key => $option_name) {
                        $name_en = 'choice_photos' . $no . '_' . $key;
                        // dd($name_en);
                        if (isset($request[$name_en]) && $request->hasFile($name_en)) {
                            $photoo = $request[$name_en];
                            $photo = $photoo->store('uploads/products/photos');
                            $path = 'uploads/products/photos';
                            $photo = resizeUploadImage($photoo, $path, $resize_width = 450, $resize_height = 450);

                        } elseif ($request[$name_en] != null && !$request->hasFile($name_en)) {
                            $photo = $request[$name_en];
                        } else {
                            $photo = null;
                        }
                        $item[$name_en] = isset($photo) ? $photo : null;
                    }
                }

                array_push($choice_options, $item);
                $item = [];
            }

        }

        $product->choice_options = json_encode($choice_options);
        $variations = array();
        //combinations start
        $options = array();
        $options_arr = array();

        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name_en = 'choice_options_' . $no;
                $my_str_en = implode('|', $request[$name_en]);
                $name_ar = 'choice_options_ar' . $no;
                $my_str_ar = implode('|', $request[$name_ar]);
                array_push($options, explode('|', $my_str_en));
                array_push($options_arr, explode('|', $my_str_ar));
            }
        }

        if ($product->save()) {
            $all_options = json_decode($product->choice_options);
            $all_colors = json_decode($product->colors);
            $choice_ids = Choice::where('product_id', $product->id)->pluck('id');
            Choice::where('product_id', $product->id)->delete();
            Option::whereIn('id', $choice_ids)->delete();


            foreach ($all_options as $key => $option) {
                $choice = Choice::create([
                    'name_ar' => $option->title_ar,
                    'name_en' => $option->title_en,
                    'product_id' => $product->id,
                    'product_country_id' => get_country()->id,
                ]);
                foreach ($option->options_en as $key1 => $option_val) {
                    $name_en1 = 'choice_photos' . $key . '_' . $key1;
                    if (isset($option->$name_en1)) {
                        $photo = $option->$name_en1;
                    } else {
                        $photo = null;
                    }
                    Option::create([
                        'value_en' => $option_val,
                        'value_ar' => $option->options_ar[$key1],
                        'image' => $photo,
                        'choice_id' => $choice->id
                    ]);
                }
            }

            Variation::where('product_id', $product->id)->delete();
            $choices = $product->choices;
            $var_options = array();
            foreach ($choices as $choice) {
                $var_options[] = $choice->options()->pluck('id')->toArray();
            }
            $combinations_var = combinations($var_options);
            foreach ($countries as $country_key => $country) {
                $combinations = combinations($options);
                if (count($combinations[0]) > 0) {
                    foreach ($combinations as $comb_key => $combination) {
                        $str = '';
                        foreach ($combination as $key => $item) {
                            if ($key > 0) {
                                $str .= '-' . str_replace(' ', '', $item);
                            } else {
                                if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
                                    $color_name = \App\Color::where('code', $item)->first()->name;
                                    $str .= $color_name;
                                } else {
                                    $str .= str_replace(' ', '', $item);
                                }
                            }
                        }
                        $item = array();
                        $check = isset($request['check_' . str_replace('.', '_', $str)][$country_key]) && $request['check_' . str_replace('.', '_', $str)][$country_key] == 'on' ? 1 : 0;
                        $item['status'] = $check;
                        $item['price'] = $request['price_' . str_replace('.', '_', $str)][$country_key];
                        $item['sku'] = $request['sku_' . str_replace('.', '_', $str)][$country_key];
//                        $item['qty'] = $request['qty_' . str_replace('.', '_', $str)][$country_key];
                        $variations[$str] = $item;
                        Variation::create([
                            'choices_values' => json_encode($combinations_var[$comb_key]),
                            'sku' => $item['sku'],
//                            'qty' => $item['qty'],
                            'status' => $item['status'],
                            'price' => $item['price'],
                            'product_id' => $product->id,
                            'product_country_id' => $country,
                        ]);
                    }
                }
                //combinations end
                $product_country = DB::table('product_countries')->where('product_id', $product->id)->where('country_id', $country)->first();
                if (isset($product_country)) {
                    DB::table('product_countries')->where('product_id', $product->id)->where('country_id', $country)->update([
                        'variations' => json_encode($variations),
                        'unit_price' => $unit_price[$country_key],
                        'discount' => $discount[$country_key],
                        'discount_type' => $discount_type[$country_key],
                        'tax' => $tax[$country_key],
                        'tax_type' => $tax_type[$country_key],
                    ]);

                } else {
                    $product->countries()->attach($countries[$country_key], ['variations' => json_encode($variations), 'unit_price' => $unit_price[$country_key],
                        'discount' => $discount[$country_key], 'discount_type' => $discount_type[$country_key], 'tax' => $tax[$country_key],
                        'tax_type' => $tax_type[$country_key]]);
                }
            }
            flash(__('messages.product_updated_successfully'))->success();
            if (Auth::user()->user_type == 'admin') {
                if ($product->is_package) {
                    return redirect()->route('packages.index');
                }
                return redirect()->route('products.admin');
            } else {
                return redirect()->route('seller_products', get_country()->code);
            }
        } else {
            flash(__('messages.error_msg'))->error();
            return back()->with('danger', __('messages.error_msg'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->choices()->count() > 0) {
            foreach ($product->choices as $choise) {
                $choise->options()->delete();
            }
            $product->choices()->delete();

        }

        if ($product->variations()->count() > 0) {
            $product->variations()->delete();
        }


        if (Product::destroy($id)) {

            foreach (Language::all() as $key => $language) {
                $data = openJSONFile($language->code);
                unset($data[$product->name]);
                saveJSONFile($language->code, $data);
            }
            if ($product->thumbnail_img != null) {
                //unlink($product->thumbnail_img);
                deleteImage($product->thumbnail_img);

            }
            if ($product->featured_img != null) {
                //unlink($product->featured_img);
                deleteImage($product->featured_img);

            }
            if ($product->flash_deal_img != null) {
                //unlink($product->flash_deal_img);
                deleteImage($product->flash_deal_img);

            }
            if ($product->photos) {

                foreach (json_decode($product->photos) as $key => $photo) {
                    //unlink($photo);
                    deleteImage($photo);
                }
            }
            flash(__('messages.product_deleted_successfully'))->success();
            if (Auth::user()->user_type == 'admin') {
                return back();
            } else {
                return redirect()->route('seller_products');
            }
        } else {
            flash(__('messages.error_msg'))->error();
            return back()->with('danger', __('messages.error_msg'));
        }
    }

    /**
     * Duplicates the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function duplicate($id)
    {
        $product = Product::find($id);
        $product_new = $product->replicate();
        $product_new->slug = substr($product_new->slug, 0, -5) . str_random(5);

        if ($product_new->save()) {
            flash(__('Product has been duplicated successfully'))->success();
            if (Auth::user()->user_type == 'admin') {
                return redirect()->route('products.admin');
            } else {
                return redirect()->route('seller.products');
            }
        } else {
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    public function get_products_by_subsubcategory(Request $request)
    {
        $products = Product::where('subsubcategory_id', $request->subsubcategory_id)->get();
        return $products;
    }

    public function get_products_by_brand(Request $request)
    {
        $products = Product::where('brand_id', $request->brand_id)->get();
        return view('partials.product_select', compact('products'));
    }

    public function updateTodaysDeal(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->todays_deal = $request->status;
        if ($product->save()) {
            return 1;
        }
        return 0;
    }

    public function updatePublished(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->published = $request->status;
        if ($product->save()) {
            return 1;
        }
        return 0;
    }

    public function updateFeatured(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->featured = $request->status;
        if ($product->save()) {
            return 1;
        }
        return 0;
    }


    public function sku_combination(Request $request)
    {
        $options = array();
        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $colors_active = 1;
            array_push($options, $request->colors);
        } else {
            $colors_active = 0;
        }

        $unit_price = $request->unit_price[0];
        $product_name = $request->name_en;
        $product_id = $request->id;

        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_' . $no;
                $my_str = implode('|', $request[$name]);
                array_push($options, explode('|', $my_str));
            }
        }
        $combinations = combinations($options);

        return view('partials.sku_combinations', compact('combinations', 'unit_price', 'colors_active', 'product_name', 'product_id'));
    }

    public function sku_combination_edit(Request $request)
    {

        $options = array();
        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $colors_active = 1;
            array_push($options, $request->colors);
        } else {
            $colors_active = 0;
        }

        $product_name = $request->name_en;
        $product_id = $request->id;
        $unit_price = $request->unit_price[0];


        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_' . $no;
                $my_str = implode('|', $request[$name]);
                array_push($options, explode(',', $my_str));
            }
        }

        $combinations = combinations($options);

        return view('partials.sku_combinations_edit', compact('combinations', 'unit_price', 'colors_active', 'product_name', 'product_id'));
    }


    public function update_image(Request $request)
    {
        foreach ($request->photos as $photo) {
            resizeUpdateImage($photo, 'uploads/products/thumbnail', 200, 230);
        }
        return redirect()->route('update_image');
    }

}
