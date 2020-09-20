<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public function index()
    {
        return view('zones.index');
    }
}
