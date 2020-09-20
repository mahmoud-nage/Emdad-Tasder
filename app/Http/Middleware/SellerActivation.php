<?php

namespace App\Http\Middleware;

use Closure;

class SellerActivation
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
        if(auth()->user()->seller){
            if (auth()->user()->seller->verification_status == 1){
                return $next($request);
            }
            return redirect()->route('dashboard');
        }
        return redirect()->route('home');
    }
}
