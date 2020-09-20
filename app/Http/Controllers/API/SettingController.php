<?php

namespace App\Http\Controllers\API;

use App\GeneralSetting;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function index()
    {
        return response()->json(['status' => 200 , 'data' => GeneralSetting::first()]);
    }
}
