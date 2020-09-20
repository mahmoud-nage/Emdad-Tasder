<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function show(Request $request)
    {
        $data = User::where('id' , $request->input('user_id'))->with('addresses')->first();
        return response()->json(['status' => 200 , 'data' => $data]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'name' => 'required',
            'phone' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 200);
        }
        $userData = $request->all();
        $userData['password'] = Hash::make($userData['password']);
        $user = User::find($request->input('user_id'));
        $user->update($userData);
        return response()->json(['status' => 200, 'user' => $user], 200);
    }
}
