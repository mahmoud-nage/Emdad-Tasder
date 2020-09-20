<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubCategory;
use App\SubSubCategory;
use App\Category;
use App\Product;
use App\Language;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories = SubCategory::all();
        return view('subcategories.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('subcategories.create', compact('categories'));
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
            'icon' => 'required|mimes:jpg,jpeg,png,tiff,webp,gif',
            'banner' => 'required|mimes:jpg,jpeg,png,tiff,webp,gif',
            'name_ar' => 'required',
            'name_en' => 'required',
            'category_id' => 'required',
          ]);

        $subcategory = new SubCategory;
        $subcategory->name_ar = $request->name_ar;
        $subcategory->name_en = $request->name_en;
        $subcategory->category_id = $request->category_id;
        $subcategory->meta_title = $request->meta_title?$request->meta_title:$request->name_en;
        $subcategory->meta_description = $request->meta_description?$request->meta_description:$request->name_en;
        if ($request->slug != null) {
            $subcategory->slug = str_replace(' ', '-', $request->slug);
        }
        else {
            $subcategory->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.str_random(5);
        }
        if ($request->hasFile('icon')) {
            $path = 'uploads/subcategories/icon';
            $name = resizeUploadImage($request->icon, $path, $resize_width = 250, $resize_height = 300);
            $subcategory->icon = $name;
        }
        if ($request->hasFile('banner')) {
            $path = 'uploads/subcategories/banner';
            $name = resizeUploadImage($request->banner, $path, $resize_width = 1350, $resize_height = 300);
            $subcategory->banner = $name;
        }

        $data = openJSONFile('en');
        $data[$subcategory->name_en] = $subcategory->name_en;
        saveJSONFile('en', $data);

        if($subcategory->save()){
            flash(__('Subcategory has been inserted successfully'))->success();
            return redirect()->route('subcategories.index');
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
        $subcategory = SubCategory::findOrFail(decrypt($id));
        $categories = Category::all();
        return view('subcategories.edit', compact('categories', 'subcategory'));
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
            'icon' => 'mimes:jpg,jpeg,png,tiff,webp,gif',
            'banner' => 'mimes:jpg,jpeg,png,tiff,webp,gif',
            'name_ar' => 'required',
            'name_en' => 'required',
            'category_id' => 'required',
          ]);

        $subcategory = SubCategory::findOrFail($id);

        foreach (Language::all() as $key => $language) {
            $data = openJSONFile($language->code);
            unset($data[$subcategory->name]);
            $data[$request->name] = "";
            saveJSONFile($language->code, $data);
        }

        $subcategory->name_ar = $request->name_ar;
        $subcategory->name_en = $request->name_en;
        $subcategory->category_id = $request->category_id;
        $subcategory->meta_title = $request->meta_title;
        $subcategory->meta_description = $request->meta_description;
        if ($request->slug != null) {
            $subcategory->slug = str_replace(' ', '-', $request->slug);
        }
        else {
            $subcategory->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.str_random(5);
        }

        if ($request->hasFile('icon')) {
            $old = $subcategory->icon;
            $path = 'uploads/subcategories/icon';
            $name = resizeUploadImage($request->icon, $path, $resize_width = 250, $resize_height = 350);
            $subcategory->icon = $name;
            deleteImage($old);
        }
        if ($request->hasFile('banner')) {
            $old = $subcategory->banner;
            $path = 'uploads/subcategories/banner';
            $name = resizeUploadImage($request->banner, $path, $resize_width = 1350, $resize_height = 300);
            $subcategory->banner = $name;
            deleteImage($old);
        }


        if($subcategory->save()){
            flash(__('Subcategory has been updated successfully'))->success();
            return redirect()->route('subcategories.index');
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
        $subcategory = SubCategory::findOrFail($id);
        $old = $subcategory->image;
        foreach ($subcategory->subsubcategories as $key => $subsubcategory) {
            $subold = $subsubcategory->image;
            deleteImage($subold);
            $subsubcategory->delete();
        }
        Product::where('subcategory_id', $subcategory->id)->delete();
        if(SubCategory::destroy($id)){
            deleteImage($old);
            foreach (Language::all() as $key => $language) {
                $data = openJSONFile($language->code);
                unset($data[$subcategory->name_en]);
                saveJSONFile($language->code, $data);
            }
            flash(__('Subcategory has been deleted successfully'))->success();
            return redirect()->route('subcategories.index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }


    public function get_subcategories_by_category(Request $request)
    {
        $column = app()->isLocale('ar') ? 'name_ar' : 'name_en';
        $subcategories = SubCategory::where('category_id', $request->category_id)->select('id' , $column .' as name')->get();
        return $subcategories;
    }
}
