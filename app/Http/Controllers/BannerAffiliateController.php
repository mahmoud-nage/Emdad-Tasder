<?php

namespace App\Http\Controllers;

use App\Banner;
use App\BannerAffiliate;
use Illuminate\Http\Request;

class BannerAffiliateController extends Controller
{
    public function index()
    {
        $banners = BannerAffiliate::all();
        return view('banners.index', compact('banners'));
    }

    public function create($position)
    {
        return view('banners.create', compact('position'));
    }

    public function store(Request $request)
    {
        if($request->hasFile('photo')){
            $banner = new Banner;
            $banner->photo = $request->photo->store('uploads/banners');
            $banner->url = $request->url;
            $banner->position = $request->position;
            $banner->save();
            flash(__('Banner has been inserted successfully'))->success();
        }
        return redirect()->route('home_settings.index');
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::find($id);
        $banner->photo = $request->previous_photo;
        if($request->hasFile('photo')){
            $banner->photo = $request->photo->store('uploads/banners');
        }
        $banner->url = $request->url;
        $banner->save();
        flash(__('Banner has been updated successfully'))->success();
        return redirect()->route('home_settings.index');
    }

    public function update_status(Request $request)
    {
        $banner = Banner::find($request->id);
        $banner->published = $request->status;
        if($request->status == 1){
            if(count(Banner::where('published', 1)->where('position', $banner->position)->get()) < 4)
            {
                if($banner->save()){
                    return '1';
                }
                else {
                    return '0';
                }
            }
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

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        if(Banner::destroy($id)){
            //unlink($banner->photo);
            flash(__('Banner has been deleted successfully'))->success();
        }
        else{
            flash(__('Something went wrong'))->error();
        }
        return redirect()->route('home_settings.index');
    }

}
