<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventReminderEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    
    private $user;
    private $event;

    public function __construct($user, $event)
    {
        $this->user = $user;
        $this->event = $event;
    }
    public function build()
    {
        // dd($this->user);
        return $this->subject($this->event["event_name"])
                    ->markdown('mails.event-view')->with([
                                                    'user'=>$this->user,
                                                    'event'=>$this->event,
                                                    ]);
    }
}