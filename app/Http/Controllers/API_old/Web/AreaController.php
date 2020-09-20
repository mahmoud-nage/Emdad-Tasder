<?php

namespace App\Http\Controllers\API\Web;

use App\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AreaController extends Controller
{
    public function index(Request $request)
    {
        $data = array();
        $area = Area::latest();
        $locale = $request->input('locale');
        if ($request->input('city_id')){
            $area = $area->where('city_id' , $request->input('city_id'));
        }
        foreach ($area->get() as $item) {
            $data[] =[
                'id' => $item->id,
                'name' => $locale == 'en' ? $item->name_en : $item->name_ar,
            ];
        }
        return response()->json(['status' => 200 , 'data' => $data]);
    }
}
