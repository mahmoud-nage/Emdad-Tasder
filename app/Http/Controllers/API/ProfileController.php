<?php

namespace App\Http\Controllers\API;

use App\Media;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 200);
        }

        $user = User::where('id', $request->input('user_id'))->with('addresses')->first();
        return response()->json(['status' => 200, 'data' => $user], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'name' => 'required',
            'password' => 'confirmed',
            'birth_date' => 'required',
            'phone' => 'required',
            'avatar' => 'mimes:jpg,jpeg,png,tiff,webp,gif',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 200);
        }

        $user = User::find($request->input('user_id'));
        User::where('id', $request->input('user_id'))->update([
            'name' => $request->input('name'),
            'birth_date' => $request->input('birth_date'),
            'phone' => $request->input('phone'),
        ]);

        if ($request->input('password')) {
            User::where('id', $request->input('user_id'))->update([
                'password' => Hash::make($request->input('password')),
            ]);
        }

        if ($request->hasFile('avatar')) {
            $old = $user->avatar;
            $path = 'uploads/user/avatar';
            $name = webpUploadImage($request->avatar, $path);
            $user->avatar = $name;
            deleteImage($old);
            $user->save();
        }

        return response()->json(['status' => 200, 'message' => 'Updated Successfully', 'data' => User::where('id', $request->input('user_id'))->with('addresses')->first()], 200);
    }
}
