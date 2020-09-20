<?php

namespace App\Http\Controllers\API\Admin;

use App\Area;
use App\Zone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ZoneController extends Controller
{
    public function index(Request $request)
    {
        $zones = Zone::with('Area')->latest();
        if ($request->input('area_id')){
            $zones = $zones->where('area_id' , $request->input('area_id'));
        }
        return response()->json(['status' => 200 , 'data' => $zones->get()]);
    }

    public function store(Request $request)
    {
        $area = Zone::create([
            'name_ar' => $request->input('name_ar'),
            'name_en' => $request->input('name_en'),
            'area_id' => $request->input('area_id'),
        ]);
        return response()->json(['status' => 200 , 'message' => 'Created Successfully' , 'area' => $area]);
    }
    public function update($id ,Request $request)
    {
        Zone::where('id' , $id)->update([
            'name_ar' => $request->input('name_ar'),
            'name_en' => $request->input('name_en'),
            'area_id' => $request->input('area_id'),

        ]);
        return response()->json(['status' => 200 , 'message' => 'Updated Successfully']);
    }
    public function destroy($id)
    {
        Zone::where('id' , $id)->delete();
        return response()->json(['status' => 200 , 'message' => 'Deleted Successfully']);
    }
}
