<?php

namespace App\Http\Controllers;

use App\BlogDepartment;
use Illuminate\Http\Request;
use App\Seller;
use App\User;
use App\Shop;
use App\Product;
use App\Order;
use App\OrderDetail;
use Illuminate\Support\Facades\Hash;

class BlogDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogDepartments = BlogDepartment::orderBy('id', 'desc')->get();
        return view('blogDepartments.index', compact('blogDepartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blogDepartments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $blogDepartment = BlogDepartment::create([
            'name_ar' => $request->input('name_ar'),
            'name_en'=>$request->input('name_en')
        ]);

        if(isset($blogDepartment)){
            flash(__('BlogDepartment has been inserted successfully'))->success();
            return redirect()->route('blogDepartment.index');
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
        $blog_dep = BlogDepartment::findOrFail(decrypt($id));
        return view('blogDepartments.edit', compact('blog_dep'));
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
        $blog = BlogDepartment::findOrFail($id);
        $update = $blog->update($request->except('_method', '_token'));
        if($update){
            flash(__('Blog has been updated successfully'))->success();
            return redirect()->route('blogDepartment.index');
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
        $blog_dep = BlogDepartment::find($id);
 

        if(BlogDepartment::destroy($id)){
            $blog_dep->blogs()->delete();
            flash(__('Blog has been deleted successfully'))->success();
            return redirect()->route('blogDepartment.index');
        }
        flash(__('Something went wrong'))->error();
        return back();
    }

}
