<?php

namespace App\Http\Middleware;

use Closure;

class Backorder
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // dd($request->all());        
        $urlPrevious = url()->previous();
        $urlto = url()->current();
        $address = $request->session()->get('shipping_info');
        // dd($address);
        if($urlto == 'http://localhost/projects/RevelMedia/public_html/public/checkout/payment' && $address == null){
            flash(__('messages.error_msg'))->error();
            return redirect()->route('cart');
        }
        return $next($request);
    }
}
