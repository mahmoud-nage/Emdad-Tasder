<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'city_id' => 'required|exists:cities,id',
            'country_id' => 'required|exists:countries,id',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'confirmed',
            'phone' => 'required',
            'avatar' => 'mimes:jpg,jpeg,png,tiff,webp,gif',
            'fcm_token' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'error' => 'Validation Error', 'message' => $validator->messages()], 200);
        }

        $user = User::where('email', $request->input('email'))->first();
        if ($user) {
            return response()->json(['status' => 400, 'message' => 'This User Registered Before'], 200);
        }

        if ($request->input('provider_id')) {
            $user = User::where('provider_id', $request->input('provider_id'))->first();
            if (isset($user)) {
                return response()->json(['status' => 200, 'data' => $user, 'message' => 'User Registered Before']);
            } else {
                $user = User::create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => Hash::make($request->input('password')),
                    'birth_date' => $request->input('birth_date'),
                    'gender' => $request->input('gender'),
                    'city' => $request->input('city_id'),
                    'country' => $request->input('country_id'),
                    'phone' => $request->input('phone'),
                    'provider' => $request->input('provider'),
                    'provider_id' => $request->input('provider_id'),
                    'api_token' => bin2hex(openssl_random_pseudo_bytes(30)),
                    'fcm_token' => $request->fcm_token,
                ]);
            }
        } else {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'birth_date' => $request->input('birth_date'),
                'gender' => $request->input('gender'),
                'phone' => $request->input('phone'),
                'city' => $request->input('city_id'),
                'country' => $request->input('country_id'),
                'api_token' => bin2hex(openssl_random_pseudo_bytes(30)),
                'fcm_token' => $request->fcm_token,
            ]);
        }
        if ($request->hasFile('avatar')) {
            $path = 'uploads/user/avatar';
            $name = webpUploadImage($request->avatar, $path);
            $user->avatar = $name;
        }

        $user = User::find($user->id);

        return response()->json(['status' => 200, 'user' => $user, 'message' => 'Registered Successfully'], 200);
    }
}
