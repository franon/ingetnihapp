<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Notifikasi;
use Edujugon\PushNotification\PushNotification;
use Illuminate\Http\Request;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class pushNotifAndroidController extends Controller
{

    public function testing(){
        $notif = new Notifikasi();
        $token = 'Your_token_device';
        $notif->toSingleDevice($token,'lah ini notif?','iya',null, null);

        return response()->json(["status"=>200 ,"message"=>"Coba Push 1", "data"=>$notif],200);
    }
    // public function broadcastMessage(Request $request){
    //     $optionBuilder = new OptionsBuilder();
    //     $optionBuilder->setTimeToLive(60*20);

    //     $notificationBuilder = new PayloadNotificationBuilder('my title');
    //     $notificationBuilder->setBody('Hello world')
    //                     ->setSound('default')
    //                     ->setClickAction('http://localhost:8000/api/get/event/all');

    //     $dataBuilder  = new PayloadDataBuilder();
    //     $dataBuilder->addData([
    //         'title_data'=>'value_data'
    //     ]);

    //     $option = $optionBuilder->build();
    //     $notification = $notificationBuilder->build();
    //     $data = $dataBuilder->build();
    // }
}
