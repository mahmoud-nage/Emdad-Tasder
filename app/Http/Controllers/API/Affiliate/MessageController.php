<?php

namespace App\Http\Controllers\API\Affiliate;

use App\Message;
use App\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $ticket = Ticket::find($request->input('ticket_id'));
        $messages = Message::with('User', 'Ticket')->where('ticket_id', $request->input('ticket_id'))->orderBy('id' , 'desc')->get();
        return response()->json(['status' => 200, 'data' => $messages , 'ticket' => $ticket]);
    }

    public function more(Request $request)
    {
        $ticket = Ticket::find($request->input('ticket_id'));
        $last_id = $request->input('last_id');
        $last_message = Message::orderBy('id' , 'desc')->first()->id;
        for ($x = $last_id ; $last_id<=$last_message; $last_id++){
            $ids[] = $last_id;
        }
        $messages = Message::whereNotIn('id' , $ids)->where('ticket_id', $ticket->id)->with('User', 'Ticket')->orderBy('id' , 'desc')->take(20)->get();
        return response()->json(['status' => 200, 'data' => $messages]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required',
            'body' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'message' => 'validation error', 'error' => $validator->messages()]);
        }
        $message = Message::create([
            'body' => $request->input('body'),
            'user_id' => $request->input('user_id'),
            'ticket_id' => $request->input('ticket_id'),
        ]);
        $message = Message::where('id' , $message->id)->with('User')->first();
        return response()->json(['status' => 200, 'data' => $message]);
    }

    public function seen(Request $request)
    {
        Message::where('ticket_id' , $request->input('ticket_id'))->where('user_id' , '!=' , $request->input('user_id'))->update(['seen' => 1]);
        return response()->json(['status' => 200, 'message' => 'تم بنجاح']);
    }
}
