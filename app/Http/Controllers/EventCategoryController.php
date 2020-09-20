<?php

namespace App\Http\Controllers;

use App\EventCategory;
use Illuminate\Http\Request;

class EventCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = EventCategory::all();
        return view('eventCategories.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('eventCategories.create');
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
            'photo' => 'required|image|mimes:jpg,jpeg,png,tiff,webp,gif',
        ]);
        $record = EventCategory::create($request->all());
        if ($record) {
            flash(__('EventCategory has been inserted successfully'))->success();
            return redirect()->route('eventCategories.index');
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
        $record = EventCategory::findOrFail(decrypt($id));
        return view('eventCategories.edit', compact('record'));
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
            'photo' => 'image|mimes:jpg,jpeg,png,tiff,webp,gif',
        ]);

        $record = EventCategory::update($request->except('_token', '_method'));
        if ($request->hasFile('thumbnail_img')) {
            $old_name = $record->photo;
            $path = 'uploads/eventCategories';
            $name = resizeUploadImage($request->photo, $path, $resize_width = 200, $resize_height = 230);
            $record->photo = $name;
            deleteImage($old_name);
        }

        if ($record) {
            flash(__('EventCategory has been updated successfully'))->success();
            return redirect()->route('eventCategories.index');
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
        $record = EventCategory::findOrFail($id);

        if (EventCategory::destroy($id)) {
            flash(__('EventCategory has been deleted successfully'))->success();
            return redirect()->route('eventCategories.index');
        } else {
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    public function update_status(Request $request)
    {
        $record = EventCategory::findOrFail($request->id);
        $record->active = $request->status;
        if ($record->save()) {
            return 1;
        }
        return 0;
    }
}
