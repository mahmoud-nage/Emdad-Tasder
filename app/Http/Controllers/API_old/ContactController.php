<?php

namespace App\Http\Controllers\API;

use App\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'message' => 'required',
            'api_token' => 'required',
        ]);
        if ($validator->fails()){
            return response()->json(['status' => 500 , 'message' => $validator->errors()->messages()] ,500);
        }
        Contact::create([
            'user_id' => $request->input('user_id'),
            'message' => $request->input('message'),
        ]);
        return response()->json(['status' => 200, 'message' => 'Sent Successfully'] , 200);
    }
}
