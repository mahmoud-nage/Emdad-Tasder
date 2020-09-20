<?php

namespace App\Http\Controllers;

use App\Category;
use App\HomeCategory;
use App\Language;
use App\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
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
            'icon' => 'required|mimes:jpg,jpeg,png,tiff,webp,gif',
            'banner' => 'required|mimes:jpg,jpeg,png,tiff,webp,gif',
            'name_ar' => 'required',
            'name_en' => 'required',
          ]);
        $category = new Category;
        $category->name_ar = $request->name_ar;
        $category->name_en = $request->name_en;
        $category->meta_title = $request->meta_title?$request->meta_title:$request->name_en;
        $category->meta_description = $request->meta_description?$request->meta_description:$request->name_en;
        if ($request->slug != null) {
            $category->slug = str_replace(' ', '-', $request->slug);
        }else {
            $category->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . str_random(5);
        }
        if ($request->hasFile('banner')) {
            $path = 'uploads/categories/banner';
            $name = resizeUploadImage($request->banner, $path, $resize_width = 1350, $resize_height = 300);
            $category->banner = $name;
        }
        if ($request->hasFile('icon')){
            $path = 'uploads/categories/icon';
            $name = resizeUploadImage($request->icon, $path, $resize_width = 250, $resize_height = 300);
            $category->icon = $name;
        }

        if ($category->save()) {
            flash(__('Category has been inserted successfully'))->success();
            return redirect()->route('categories.index');
        } else {
            dd($category);
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
        $category = Category::findOrFail(decrypt($id));
        return view('categories.edit', compact('category'));
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
            'icon' => 'required|mimes:jpg,jpeg,png,tiff,webp,gif',
            'banner' => 'required|mimes:jpg,jpeg,png,tiff,webp,gif',
            'name_ar' => 'required',
            'name_en' => 'required',
          ]);

        $category = Category::findOrFail($id);

        foreach (Language::all() as $key => $language) {
            $data = openJSONFile($language->code);
            unset($data[$category->name]);
            $data[$request->name] = "";
            saveJSONFile($language->code, $data);
        }

        $category->name_ar = $request->name_ar;
        $category->name_en = $request->name_en;
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;

        if ($request->slug != null) {
            $category->slug = str_replace(' ', '-', $request->slug);
        } else {
            $category->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . str_random(5);
        }

        if ($request->hasFile('banner')) {
            $old = $category->banner;
            $path = 'uploads/categories/banner';
            $name = resizeUploadImage($request->banner, $path, $resize_width = 1350, $resize_height = 300);
            $category->banner = $name;
            deleteImage($old);
        }
        if ($request->hasFile('icon')){
            $old = $category->icon;
            $path = 'uploads/categories/icon';
            $name = resizeUploadImage($request->icon, $path, $resize_width = 250, $resize_height = 300);
            $category->icon = $name;
            deleteImage($old);
        }

        if ($category->save()) {
            flash(__('Category has been updated successfully'))->success();
            return redirect()->route('categories.index');
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
        $category = Category::findOrFail($id);
        foreach ($category->subcategories as $key => $subcategory) {
            $subold = $subcategory->image;
            deleteImage($subold);
            $subsubcategory->delete();

            foreach ($subcategory->subsubcategories as $key => $subsubcategory) {
                $subold = $subsubcategory->image;
                deleteImage($subold);
                $subsubcategory->delete();
            }
            $subcategory->delete();
        }
        Product::where('category_id', $category->id)->delete();
        HomeCategory::where('category_id', $category->id)->delete();
        $banner = $category->banner;
        $icon = $category->icon;
        if (Category::destroy($id)) {
            foreach (Language::all() as $key => $language) {
                $data = openJSONFile($language->code);
                unset($data[$category->name]);
                saveJSONFile($language->code, $data);
            }
            if (file_exists($banner)) {
                deleteImage($banner);
            }
            if (file_exists($icon)) {
                deleteImage($icon);
            }
            flash(__('Category has been deleted successfully'))->success();
            return redirect()->route('categories.index');
        } else {
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    public function updateFeatured(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->featured = $request->status;
        if ($category->save()) {
            return 1;
        }
        return 0;
    }

        public function vendor_commission_update(Request $request)
    {
        if($request->has('ids')){
            foreach($request->ids as $key => $id){
                Category::where('id',$id)->update(['vendor_commission' => $request->vendor_commission[$key]]);
            }
            flash(__('Category Vendor Commission has been updated successfully'))->success();
            return back();
        } else {
            flash(__('Something went wrong'))->error();
            return back();
        }
    }
}
