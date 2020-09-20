<?php

namespace App\Http\Controllers\API\Admin;

use App\Size;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SizeController extends Controller
{
    public function index()
    {
        return response()->json(['status' => 200, 'data' => Size::all()]);
    }


    public function store(Request $request)
    {
        $size = Size::create([
            'name_ar' => $request->input('name_ar'),
            'name_en' => $request->input('name_en'),
        ]);
        return response()->json(['status' => 200, 'message' => 'Created Successfully', 'city' => $size]);
    }

    public function update($id, Request $request)
    {
        Size::where('id', $id)->update([
            'name_ar' => $request->input('name_ar'),
            'name_en' => $request->input('name_en'),

        ]);
        return response()->json(['status' => 200, 'message' => 'Created Successfully']);
    }

    public function destroy($id)
    {
        Size::where('id', $id)->delete();
        return response()->json(['status' => 200, 'message' => 'Deleted Successfully']);
    }
}
