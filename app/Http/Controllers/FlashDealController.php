<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FlashDeal;
use App\FlashDealProduct;
use Illuminate\Support\Facades\DB;

class FlashDealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $flash_deals = FlashDeal::all();
        return view('flash_deals.index', compact('flash_deals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('flash_deals.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request() , [
            'title_ar' => 'required',
            'title_en' => 'required',
            'country_id' => 'required|exists:countries,id',
            'start_date' => 'required',
            'end_date' => 'required',
            'product_countries.*' => 'required',
            'photo' => 'required|image|mimes:jpg,jpeg,png,tiff,webp,gif',
          ]);

        $flash_deal = new FlashDeal;
        $flash_deal->title_ar = $request->title_ar;
        $flash_deal->title_en = $request->title_en;
        $flash_deal->country_id = $request->country_id;
        $flash_deal->start_date = strtotime($request->start_date);
        $flash_deal->end_date = strtotime($request->end_date);
        if ($request->hasFile('photo')) {
            $path = 'uploads/deals';
            $name = resizeUploadImage($request->photo, $path, $resize_width = 200, $resize_height = 200);
            $flash_deal->photo = $name;
        }
        if($flash_deal->save()){
            foreach ($request->product_countries as $key => $product) {
                $productCountry = DB::table('product_countries')->find($product);
                $flash_deal_product = new FlashDealProduct;
                $flash_deal_product->flash_deal_id = $flash_deal->id;
                $flash_deal_product->product_id = $productCountry->product_id;
                $flash_deal_product->country_id = $productCountry->country_id;
                $flash_deal_product->discount = $request['discount_'.$product];
                $flash_deal_product->discount_type = $request['discount_type_'.$product];
                $flash_deal_product->save();
            }
            flash(__('Flash Deal has been inserted successfully'))->success();
            return redirect()->route('flash_deals.index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $flash_deal = FlashDeal::findOrFail(decrypt($id));
        return view('flash_deals.edit', compact('flash_deal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(request() , [
            'title_ar' => 'required',
            'title_en' => 'required',
            'country_id.*' => 'required|exists:countries,id',
            'start_date' => 'required',
            'end_date' => 'required',
            'product_countries.*' => 'required',
            'photo' => 'image|mimes:jpg,jpeg,png,tiff,webp,gif',

        ]);

        $flash_deal = FlashDeal::findOrFail($id);
        $flash_deal->title_ar = $request->title_ar;
        $flash_deal->title_en = $request->title_en;
        $flash_deal->country_id = $request->country_id;
        $flash_deal->start_date = strtotime($request->start_date);
        $flash_deal->end_date = strtotime($request->end_date);
        if ($request->hasFile('photo')) {
            $old_name = $flash_deal->photo;
            $path = 'uploads/deals';
            $name = resizeUploadImage($request->photo, $path, $resize_width = 200, $resize_height = 200);
            $flash_deal->photo = $name;
            deleteImage($old_name);
        }
        foreach ($flash_deal->flash_deal_products as $key => $flash_deal_product) {
            $flash_deal_product->delete();
        }
        if($flash_deal->save()){
            foreach ($request->product_countries as $key => $product) {
                $productCountry = DB::table('product_countries')->find($product);
                $flash_deal_product = new FlashDealProduct;
                $flash_deal_product->flash_deal_id = $flash_deal->id;
                $flash_deal_product->product_id = $productCountry->product_id;
                $flash_deal_product->country_id = $productCountry->country_id;
                $flash_deal_product->discount = $request['discount_'.$product];
                $flash_deal_product->discount_type = $request['discount_type_'.$product];
                $flash_deal_product->save();
            }
            flash(__('Flash Deal has been updated successfully'))->success();
            return redirect()->route('flash_deals.index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $flash_deal = FlashDeal::findOrFail($id);
        foreach ($flash_deal->flash_deal_products as $key => $flash_deal_product) {
            $flash_deal_product->delete();
        }
        if(FlashDeal::destroy($id)){
            flash(__('FlashDeal has been deleted successfully'))->success();
            return redirect()->route('flash_deals.index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    public function update_status(Request $request)
    {
        $flash_deal = FlashDeal::findOrFail($request->id);
        $flash_deal->status = $request->status;
        if($flash_deal->save()){
            flash(__('Flash deal status updated successfully'))->success();
            return 1;
        }
        return 0;
    }

    public function product_discount(Request $request){
        $product_ids = $request->product_ids;
        return view('partials.flash_deal_discount', compact('product_ids'));
    }

    public function product_discount_edit(Request $request){
        $product_ids = $request->product_ids;
        $flash_deal_id = $request->flash_deal_id;
        return view('partials.flash_deal_discount_edit', compact('product_ids', 'flash_deal_id'));
    }

    public function flash_deal_country_products(Request $request)
    {
        // dd($request->country_id);
        if($request->has('country_id') && !is_null($request->country_id)){
            $cat = $request->country_id;
            $country_name = \App\Country::find($request->country_id)->name_en;
            $product_cantries = \Illuminate\Support\Facades\DB::table('product_countries')->where('country_id', $request->country_id)->latest()->get();
            foreach($product_cantries as $product_cantry){

            $product = \App\Product::find($product_cantry->product_id);
            $data[] = [
                'name_en' => $product->name_en,
                'country_name' => $country_name,
                'id' => $product_cantry->id,
            ];
            }
            return response()->json(['status' => 200, 'data' => $data]);
        }
    }

}
