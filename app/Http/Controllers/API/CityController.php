<?php

namespace App\Http\Controllers\API;

use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::all();
        return response()->json(['status' => 200 , 'data' => $cities]);
    }
}
