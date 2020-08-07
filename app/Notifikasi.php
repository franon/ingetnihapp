<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\Topics;

// use FCM;

class Notifikasi extends Model
{
    protected $table = "notifikasi";
    public $incrementing = false;
    protected $primaryKey = "notifikasi_id";
    protected $keyType = "string";
    
    protected $fillable = [ 'user_id','event_id','berita_id',
                            'date_notified','group_id','notifikasi_id','already_notified','message'];

    public function groupNotif(){
        return $this->belongsTo('App\Group');
    }

    public function UserNotif(){
        // return $this->belongsTo('App\User','notifikasi','user_id','notifikasi_id')->withTimestamps();
        return $this->belongsTo('App\User', 'user_id', 'notifikasi_id');
    }

    public static function toSingleDevice($token,$title="my-title", $body='Hello World',$icon, $click_action){
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)
                            ->setSound('default')
                            ->setBadge(1)
                            ->setIcon($icon)
                            ->setClickAction($click_action);

        $dataBuilder = new PayloadDataBuilder();
        // $dataBuilder->addData(['a_data' => 'my_data']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = $token;
        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();

        // return Array - you must remove all this tokens in your database
        $downstreamResponse->tokensToDelete();

        // return Array (key : oldToken, value : new token - you must change the token in your database)
        $downstreamResponse->tokensToModify();

        // return Array - you should try to resend the message to the tokens in the array
        $downstreamResponse->tokensToRetry();

        // return Array (key:token, value:error) - in production you should remove from your database the tokens
        $downstreamResponse->tokensWithError();
    }

    public static function toMultiDevice($model,$title="my-title", $body='Hello World',$icon, $click_action, $data=null){
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)
                            ->setSound('default')
                            ->setBadge(1)
                            ->setIcon($icon)
                            ->setClickAction($click_action);

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($data);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        // You must change it to get your tokens
        $tokens = $model->pluck('device_token')->toArray();

        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);

        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();
        $downstreamResponse->tokensToDelete();
        $downstreamResponse->tokensToModify();
        $downstreamResponse->tokensToRetry();
        $downstreamResponse->tokensWithError();
    }

    public function singleTopic($type_topics, $title, $body){
        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)
                            ->setSound('default');

        $notification = $notificationBuilder->build();

        $topic = new Topics();
        $topic->topic($type_topics);

        $topicResponse = FCM::sendToTopic($topic, null, $notification, null);

        $topicResponse->isSuccess();
        $topicResponse->shouldRetry();
        $topicResponse->error();
    }
}
