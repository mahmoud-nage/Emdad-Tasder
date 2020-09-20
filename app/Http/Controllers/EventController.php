<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Event::all();
        return view('events.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
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
            'date' => 'required',
            'photos.*' => 'required|image|mimes:jpg,jpeg,png,tiff,webp,gif',
        ]);
        $record = Event::create($request->except('photos'));

        $photos =[];
        if ($request->hasFile('photos')) {
            foreach ($request->photos as $key => $photo) {
                $path = 'uploads/events';
                $name = resizeUploadImage($photo, $path, $resize_width = 350, $resize_height = 400);
                array_push($photos, $name);
            }
            $record->photos = json_encode($photos);
            $record->save();
        }

        if ($record) {
            flash(__('Event has been inserted successfully'))->success();
            return redirect()->route('events.index');
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
        $record = Event::find($id);
        return view('frontend.singel_event',compact('record'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = Event::findOrFail(decrypt($id));
        return view('events.edit', compact('record'));
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
            'date' => 'date|after_or_equal:today',
            'photo.*' => 'image|mimes:jpg,jpeg,png,tiff,webp,gif',
        ]);

        $event = Event::find($id);
        $record = $event->update($request->except('_token', '_method','photos','previous_photos'));

        if ($request->has('previous_photos')) {
            $photos = $request->previous_photos;
        } else {
            $photos = array();
        }

        if ($request->hasFile('photos')) {
            foreach ($request->photos as $key => $photo) {
                $path = 'uploads/events';
                $name = resizeUploadImage($photo, $path, $resize_width = 350, $resize_height = 400);
                array_push($photos, $name);
            }
            $event->photos = json_encode($photos);
        }


        if ($event->save()) {
            flash(__('Event has been updated successfully'))->success();
            return redirect()->route('events.index');
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
        $record = Event::findOrFail($id);

        if (Event::destroy($id)) {
            flash(__('Event has been deleted successfully'))->success();
            return redirect()->route('events.index');
        } else {
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    public function update_status(Request $request)
    {
        $record = Event::findOrFail($request->id);
        $record->active = $request->status;
        if ($record->save()) {
            return 1;
        }
        return 0;
    }
}
