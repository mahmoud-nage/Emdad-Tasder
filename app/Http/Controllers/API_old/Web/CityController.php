<?php

namespace App\Http\Controllers\API\Web;

use App\City;
use App\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $data = array();
        $cities = City::latest();
        $locale = $request->input('locale');
        $country = Country::where('code' , $request->input('country'))->first();
        if ($request->input('country')){
            $cities = $cities->where('country_id' , $country->id);
        }
        foreach ($cities->get() as $item) {
            $data[] =[
                'id' => $item->id,
                'name' => $locale == 'en' ? $item->name_en : $item->name_ar,
            ];
        }
        return response()->json(['status' => 200 , 'data' => $data]);
    }
}
