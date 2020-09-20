<?php

namespace App\Http\Controllers\Affiliate;

use App\CouponUrl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CouponUrlController extends Controller
{
    public function index()
    {
        $urls = CouponUrl::where('affiliate_id', auth()->user()->Affiliate->id)->get();
        return view('affiliate.urls.index', compact('urls'));
    }

    public function create()
    {
        $user = auth()->user();
        $affiliate = auth()->user()->Affiliate;
        return view('affiliate.urls.create', compact('user', 'affiliate'));
    }

    public function store(Request $request)
    {
        $url = CouponUrl::create([
            'type' => $request->input('type'),
            'tag1' => $request->input('tag1'),
            'tag2' => $request->input('tag2'),
            'tag3' => $request->input('tag3'),
            'tag4' => $request->input('tag4'),
            'tag5' => $request->input('tag5'),
            'affiliate_id' => auth()->user()->Affiliate->id,
            'coupon_affiliate_id' => auth()->user()->Affiliate->Coupon->id,
        ]);
        $url->url = $request->input('url') . '&co-ur=' . encrypt($url->id);
        $url->update();
        return redirect()->route('affiliate.urls.index');
    }
}
