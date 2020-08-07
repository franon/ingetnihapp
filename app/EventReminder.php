<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventReminder extends Model
{
    protected $table = 'event_reminder';
    protected $fillable = ['event_id', 'user_id'];

    public function event(){
        return $this->belongsTo('App\Event', 'event_id');
    }

    public function dudu(){
        return "wow";
    }
}
