<?php

namespace App\Http\Controllers\API\Admin;

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
        $seen = count(Message::where('conversation_id', $request->input('conversation_id'))->where('seen' , 0)->get());
        $messages = Message::where('conversation_id', $request->input('conversation_id'))->with('User', 'Conversation')->orderBy('id' , 'desc')->paginate(20);
        return response()->json(['status' => 200, 'data' => $messages , 'seen' => $seen , 'conversation' => $conversation]);
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
            'body' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => 'validation error', 'error' => $validator->messages()]);
        }
        $message = Message::create([
            'body' => $request->input('body'),
            'user_id' => auth()->user() ? auth()->user()->id : $request->input('user_id'),
            'conversation_id' => $request->input('conversation_id'),
        ]);
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
