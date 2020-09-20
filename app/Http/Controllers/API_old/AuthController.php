<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where('email', $email)->first();

        if ($user) {
            if (Hash::check($password, $user->password)) {
                if (!auth()->attempt(request(['email', 'password']))) {
                    return response()->json(['status' => 400, 'message' => 'invalid credentials']);
                }
                if ($request->input('fcm_token')) {
                    User::where('email', $email)->update(['fcm_token' => $request->input('fcm_token')]);
                    $user = User::where('email', $email)->first();
                }
                return response()->json(['status' => 200, 'message' => 'welcome back', 'user' => $user]);
            }
            return response()->json(['status' => 400, 'message' => 'invalid password']);
        }
        return response()->json(['status' => 400, 'message' => 'invalid credentials']);
    }

    public function socialLogin(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where('email', $email)
            ->where('provider', $request->input('provider'))
            ->where('provider_id', $request->input('provider_id'))
            ->first();
        if ($user) {
//            if (Hash::check($password, $user->password)) {
            if ($request->input('fcm_token')) {
                User::where('email', $email)->update(['fcm_token' => $request->input('fcm_token')]);
                $user = User::where('email', $email)->first();
            }
            return response()->json(['status' => 200, 'message' => 'welcome back', 'user' => $user]);
//            }
//            return response()->json(['status' => 400, 'message' => 'invalid password']);
        } else {
            $userWithEmail = User::where('email', $email)->first();
            if ($userWithEmail) {
                return response()->json(['status' => 200, 'message' => 'welcome back', 'user' => $userWithEmail]);
            }
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->provider = $request->input('provider');
            $user->provider_id = $request->input('provider_id');
            $user->phone = $request->input('phone');
            $user->birth_date = $request->input('birth_date');
            $user->avatar = $request->input('avatar');
            $user->api_token = "3c006c7998dfd13413c42caf109a0ac10b0c39265d132af9e366a3e73c42";
            $user->save();
            return response()->json(['status' => 200, 'message' => 'welcome to newFace', 'user' => User::where('email', $user->email)->first()]);
        }
        return response()->json(['status' => 400, 'message' => 'invalid credentials']);
    }

    public function sendMail(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if ($user) {
            $code = mt_rand(100000, 999999);
            $user->reset_code = $code;
            $user->update();
            Mail::to($request->input('email'))->send(new ResetPassword($code));
            return response()->json(['status' => 200, 'message' => 'code sent']);
        }
        return response()->json(['status' => 400, 'message' => 'Invalid Email']);
    }

    public function checkCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'code' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->messages()]);
        }
        $user = User::where('email', $request->input('email'))->first();
        if ($user) {
            if ($user->reset_code == $request->input('code')) {
                return response()->json(['status' => 200, 'message' => 'Valid code']);
            }
            return response()->json(['status' => 500, 'message' => 'Wrong Code!']);
        }
        return response()->json(['status' => 500, 'message' => 'Wrong Email!']);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'code' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->messages()]);
        }
        $user = User::where('email', $request->input('email'))->first();
        if ($user) {
            if ($user->reset_code == $request->input('code')) {
                $user->password = Hash::make($request->input('password'));
                $user->reset_code = NULL;
                $user->update();
                return response()->json(['status' => 200, 'message' => 'Password Updated Successfully']);
            }
            return response()->json(['status' => 500, 'message' => 'Wrong Code!']);

        }
        return response()->json(['status' => 500, 'message' => 'Wrong Email!']);
    }
}
