<?php

namespace App\Http\Middleware\Affiliate;

use Closure;

class isApproved
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
        if (auth()->user()->Affiliate->is_approved == 1){
            return $next($request);
        }
        session()->flash('error' , 'Your account is not approved');
        return redirect()->route('affiliate.dashboard');
    }
}
