<?php

namespace App\Http\Controllers\API\Web;

use App\Conversation;
use App\Events\NewMessage;
use App\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $conversation = Conversation::find($request->input('conversation_id'));
        $data = [
            'id' => $conversation->id,
            'user_id' => $conversation->user_id,
            'doctor_id' => $conversation->doctor_id,
            'created_at' => $conversation->created_at->toDateString(),
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
        $seen = count(Message::where('conversation_id', $request->input('conversation_id'))->where('seen' , 0)->get());
        $messages = Message::where('conversation_id', $request->input('conversation_id'))->with('User', 'Conversation')->orderBy('id' , 'desc')->paginate(20);
        return response()->json(['status' => 200, 'data' => $messages , 'seen' => $seen, 'conversation' => $data]);
    }

    public function more(Request $request)
    {
        $conversation = Conversation::find($request->input('conversation_id'));
        $last_id = $request->input('last_id');
        $last_message = Message::orderBy('id' , 'desc')->first()->id;
        for ($x = $last_id ; $last_id<=$last_message; $last_id++){
            $ids[] = $last_id;
        }
        $messages = Message::whereNotIn('id' , $ids)->where('conversation_id', $conversation->id)->with('User', 'Conversation')->orderBy('id' , 'desc')->take(20)->get();
        return response()->json(['status' => 200, 'data' => $messages]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'conversation_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => 'validation error', 'error' => $validator->messages()]);
        }

        if ($request->hasFile('attachment')){
            $file = request()->file('attachment');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move(public_path('/assets/images/messages/'), $fileName);
            $message = Message::create([
                'body' => $request->input('body'),
                'attachment' => '/assets/images/messages/'.$fileName,
                'user_id' => auth()->user() ? auth()->user()->id : $request->input('user_id'),
                'conversation_id' => $request->input('conversation_id'),
            ]);
        }else{
            $file = request()->file('attachment');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move(public_path('/assets/images/messages/'), $fileName);
            $message = Message::create([
                'body' => $request->input('body'),
                'user_id' => auth()->user() ? auth()->user()->id : $request->input('user_id'),
                'conversation_id' => $request->input('conversation_id'),
            ]);
        }

        $message = Message::where('id' , $message->id)->with('User')->first();
        broadcast(new NewMessage($message));
        return response()->json(['status' => 200, 'data' => $message]);
    }

    public function seen(Request $request)
    {
        Message::where('conversation_id' , $request->input('conversation_id'))->where('user_id' , '!=' , $request->input('user_id'))->update(['seen' => 1]);
        return response()->json(['status' => 200, 'message' => 'تم بنجاح']);
    }
}
