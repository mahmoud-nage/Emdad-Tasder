<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Product;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::all();
        return view('brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request() , [
            'logo' => 'required|mimes:jpg,jpeg,png,tiff,webp,gif',
            'name' => 'required',
          ]);

        $brand = new Brand;
        $brand->name = $request->name;
        $brand->meta_title = $request->has('meta_title')?$request->meta_title:$request->name;
        $brand->meta_description = $request->has('meta_description')?$request->meta_description:$request->name;
        
        if ($request->slug != null) {
            $brand->slug = str_replace(' ', '-', $request->slug);
        } else {
            $brand->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . str_random(5);
        }
        if ($request->hasFile('logo')) {
            $path = 'uploads/brands';
            $name = resizeUploadImage($request->logo, $path, $resize_width = 210, $resize_height = 70);
            $brand->logo = $name;
        }

        if ($brand->save()) {
            flash(__('Brand has been inserted successfully'))->success();
            return redirect()->route('brands.index');
        } else {
            flash(__('Something went wrong'))->error();
            return back();
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
    public function edit($id)
    {
        $brand = Brand::findOrFail(decrypt($id));
        return view('brands.edit', compact('brand'));
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
        $this->validate(request() , [
            'logo' => 'mimes:jpg,jpeg,png,tiff,webp,gif',
            'name' => 'required',
          ]);

        $brand = Brand::findOrFail($id);
        $brand->name = $request->name;
        $brand->meta_title = $request->meta_title;
        $brand->meta_description = $request->meta_description;
        
        if ($request->slug != null) {
            $brand->slug = str_replace(' ', '-', $request->slug);
        } else {
            $brand->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . str_random(5);
        }
        if ($request->hasFile('logo')) {
            $old_logo = $brand->logo;
            $path = 'uploads/brands';
            $name = resizeUploadImage($request->logo, $path, $resize_width = 210, $resize_height = 70);
            $brand->logo = $name;
            deleteImage($old_logo);
        }

        if ($brand->save()) {
            flash(__('Brand has been updated successfully'))->success();
            return redirect()->route('brands.index');
        } else {
            flash(__('Something went wrong'))->error();
            return back();
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
        $brand = Brand::findOrFail($id);
        Product::where('brand_id', $brand->id)->delete();
        $old_logo = $brand->logo;
        if (Brand::destroy($id)) {
            deleteImage($old_logo);
            flash(__('Brand has been deleted successfully'))->success();
            return redirect()->route('brands.index');
        } else {
            flash(__('Something went wrong'))->error();
            return back();
        }
    }
}
