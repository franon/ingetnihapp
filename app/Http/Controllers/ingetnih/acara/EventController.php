<?php

namespace App\Http\Controllers\ingetnih\acara;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ingetnih\HomeController;
use Illuminate\Http\Request;

class EventController extends HomeController
{
    public function getAcaraSpesifik(Request $request){
        $event_id= $request->event_id;
        $event = parent::callAPI("GET", 'localhost:8000/api/get/event/'.$event_id,false);
        $event = json_decode($event);
        $event = $event->data;
        if(!empty(session()->get('token'))){
            $notifikasi = parent::Notifikasi();
            return view("ingetnih.event-detail",compact(['event','notifikasi']));
    }
    return view('ingetnih.event-detail',compact('event'));
}

}
