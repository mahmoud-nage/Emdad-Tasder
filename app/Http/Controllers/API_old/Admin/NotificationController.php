<?php

namespace App\Http\Controllers\API\Admin;

use App\Conversation;
use App\Events\NewMessage;
use App\Message;
use App\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{

    public function index(Request $request)
    {
        $data = DB::table('user_notifications')->where('user_id' , $request->input('user_id'))->pluck('notification_id')->toArray();
        $seen = DB::table('user_notifications')->where('user_id' , $request->input('user_id'))->where('seen' , 0)->count();
        $notifications = Notification::whereIn('id' , $data)->latest()->take(20)->get();
        return response()->json(['status' => 200 , 'data' => $notifications , 'seen' => $seen]);
    }

    public function seen(Request $request)
    {
        DB::table('user_notifications')->where('notification_id' , $request->input('notification_id'))
            ->where('user_id' , $request->input('user_id'))->update(['seen' => 1]);
        return response()->json(['status' => 200 , 'message' => 'status updated']);
    }

}
