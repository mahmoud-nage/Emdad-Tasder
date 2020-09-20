<?php

namespace App\Http\Controllers\API\Web;

use App\Speciality;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpecialityController extends Controller
{
    public function index(Request $request)
    {
        $specialities = Speciality::all();
        return response()->json(['status' => 200 , 'data' => $specialities]);
    }
}
