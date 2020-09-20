<?php

namespace App\Http\Controllers\API;

use App\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $locale = $request->header('locale');
        $data = $locale=='ar' ? Country::select('id' , 'name_ar as name', 'icon')->get() : Country::select('id' , 'name_en as name', 'icon')->get() ;
        return response()->json(['status' => 200 , 'data' => $data]);
    }
}
