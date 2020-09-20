<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use GeoIP;
use Closure;

class Country
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
    if(!(auth()->check() && (auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'staff'))){
       $countryShortcode = explode('/',$request->route('country'));  //get country part from url
       $routeName = $request->route()->getName();
       $routeParameters = $request->route()->parameters();
       
    //   dd(session()->get('country'),$countryShortcode[0],$routeParameters,$routeName,implode('/',$routeParameters));
    
    // if(auth()->check()){
    //     return $next($request);
    // }
    
        if($countryShortcode[0] != session()->get('country')){
            $countryShortcode[0] = session()->get('country');
            $routeParameters['country'] = implode('/',$countryShortcode);
            return redirect()->route($routeName, $routeParameters);
        }
        
       $country = \App\Country::where('code', '=', $countryShortcode)->where('status', '=', 1)->first();
       if ($country === null) {
                $geoip = GeoIP::setIp(request()->ip());
                $country_coude = $geoip->getCountryCode();
                $country = \App\Country::where('status',1)->where('code', $country_coude)->first();
                if($country->count()>0){
                    
                session()->put('country', $country->code);
                $countryShortcode[0] = session()->get('country');
                $routeParameters['country'] = implode('/',$countryShortcode);
                return redirect()->route($routeName, $routeParameters);
                
                }else{
                    $country = \App\Country::where('status',1)->where('default', 1)->first();
                    session()->put('country', $country->code);
            $countryShortcode[0] = session()->get('country');
            $routeParameters['country'] = implode('/',$countryShortcode);
            return redirect()->route($routeName, $routeParameters);
                }

       }
        
    }
      return $next($request);
    }
}
