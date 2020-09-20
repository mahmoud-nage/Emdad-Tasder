<?php

namespace App\Http\Controllers\API\Admin;

use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    public function index()
    {
        return response()->json(['status' => 200 , 'data' => City::all()]);
    }


    public function store(Request $request)
    {
        $city = City::create([
            'name_ar' => $request->input('name_ar'),
            'name_en' => $request->input('name_en'),
            'country_id' => $request->input('country_id'),
            'delivery_price' => $request->input('delivery_price'),
        ]);
        return response()->json(['status' => 200 , 'message' => 'Created Successfully' , 'city' => $city]);
    }
    public function update($id ,Request $request)
    {
        City::where('id' , $id)->update([
            'name_ar' => $request->input('name_ar'),
            'name_en' => $request->input('name_en'),
            'country_id' => $request->input('country_id'),
            'delivery_price' => $request->input('delivery_price'),
        ]);
        return response()->json(['status' => 200 , 'message' => 'Created Successfully']);
    }
    public function destroy($id)
    {
        City::where('id' , $id)->delete();
        return response()->json(['status' => 200 , 'message' => 'Deleted Successfully']);
    }
}
