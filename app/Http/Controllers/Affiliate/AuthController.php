<?php

namespace App\Http\Controllers\Affiliate;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('affiliate.auth.index');
    }

    public function store(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where('email', $email)->first();
        $remember = $request->input('remember') ? true : false;

        if ($user) {
            if (Hash::check($password, $user->password)) {
                if ($user->user_type == 'affiliate') {
                    if ($user->is_blocked == 0) {
                        if (!auth()->attempt(request(['email', 'password'], $remember))) {
                            return back();
                        }
                        return redirect()->intended('/affiliate');
                    }
                    Session::flash('fail', 'لقد تم حظرك من دكتور الموقع!');
                    return back();
                }
                Session::flash('fail', 'Not Allowed');
                return back();
            }
            Session::flash('fail', 'خطأ في كلمة المرور');
            return back();
        }
        Session::flash('fail', 'من فضلك أدخل بيانات صحيحة');
        return back();
    }

    public function destroy()
    {
        auth()->logout();
        return redirect()->route('affiliate.login');
    }
}
