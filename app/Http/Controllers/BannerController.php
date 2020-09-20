<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banner;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::all();
        return view('banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($position, Request $request)
    {
        $type = request()->input('type');
        $type1 = request()->input('type1');
        $type2 = request()->input('type2');
        return view('banners.create', compact('position' , 'type', 'type1', 'type2'));
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
            'photo' => 'required|mimes:jpg,jpeg,png,tiff,webp,gif',
            'position' => 'required',
            'url' => 'required',
            'country_id' => 'required|exists:countries,id',
          ]);

        if($request->hasFile('photo')){
            $banner = new Banner;

            $path = 'uploads/banners';
            if($request->position == 1){
                $name = resizeUpdateImage($request->photo, $path, 300,260);
            }elseif($request->position == 2){
                $name = resizeUpdateImage($request->photo, $path, 630,260);
            }elseif($request->position == 3){
                $name = resizeUpdateImage($request->photo, $path, 450,200);
            }elseif($request->position == 4){
                $name = resizeUpdateImage($request->photo, $path, 230,200);
            }elseif($request->position == 5){
                $name = resizeUpdateImage($request->photo, $path, 1100,270);
            }
            $banner->photo = $name;
            $banner->position = $request->position;
            $banner->country_id = $request->country_id;
            $banner->url = $request->url;
            $banner->type = $request->input('type') ? $request->input('type') : 'web';
            $banner->type1 = $request->input('type1') ? $request->input('type1') : 0;
            $banner->type2 = $request->input('type2') ? $request->input('type2') : 0;
            
            $banner->save();
            flash(__('Banner has been inserted successfully'))->success();
        }
        return redirect()->back();
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
        $banner = Banner::findOrFail($id);
        return view('banners.edit', compact('banner'));
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
            'photo' => 'required_without:previous_photo|mimes:jpg,jpeg,png,tiff,webp,gif',
            'url' => 'required',
          ]);

        $banner = Banner::find($id);
        $banner->photo = $request->previous_photo;
        if($request->hasFile('photo')){
            $path = 'uploads/banners';

            if($banner->position == 1){
                $name = resizeUpdateImage($request->photo, $path, 300,260);
            }elseif($banner->position == 2){
                $name = resizeUpdateImage($request->photo, $path, 630,260);
            }elseif($banner->position == 3){
                $name = resizeUpdateImage($request->photo, $path, 450,200);
            }elseif($banner->position == 4){
                $name = resizeUpdateImage($request->photo, $path, 230,200);
            }elseif($request->position == 5){
                $name = resizeUpdateImage($request->photo, $path, 1100,270);
            }
            $banner->photo = $name;
        }
        $banner->url = $request->url;
        $banner->save();
        flash(__('Banner has been updated successfully'))->success();
        return redirect()->route('home_settings.index');
    }


    public function update_status(Request $request)
    {
        $this->validate(request() , [
            'id' => 'required',
            'status' => 'required',
          ]);

        $banner = Banner::find($request->id);
        $banner->published = $request->status;
        if($request->status == 1){
            // if(count(Banner::where('published', 1)->where('position', $banner->position)->get()) < 4)
            // {
                if($banner->save()){
                    return '1';
                }
                else {
                    return '0';
                }
            // }
        }
        else{
            if($banner->save()){
                return '1';
            }
            else {
                return '0';
            }
        }

        return '0';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        if(Banner::destroy($id)){
            deleteImage($banner->photo);
            flash(__('Banner has been deleted successfully'))->success();
        }
        else{
            flash(__('Something went wrong'))->error();
        }
        return redirect()->route('home_settings.index');
    }
}
