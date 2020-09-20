<?php

namespace App\Http\Controllers\API\Web;

use App\Conversation;
use App\Doctor;
use App\Message;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConversationController extends Controller
{
    public function index(Request $request)
    {
        $conversations = Conversation::where('user_id' , $request->input('user_id'))->with('User' , 'Doctor')->latest()->get();
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
                    'name_en' => $conversation->Doctor->name_en,
                    'name_ar' => $conversation->Doctor->name_ar,
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

    public function inbox(Request $request)
    {
        $conversations = Conversation::where('user_id' , $request->input('user_id'))->with('User' , 'Doctor')->latest()->get();
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
                    'name_en' => $conversation->Doctor->name_en,
                    'name_ar' => $conversation->Doctor->name_ar,
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
        $column = \App::isLocale('en') ? 'slug_en' : 'slug_ar';
        $doctor = Doctor::where($column , $request->input('doctor'))->first();
        $conv = Conversation::where('user_id', $user->id)->where('doctor_id' , $doctor->id)->first();
        if (isset($conv)) {
            return response()->json(['status' => 403, 'message' => 'المحادثة موجودة بالفعل!']);
        }
        $conversation = Conversation::create([
            'user_id' => $user->id,
            'doctor_id' => $doctor->id,
        ]);
        return response()->json(['status' => 200, 'message' => 'تم بدء محادثة برجاء إنتظار الرد']);
    }
}
