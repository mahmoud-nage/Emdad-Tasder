<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['user_id', 'ticket_id', 'body', 'attachment'];

    public function Ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
