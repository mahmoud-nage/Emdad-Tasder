<?php

namespace App\Http\Controllers\API\Admin;

use App\Conversation;
use App\Doctor;
use App\Message;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function index()
    {
        $conversations = Conversation::with('User')->latest()->get();
        $seen = count(Message::where('seen' , 0)->get());
        $data = array();
        foreach ($conversations as $conversation) {
            $doctor = Doctor::find($conversation->doctor_id);

            $data[] = [
                'id' => $conversation->id,
                'user_id' => $conversation->user_id,
                'doctor_id' => $conversation->doctor_id,
                'created_at' => $conversation->created_at->toDateString(),
                'seen' => count(Message::where('conversation_id' , $conversation->id)->where('user_id' , '!=' , $doctor->User->id)->where('seen' , 0)->get()),
                'doctor' => [
                    'name' => $conversation->Doctor->name_en,
                    'image' => $conversation->Doctor->getAvatar(),
                ],
                'user' => [
                    'name' => $conversation->User->name,
                    'image' => $conversation->User->getAvatarPath(),
                ]
            ];
        }
        return response()->json(['status' => 200, 'data' => $data , 'seen' => $seen]);
    }

    public function inbox()
    {
        $conversations = Conversation::with('User')->latest()->get();
        $data = array();
        $seen = count(Message::where('seen' , 0)->get());
        foreach ($conversations as $conversation) {
            $doctor = Doctor::find($conversation->doctor_id);
            $data[] = [
                'id' => $conversation->id,
                'user_id' => $conversation->user_id,
                'doctor_id' => $conversation->doctor_id,
                'created_at' => $conversation->created_at->toDateString(),
                'seen' => count(Message::where('conversation_id' , $conversation->id)->where('user_id' , '!=' , $doctor->User->id)->where('seen' , 0)->get()),
                'doctor' => [
                    'name' => $conversation->Doctor->name_en,
                    'image' => $conversation->Doctor->getAvatar(),
                ],
                'user' => [
                    'name' => $conversation->User->name,
                    'image' => $conversation->User->getAvatarPath(),
                ]
            ];
        }
        return response()->json(['status' => 200, 'data' => $data , 'seen' => $seen]);
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'user_id' => 'required'
        ]);
        $user = User::find($request->input('user_id'));
        $conv = Conversation::where('user_id', $user->id)->first();
        if (isset($conv)) {
            return response()->json(['status' => 403, 'message' => 'المحادثة موجودة بالفعل!']);
        }
        $conversation = Conversation::create([
            'user_id' => $user->id,
            'doctor_id' => auth()->user()->id,
        ]);
        return response()->json(['status' => 200, 'message' => 'تم بدء محادثة برجاء إنتظار الرد']);
    }
}
