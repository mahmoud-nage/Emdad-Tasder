<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Session;
use Config;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->input('cc-p')) {
            $coupon = App\CouponAffiliate::find( decrypt($request->input('cc-p')));
            session()->put('coupon_affiliate' , $coupon->id);
            $coupon->visits++;
            $coupon->update();
        }
        if ($request->input('co-ur')) {
            $coupon_url = App\CouponUrl::find( decrypt($request->input('co-ur')));
            session()->put('coupon_url' , $coupon_url->id);
            $coupon_url->visits++;
            $coupon_url->update();
        }
        if (Session::has('locale')) {
            $locale = Session::get('locale', Config::get('app.locale'));
        } elseif ($request->input('lang')) {
            $locale = $request->input('lang');
        } else {
            $locale = 'en';
        }
        App::setLocale($locale);
        return $next($request);
    }
}
