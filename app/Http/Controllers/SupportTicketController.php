<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Ticket;
use App\TicketReply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupportTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(9);
        if (auth()->user()->user_type == 'customer') {
            return view('frontend.support_ticket.index', compact('tickets'));
        } elseif (auth()->user()->user_type == 'seller') {
            return view('frontend.seller.support_ticket.index', compact('tickets'));
        }
    }

    public function admin_index($type = 0)
    {
        if ($type == 1) {
            $tickets = Ticket::orderBy('id', 'desc')->where('type', 1)->paginate(9);
        } elseif ($type == 2) {
            $tickets = Ticket::orderBy('id', 'desc')->where('type', 2)->paginate(9);
        } elseif ($type == 3) {
            $tickets = Ticket::orderBy('id', 'desc')->where('type', 3)->paginate(9);
        } else {
            $tickets = Ticket::orderBy('id', 'desc')->paginate(9);
        }
        return view('support_tickets.index', compact('tickets', 'type'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'subject' => 'required',
            'details' => 'required',
        ]);
        $ticket = new Ticket;
        $ticket->code = max(100000, (Ticket::latest()->first() != null ? Ticket::latest()->first()->code + 1 : 0));
        $ticket->user_id = Auth::user()->id;
        $ticket->subject = $request->subject;
        $ticket->details = $request->details;
        $ticket->type = $request->type;
        $files = array();
        if ($request->hasFile('attachments')) {
            foreach ($request->attachments as $key => $attachment) {
                $item['name'] = $attachment->getClientOriginalName();
                $item['path'] = $attachment->store('uploads/support_tickets/');
                array_push($files, $item);
            }
            $ticket->files = json_encode($files);
        }

        if ($ticket->save()) {
            flash('Ticket has been sent successfully')->success();
            return redirect()->route('support_ticket.index', get_country()->code);
        } else {
            flash('Something went wrong')->error();
        }
    }

    public function admin_store(Request $request)
    {
        //dd($request->all());
        $this->validate(request(), [
            'ticket_id' => 'required|exists:tickets,id',
            'reply' => 'required',
            'status' => 'required',
        ]);

        $ticket_reply = new TicketReply;
        $ticket_reply->ticket_id = $request->ticket_id;
        $ticket_reply->user_id = Auth::user()->id;
        $ticket_reply->reply = $request->reply;

        $files = array();

        if ($request->hasFile('attachments')) {
            foreach ($request->attachments as $key => $attachment) {
                $item['name'] = $attachment->getClientOriginalName();
                $item['path'] = $attachment->store('uploads/support_tickets/');
                array_push($files, $item);
            }
            $ticket_reply->files = json_encode($files);
        }

        $ticket_reply->ticket->status = $request->status;
        $ticket_reply->ticket->save();
        if ($ticket_reply->save()) {
            flash('Reply has been sent successfully')->success();
            return back();
        } else {
            flash('Something went wrong')->error();
        }
    }

    public function seller_store(Request $request)
    {

        $this->validate(request(), [
            'ticket_id' => 'required|exists:tickets,id',
            'reply' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        $ticket_reply = new TicketReply;
        $ticket_reply->ticket_id = $request->ticket_id;
        $ticket_reply->user_id = $request->user_id;
        $ticket_reply->reply = $request->reply;

        $files = array();

        if ($request->hasFile('attachments')) {
            foreach ($request->attachments as $key => $attachment) {
                $item['name'] = $attachment->getClientOriginalName();
                $item['path'] = $attachment->store('uploads/support_tickets/');
                array_push($files, $item);
            }
            $ticket_reply->files = json_encode($files);
        }

        $ticket_reply->ticket->viewed = 0;
        $ticket_reply->ticket->status = 'pending';
        $ticket_reply->ticket->save();
        if ($ticket_reply->save()) {
            flash('Reply has been sent successfully')->success();
            return back();
        } else {
            flash('Something went wrong')->error();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($country,$id)
    {
        $ticket = Ticket::findOrFail(decrypt($id));
        $ticket_replies = $ticket->ticketreplies;
        return view('frontend.support_ticket.show', compact('ticket', 'ticket_replies'));
    }

    public function seller_show($country,$id)
    {
        $ticket = Ticket::findOrFail(decrypt($id));
        $ticket_replies = $ticket->ticketreplies;
        return view('frontend.seller.support_ticket.show', compact('ticket', 'ticket_replies'));
    }

    public function admin_show($id)
    {
        $ticket = Ticket::findOrFail(decrypt($id));
        $ticket->viewed = 1;
        $ticket->save();
        $ticket_replies = $ticket->ticketreplies;
        return view('support_tickets.show', compact('ticket', 'ticket_replies'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
