<?php

namespace App\Http\Controllers;


use App\Area;
use App\City;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::latest()->get();
        return view('areas.index', compact('areas'));
    }
}
