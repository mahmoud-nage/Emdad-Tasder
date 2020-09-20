<?php

namespace App\Http\Controllers\Affiliate;

use App\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $tickets = Ticket::where('user_id' , auth()->user()->id)->latest()->get();
        return view('affiliate.tickets.index' , compact('tickets'));
    }

    public function show($id)
    {
        $ticket = Ticket::find($id);
        return view('affiliate.tickets.show' , compact('ticket'));
    }

    public function store(Request $request)
    {
        $this->validate(request(),[
            'subject' => 'required',
            'body' => 'required',
        ]);
        $user = auth()->user();
        $ticket = Ticket::create([
            'code' => max(100000, (Ticket::latest()->first() != null ? Ticket::latest()->first()->code + 1 : 0)),
            'subject' => $request->input('subject'),
            'details' => $request->input('body'),
            'user_id' => $user->id,
            'files' => $request->hasFile('attachment') ?  $request->file('attachment')->store('/uploads/tickets/') : null,
        ]);

        return redirect()->route('affiliate.tickets.index');
    }
}
