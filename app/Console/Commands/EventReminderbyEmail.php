<?php

namespace App\Console\Commands;

use App\Event;
use App\Mail\EventReminderEmail;
use App\Notifikasi;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EventReminderbyEmail extends Command
{
    protected $signature = 'event:email';

    protected $description = 'Send email to user about their event';

    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        try {
            $data = [];
            $events = Event::where([['event_date','=',Carbon::now()->toDateString()],['user_id','like','adm_1']])->get();
            $users = User::all(); // * registered users on our app
            foreach($events as $event){
                foreach($users as $user){
                    $data = ["notifikasi_id"=>'nt-'.sha1(rand()),
                                "message"=>"event today", 
                                "event_id"=>$event->event_id, 
                                "user_id"=>$user->user_id, 
                                "date_notified"=>Carbon::now()->toDateString(),
                                "already_notified"=>0,
                            ];
                    self::sendEmailTo($user->user_id,$event->toArray()); // * Sending by Email
                    Notifikasi::updateOrCreate($data); 
                }
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
        return "Sended!";
    }

    private function sendEmailTo($user_id,$event){
        $user = User::where('user_id',$user_id)->first();
        $nextSend = now()->addMinutes(5);
        Mail::to($user)
                    ->later($nextSend, new EventReminderEmail($user,$event));
        
    }
}
