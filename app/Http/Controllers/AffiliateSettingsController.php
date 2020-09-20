<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class AffiliateSettingsController extends Controller
{
    public function index()
    {
        $coupon_percentage = Bes::first();
        return view('affiliates.settings' , compact('settings'));
    }
}
