<?php

namespace App\Http\Controllers\API;

use App\Area;
use App\Zone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ZoneController extends Controller
{
    public function index(Request $request)
    {
        $zones = Zone::latest();
        if ($request->input('area_id')){
            $zones = $zones->where('area_id' , $request->input('area_id'));
        }
        return response()->json(['status' => 200 , 'data' => $zones->get()]);
    }
}
