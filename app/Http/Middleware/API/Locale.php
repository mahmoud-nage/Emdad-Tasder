<?php

namespace App\Http\Middleware\API;

use Closure;

class Locale
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
        if ($request->header('lang')){
            app()->setLocale($request->header('lang'));
        }
        return $next($request);
    }
}
