<?php

namespace App\Http\Controllers\API;

use App\Complaint;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 500);
        }
        return response()->json(['status' => 200,
            'data' => Complaint::select('id', 'title', 'body', 'created_at')
                ->where('user_id', $request->input('user_id'))->latest()->get()], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'body' => 'required',
            'type' => 'required|in:Late order,Error product,Forgotten product',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => $validator->errors()->messages()], 500);
        }
        Complaint::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'user_id' => $request->input('user_id'),
            'type' => $request->input('type'),
        ]);
        return response()->json(['status' => 200, 'message' => 'Sent Successfully'], 200);
    }

}
