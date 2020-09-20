<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::all();
        return view('sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = request()->input('type');
        $type1 = request()->input('type1');
        $type2 = request()->input('type2');
        return view('sliders.create' , compact('type','type1','type2'));
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
            'photos.*' => 'required|mimes:jpg,jpeg,png,tiff,webp,gif',
            'country_id' => 'required|exists:countries,id',
            'url' => 'url',
          ]);

        if($request->hasFile('photos')){
            foreach ($request->photos as $key => $photo) {
                $slider = new Slider;
                $path = 'uploads/sliders';
                $name = webpUploadImage($photo, $path);
                $slider->photo = $name;
                $slider->country_id = $request->country_id;
                $slider->url = $request->url;
                $slider->type = $request->input('type') ? $request->input('type') : 'web';
                $slider->type1 = $request->input('type1') ? $request->input('type1') : 0;
                $slider->type2 = $request->input('type2') ? $request->input('type2') : 0;
                $slider->save();
            }
            flash(__('Slider has been inserted successfully'))->success();
        }
        return redirect()->route('home_settings.index');
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
        //
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
            'status' => 'required',
          ]);

        $slider = Slider::find($id);
        $slider->published = $request->status;
        if($slider->save()){
            return '1';
        }
        else {
            return '0';
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
        $slider = Slider::findOrFail($id);
        if(Slider::destroy($id)){
            //unlink($slider->photo);
            flash(__('Slider has been deleted successfully'))->success();
        }
        else{
            flash(__('Something went wrong'))->error();
        }
        return redirect()->route('home_settings.index');
    }
}
