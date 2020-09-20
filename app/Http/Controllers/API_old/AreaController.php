<?php

namespace App\Http\Controllers\API;

use App\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AreaController extends Controller
{
    public function index(Request $request)
    {
        $areas = Area::latest();
        if ($request->input('city_id')){
            $areas = $areas->where('city_id' , $request->input('city_id'));
        }
        return response()->json(['status' => 200 , 'data' => $areas->get()]);
    }
}
