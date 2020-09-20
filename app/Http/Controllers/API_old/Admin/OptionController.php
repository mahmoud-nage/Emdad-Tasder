<?php

namespace App\Http\Controllers\API\Admin;

use App\Option;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OptionController extends Controller
{
    public function index()
    {
        return response()->json(['status' => 200, 'data' => Option::all()]);
    }


    public function store(Request $request)
    {
        $option = Option::create([
            'name_ar' => $request->input('name_ar'),
            'name_en' => $request->input('name_en'),
            'price' => $request->input('price'),
        ]);
        return response()->json(['status' => 200, 'message' => 'Created Successfully', 'option' => $option]);
    }

    public function update($id, Request $request)
    {
        Option::where('id', $id)->update([
            'name_ar' => $request->input('name_ar'),
            'name_en' => $request->input('name_en'),
            'price' => $request->input('price'),

        ]);
        return response()->json(['status' => 200, 'message' => 'Created Successfully']);
    }

    public function destroy($id)
    {
        Option::where('id', $id)->delete();
        return response()->json(['status' => 200, 'message' => 'Deleted Successfully']);
    }

}
