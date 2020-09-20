<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\User;
use App\Customer;
use Illuminate\Http\Request;
use GeoIP;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    /*protected $redirectTo = '/';*/


    /**
      * Redirect the user to the Google authentication page.
      *
      * @return \Illuminate\Http\Response
      */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (\Exception $e) {
            return redirect()->route('user.login',auth()->user()->country);
        }

        // check if they're an existing user
        $existingUser = User::where('email', $user->email)->first();
        if($existingUser){
            // log them in
            auth()->login($existingUser, true);
        } else {
            // create a new user
            $newUser                  = new User;
            $newUser->name            = $user->name;
            $newUser->email           = $user->email;
            $newUser->email_verified_at = date('Y-m-d H:m:s');
            $newUser->provider_id     = $user->id;
            
                $geoip = GeoIP::setIp(request()->ip());
                $country_coude = $geoip->getCountryCode();
                $country = \App\Country::where('status',1)->where('code', $country_coude)->first();
                if($country->count()>0){
                    $newUser->country     = $country->code;
                    session()->put('country', $country->code);
                }else{
                    $country = \App\Country::where('status',1)->where('default', 1)->first();
                    $newUser->country = $country->code;
                    session()->put('country', $country->code);
                }
                

            $extension = pathinfo($user->avatar_original, PATHINFO_EXTENSION);
            $filename = 'uploads/users/'.str_random(5).'-'.$user->id.'.'.$extension;
            $fullpath = 'public/'.$filename;
            $file = file_get_contents($user->avatar_original);
            file_put_contents($fullpath, $file);

            $newUser->avatar_original = $filename;
            $newUser->save();

            $customer = new Customer;
            $customer->user_id = $newUser->id;
            $customer->save();

            auth()->login($newUser, true);
            session()->put('country', auth()->user()->country);
        }
        if(session('link') != null){
            return redirect(session('link'),auth()->user()->country);
        }
        else{
            return redirect()->route('dashboard',auth()->user()->country);
        }
    }


    /**
     * Check user's role and redirect user based on their role
     * @return
     */
    public function authenticated()
    {
        if(auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'staff')
        {
            return redirect()->route('admin.dashboard', auth()->user()->country);
        }
        elseif(session('link') != null){
            return redirect(session('link'));
        }
        else{
            $country1 = auth()->user()->country;
            if($country1){
                    session()->put('country', $country1);
                    return redirect()->route('dashboard',$country1);
            }else{
                $geoip = GeoIP::setIp(request()->ip());
                $country_coude = $geoip->getCountryCode();
                $country = \App\Country::where('status',1)->where('code', $country_coude)->first();
                if($country->count()>0){
                    session()->put('country', $country->code);
                                    auth()->user()->update(['country' => $country->code]);

                    return redirect()->route('dashboard',$country->code);
                }else{
                    $country = \App\Country::where('status',1)->where('default', 1)->first();
                    session()->put('country', $country->code);
                                    auth()->user()->update(['country' => $country->code]);

                    return redirect()->route('dashboard',$country->code);
                }
            }
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        if(auth()->user() != null && (auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'staff')){
        $redirect_route = 'login';
        $this->guard()->logout();
        $request->session()->invalidate();
        return $this->loggedOut($request) ?: redirect()->route($redirect_route);
        }
        else{
        $redirect_route = 'home';
        $this->guard()->logout();
        $request->session()->invalidate();
        return $this->loggedOut($request) ?: redirect()->route($redirect_route, get_country()->code);
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
