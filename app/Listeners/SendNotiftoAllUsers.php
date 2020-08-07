<?php

namespace App\Listeners;

use App\Events\AdminCreateEvent;
use App\Notifikasi;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNotiftoAllUsers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AdminCreateEvent  $event
     * @return void
     */
    public function handle(AdminCreateEvent $event)
    {
        $users = User::all();
        
        foreach($users as $user){
            $data = [
                'notifikasi_id'=>'nt-'.sha1(rand()),
                'user_id'=>$user->user_id,
                'event_id'=>$event->event->event_id,
                'message'=>'Acara baru dari Admin',
                'date_notified' => Carbon::now()->toDateString(),
            ];
            Notifikasi::create($data);
        }
    }
}
