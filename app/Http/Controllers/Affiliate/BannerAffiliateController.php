<?php

namespace App\Http\Controllers\Affiliate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerAffiliateController extends Controller
{
    public function index()
    {
        return view('affiliate.banners.index');
    }
}
