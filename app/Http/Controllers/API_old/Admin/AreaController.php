<?php

namespace App\Http\Controllers\API\Admin;

use App\Area;
use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AreaController extends Controller
{
    public function index(Request $request)
    {
        $area = Area::with('City')->latest();
        if ($request->input('city_id')){
            $area = $area->where('city_id' , $request->input('city_id'));
        }
        return response()->json(['status' => 200 , 'data' => $area->get()]);
    }
    public function store(Request $request)
    {
        $area = Area::create([
            'name_ar' => $request->input('name_ar'),
            'name_en' => $request->input('name_en'),
            'delivery_price' => $request->input('delivery_price'),
            'delivery_time' => $request->input('delivery_time'),
            'city_id' => $request->input('city_id'),
        ]);
        return response()->json(['status' => 200 , 'message' => 'Created Successfully' , 'area' => $area]);
    }
    public function update($id ,Request $request)
    {
        Area::where('id' , $id)->update([
            'name_ar' => $request->input('name_ar'),
            'name_en' => $request->input('name_en'),
            'delivery_price' => $request->input('delivery_price'),
            'delivery_time' => $request->input('delivery_time'),
            'city_id' => $request->input('city_id'),

        ]);
        return response()->json(['status' => 200 , 'message' => 'Updated Successfully']);
    }
    public function destroy($id)
    {
        Area::where('id' , $id)->delete();
        return response()->json(['status' => 200 , 'message' => 'Deleted Successfully']);
    }
}
