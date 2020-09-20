<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;
use App\Seller;
use App\User;
use App\Shop;
use App\Product;
use App\Order;
use App\OrderDetail;
use Illuminate\Support\Facades\Hash;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(Blog::select("*")->get()->toArray());
        $blogs = Blog::orderBy('id', 'desc')->get();
        return view('blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.create');
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
            'image' => 'required|mimes:jpg,jpeg,png,tiff,webp,gif',
            'article' => 'required',
            'article_ar' => 'required',
            'title' => 'required',
            'title_ar' => 'required',
            'blog_department_id' => 'required',
            'author_name_en' => 'required',
            'author_name_ar' => 'required',
            'author_title_en' => 'required',
            'author_title_ar' => 'required',
            'video' => 'required|url',
          ]);

        $blog = Blog::create($request->all());
        if ($request->hasFile('image')) {
            $path = 'uploads/blog/'.$blog->id;
            $image = resizeUploadImage($request->image, $path, $resize_width = 132, $resize_height = 132); // 410*270   850*300
            $thumb = resizeUploadImage($request->image, $path, $resize_width = 410, $resize_height = 270); // 410*270   850*300
            $slider = resizeUploadImage($request->image, $path, $resize_width = 850, $resize_height = 350); // 410*270   850*350
            $blog->update(['image'=>$image, 'thumb' => $thumb, 'slider' => $slider]);
        }
        if(isset($blog)){
            flash(__('Blog has been inserted successfully'))->success();
            return redirect()->route('blog.index');
        }

        flash(__('Something went wrong'))->error();
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
        $blog = Blog::findOrFail(decrypt($id));
        return view('blog.edit', compact('blog'));
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
            'image' => 'mimes:jpg,jpeg,png,tiff,webp,gif',
          ]);

        $blog = Blog::findOrFail($id);
        $update = $blog->update($request->except('_method', '_token'));
        
        if ($request->hasFile('image')) {
            $old_slider = $blog->slider;
            $old_image = $blog->image;
            $old_thumb = $blog->thumb;
            $path = 'uploads/blog/'.$blog->id;
            $image = resizeUploadImage($request->image, $path, $resize_width = 132, $resize_height = 132); // 410*270   850*300
            $thumb = resizeUploadImage($request->image, $path, $resize_width = 410, $resize_height = 270); // 410*270   850*300
            $slider = resizeUploadImage($request->image, $path, $resize_width = 850, $resize_height = 350); // 410*270   850*350
            $blog->update(['image'=>$image, 'thumb' => $thumb, 'slider' => $slider]);
            deleteImage($old_slider);
            deleteImage($old_image);
            deleteImage($old_thumb);
        }

        if($update){
            flash(__('Blog has been updated successfully'))->success();
            return redirect()->route('blog.index');
        }

        flash(__('Something went wrong'))->error();
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
        $blog = Blog::find($id);
        $old_slider = $blog->slider;
        $old_image = $blog->image;
        $old_thumb = $blog->thumb;
        if(Blog::destroy($id)){
            deleteImage($old_slider);
            deleteImage($old_image);
            deleteImage($old_thumb);
            flash(__('Blog has been deleted successfully'))->success();
            return redirect()->route('blog.index');
        }
        flash(__('Something went wrong'))->error();
        return back();
    }

}
