<?php

namespace App\Http\Controllers;

use App\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Gallery::all();
        return view('galleries.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('galleries.create');
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
            'name_ar' => 'required',
            'name_en' => 'required',
            'desc_ar' => 'required',
            'desc_en' => 'required',
            'video_link' => 'url',
            'photos.*' => 'required|image|mimes:jpg,jpeg,png,tiff,webp,gif',
        ]);
        $record = Gallery::create($request->except('photos'));

        $photos =[];
        if ($request->hasFile('photos')) {
            foreach ($request->photos as $key => $photo) {
                $path = 'uploads/galleries';
                $name = resizeUploadImage($photo, $path, $resize_width = 570, $resize_height = 300);
                array_push($photos, $name);
            }
            $record->photos = json_encode($photos);
            $record->save();
        }

        if ($record) {
            flash(__('Gallery has been inserted successfully'))->success();
            return redirect()->route('galleries.index');
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
        $record = Gallery::find($id);
        return view('frontend.galleries.singel_gallery',compact('record'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = Gallery::findOrFail(decrypt($id));
        return view('galleries.edit', compact('record'));
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
            'photo.*' => 'image|mimes:jpg,jpeg,png,tiff,webp,gif',
            'video_link' => 'url',
        ]);

        $event = Gallery::find($id);
        $record = $event->update($request->except('_token', '_method','photos','previous_photos'));

        if ($request->has('previous_photos')) {
            $photos = $request->previous_photos;
        } else {
            $photos = array();
        }

        if ($request->hasFile('photos')) {
            foreach ($request->photos as $key => $photo) {
                $path = 'uploads/galleries';
                $name = resizeUploadImage($photo, $path, $resize_width = 570, $resize_height = 300);
                array_push($photos, $name);
            }
            $event->photos = json_encode($photos);
        }


        if ($event->save()) {
            flash(__('Gallery has been updated successfully'))->success();
            return redirect()->route('galleries.index');
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
        $record = Gallery::findOrFail($id);
        if (Gallery::destroy($id)) {
            flash(__('Gallery has been deleted successfully'))->success();
            return redirect()->route('galleries.index');
        } else {
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    public function update_status(Request $request)
    {
        $record = Gallery::findOrFail($request->id);
        $record->active = $request->status;
        if ($record->save()) {
            return 1;
        }
        return 0;
    }
}
