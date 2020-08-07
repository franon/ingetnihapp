<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\EventReminder;
use App\Http\Controllers\Controller;
use App\Mail\EventReminderEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Reminder extends Controller
{
    public function __construct()
    {
        
    }

    public function _remind(EventReminder $eventReminder){
        $dataRemind = DB::table('s')->select('event_id')->get();
        
    }

    
}
