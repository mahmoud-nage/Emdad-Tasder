<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shop;
use App\User;
use App\Seller;
use App\BusinessSetting;
use Auth;
use Hash;

class ShopController extends Controller
{

    public function __construct()
    {
        $this->middleware('user', ['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shop = Auth::user()->shop;
        return view('frontend.seller.shop', compact('shop'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::check() && Auth::user()->user_type == 'admin' && Auth::user()->user_type == 'seller'){
            flash(__('Admin can not be a seller'))->error();
            return back();
        }
        else{
            return view('frontend.seller_form');
        }
    }    
    
    public function get_view(Request $request)
    {
        // if($request->has('id')){
            $shop = Shop::where('type', 'admin')->first();
            if($shop){
                return view('admin_shop.index', compact('shop'));
            }
        // }
        // $shop = new Shop;
        //     return view('admin_shop.index', compact('shop'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function set_data(Request $request)
    {

        $this->validate(request(), [
            'logo' => 'required_without:previous_logo|mimes:jpg,jpeg,png,tiff,webp,gif',
            'sliders.*' => 'required_without:previous_sliders|mimes:jpg,jpeg,png,tiff,webp,gif',
            'name' => 'required',
            'address' => 'required',
        ]);
        
                    // dd($request->all());

        
        // if(!$request->has('seller_id')){
        //     $seller = new Seller;
        //     $seller->user_id = $user->id;
        //     $seller->country_id = $request->country_code;
        //     $seller->save();
                
        // if(Shop::where('user_id', $user->id)->first() == null){
        //     $shop = new Shop;
        //     $shop->user_id = $user->id;
        //     $shop->name = $request->name;
        //     $shop->address = $request->address;
        //     $shop->slug = preg_replace('/\s+/', '-', $request->name).'-'.$shop->id;
        //     $shop->meta_title = $request->has('meta_title')?$request->meta_title:$request->name;
        //     $shop->meta_description = $request->has('meta_description')?$request->meta_description:$request->name;

        //     if ($request->hasFile('logo')){
        //         $path = 'uploads/shop/logo';
        //         $name = resizeUploadImage($request->logo, $path, $resize_width = 100, $resize_height = 100);
        //         $shop->logo = $name;
        //     }

        //     if($shop->save()){
        //         auth()->login($user, false);
        //         flash(__('Your Shop has been created successfully!'))->success();
        //         return redirect()->route('shops.index');
        //     }
        // }
        // }else{
            $shop = Shop::find($request->id);
            // dd($shop);
            $shop->name = $request->name;
            $shop->address = $request->address;
            $shop->slug = preg_replace('/\s+/', '-', $request->name).'-'.$shop->id;
            $shop->meta_title = $request->meta_title?$request->meta_title:$request->name;
            $shop->meta_description = $request->meta_description?$request->meta_description:$request->name;
            
            if ($request->hasFile('logo')){
                $old = $shop->logo;
                $path = 'uploads/shop/logo';
                $name = resizeUploadImage($request->logo, $path, $resize_width = 100, $resize_height = 100);
                $shop->logo = $name;
                deleteImage($old);
            }        
            
            
            if($request->has('previous_sliders')){
                $sliders = $request->previous_sliders;
            }else{
                $sliders = array();
            }

            if($request->hasFile('sliders')){
                foreach ($request->sliders as $key => $slider) {
                    $path = 'uploads/shop/sliders';
                    $name = resizeUploadImage($slider, $path, $resize_width = 1400, $resize_height = 400);
                    array_push($sliders, $name);
                }
            }

            $shop->sliders = json_encode($sliders);
        // }
        if($shop->save()){
            flash(__('Your Shop has been updated successfully!'))->success();
            return back();
        }
        
        flash(__('Sorry! Something went wrong.'))->error();
        return back();
    }
    
    public function store(Request $request)
    {

        $this->validate(request(), [
            'address' => 'required',
            'country_code' => 'required|exists:countries,code',
            'logo' => 'required|mimes:jpg,jpeg,png,tiff,webp,gif',
            'sliders' => 'mimes:jpg,jpeg,png,tiff,webp,gif',
        ]);

        $user = null;
        if(!Auth::check()){
            if(User::where('email', $request->email)->first() != null){
                flash(__('Email already exists!'))->error();
                return back();
            }
            if($request->password == $request->password_confirmation){
                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->user_type = "seller";
                $user->country = $request->country_code;
                $user->password = Hash::make($request->password);
                $user->save();
            }
            else{
                flash(__('Sorry! Password did not match.'))->error();
                return back();
            }
        }
        else{
            $user = Auth::user();
            if($user->customer != null){
                $user->customer->delete();
            }
            $user->user_type = "seller";
            $user->country = $request->country_code;
            $user->save();
        }

        if(BusinessSetting::where('type', 'email_verification')->first()->value != 1){
            $user->email_verified_at = date('Y-m-d H:m:s');
            $user->save();
        }

        $seller = new Seller;
        $seller->user_id = $user->id;
        $seller->country_id = $request->country_code;
        $seller->save();
        
                
        $request->session()->put('country', $request->input('country_code'));
        
        if(Shop::where('user_id', $user->id)->first() == null){
            $shop = new Shop;
            $shop->user_id = $user->id;
            $shop->name = $request->name;
            $shop->address = $request->address;
            $shop->slug = preg_replace('/\s+/', '-', $request->name).'-'.$shop->id;
            $shop->meta_title = $request->has('meta_title')?$request->meta_title:$request->name;
            $shop->meta_description = $request->has('meta_description')?$request->meta_description:$request->name;

            if ($request->hasFile('logo')){
                $path = 'uploads/shop/logo';
                $name = resizeUploadImage($request->logo, $path, $resize_width = 100, $resize_height = 100);
                $shop->logo = $name;
            }

            if($shop->save()){
                auth()->login($user, false);
                flash(__('Your Shop has been created successfully!'))->success();
                return redirect()->route('shops.index');
            }
            else{
                $seller->delete();
                $user->user_type == 'customer';
                $user->save();
            }
        }

        flash(__('Sorry! Something went wrong.'))->error();
        return back();
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $country,$id)
    {
        $this->validate(request(), [
            'address' => 'required_without:sliders',
            'country_code' => 'required_without:sliders|exists:countries,code',
            'logo' => 'mimes:jpg,jpeg,png,tiff,webp,gif',
            'sliders.*' => 'mimes:jpg,jpeg,png,tiff,webp,gif',
        ]);

        $shop = Shop::find($id);
        if($request->has('name') && $request->has('address')){
            $shop->name = $request->name;
            $shop->address = $request->address;
            $shop->slug = preg_replace('/\s+/', '-', $request->name).'-'.$shop->id;
            $shop->meta_title = $request->meta_title;
            $shop->meta_description = $request->meta_description;
            if ($request->hasFile('logo')){
                $old = $shop->logo;
                $path = 'uploads/shop/logo';
                $name = resizeUploadImage($request->logo, $path, $resize_width = 100, $resize_height = 100);
                $shop->logo = $name;
                deleteImage($old);
            }
        }

        elseif($request->has('facebook') || $request->has('google') || $request->has('twitter') || $request->has('youtube') || $request->has('instagram')){
            $shop->facebook = $request->facebook;
            $shop->google = $request->google;
            $shop->twitter = $request->twitter;
            $shop->youtube = $request->youtube;
            $shop->instagram = $request->instagram;
        }

        else{
            if($request->has('previous_sliders')){
                $sliders = $request->previous_sliders;
            }
            else{
                $sliders = array();
            }

            if($request->hasFile('sliders')){
                foreach ($request->sliders as $key => $slider) {
                    $path = 'uploads/shop/sliders';
                    $name = resizeUploadImage($slider, $path, $resize_width = 1170, $resize_height = 300);
                    $shop->logo = $name;
                    array_push($sliders, $name);
                }
            }

            $shop->sliders = json_encode($sliders);
        }

        if($shop->save()){
            flash(__('Your Shop has been updated successfully!'))->success();
            return back();
        }

        flash(__('Sorry! Something went wrong.'))->error();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function verify_form(Request $request)
    {
        if(Auth::user()->seller->verification_info == null){
            $shop = Auth::user()->shop;
            return view('frontend.seller.verify_form', compact('shop'));
        }
        else {
            flash(__('Sorry! You have sent verification request already.'))->error();
            return back();
        }
    }

    public function verify_form_store(Request $request)
    {
        $data = array();
        $i = 0;
        foreach (json_decode(BusinessSetting::where('type', 'verification_form')->first()->value) as $key => $element) {
            $item = array();
            if ($element->type == 'text') {
                $item['type'] = 'text';
                $item['label'] = $element->label;
                $item['value'] = $request['element_'.$i];
            }
            elseif ($element->type == 'select' || $element->type == 'radio') {
                $item['type'] = 'select';
                $item['label'] = $element->label;
                $item['value'] = $request['element_'.$i];
            }
            elseif ($element->type == 'multi_select') {
                $item['type'] = 'multi_select';
                $item['label'] = $element->label;
                $item['value'] = json_encode($request['element_'.$i]);
            }
            elseif ($element->type == 'file') {
                $item['type'] = 'file';
                $item['label'] = $element->label;
                $item['value'] = $request['element_'.$i]->store('uploads/verification_form');
            }
            array_push($data, $item);
            $i++;
        }
        $seller = Auth::user()->seller;
        $seller->verification_info = json_encode($data);
        if($seller->save()){
            flash(__('Your shop verification request has been submitted successfully!'))->success();
            return redirect()->route('dashboard');
        }

        flash(__('Sorry! Something went wrong.'))->error();
        return back();
    }
}
