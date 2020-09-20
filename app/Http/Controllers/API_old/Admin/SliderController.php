<?php

namespace App\Http\Controllers\API\Admin;

use App\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    public function index()
    {
        return response()->json(['status' => 200, 'data' => Slider::all()]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required',
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 500);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $img = Image::make($image->getRealPath());
            $size = $img->filesize();
            $data = getimagesize($image);
            $width = $size > 400000 ? $data[0] / 4 : $data[0];
            $height = $size > 400000 ? $data[1] / 4 : $data[1];
            $img = $img->resize($width, $height);
            $fileName = md5($image->getClientOriginalName() . time()) . "." . $image->getClientOriginalExtension();
            $img->save(public_path('/uploads/sliders/' . $fileName));
        }
        Slider::create([
            'text' => $request->input('text'),
            'image' => isset($img) ? '/uploads/sliders/'.$fileName : null,
            'url' => $request->input('url'),
        ]);

        return response()->json(['status' => 200, 'message' => 'تم الإنشاء بنجاح']);
    }

    public function update($id, Request $request)
    {
        Slider::where('id', $id)->update([
            'name_ar' => $request->input('name_ar'),
            'name_en' => $request->input('name_en'),

        ]);
        return response()->json(['status' => 200, 'message' => 'تم التعديل بنجاح']);
    }

    public function destroy($id)
    {
        Slider::where('id', $id)->delete();
        return response()->json(['status' => 200, 'message' => 'تم المسح بنجاح']);
    }
}
