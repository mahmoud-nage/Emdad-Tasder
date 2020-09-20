<?php

namespace App\Http\Controllers\API\Web;

use App\Zone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ZoneController extends Controller
{
    public function index(Request $request)
    {
        $data = array();
        $zones = Zone::latest();
        $locale = $request->input('locale');
        if ($request->input('area_id')){
            $zones = $zones->where('area_id' , $request->input('area_id'));
        }
        foreach ($zones->get() as $zone) {
            $data[] =[
                'id' => $zone->id,
                'name' => $locale == 'en' ? $zone->name_en : $zone->name_ar,
            ];
        }
        return response()->json(['status' => 200 , 'data' => $data]);
    }
}
