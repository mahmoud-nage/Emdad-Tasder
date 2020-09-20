<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Notification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $data = User::find($request->input('user_id'))->notifications()->get();
        $allNotifiactions = Notification::where('user_id',$request->input('user_id'))->get();
        return response()->json(['status' => 200, 'data' => $allNotifiactions]);
    }

    public function seen(Request $request)
    {
//        ->where('notification_id', $request->input('notification_id'))
        Notification::where('user_id', $request->input('user_id'))->update(['seen' => 1]);
        return response()->json(['status' => 200, 'message' => 'status updated']);
    }

    public function getSeen(Request $request)
    {
        $notifications = Notification::where('user_id', $request->input('user_id'))
            ->where('seen', $request->input('seen'))->get();
        return response()->json(['status' => 200, 'data' => $notifications]);
    }

}
