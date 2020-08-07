<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = "acara";
    public $incrementing = false;
    protected $primaryKey = "event_id";
    protected $keyType = "string";
    
    protected $fillable = [ 'event_id','user_id','event_name',
                            'event_detail','tag_id','remind_to',
                            'event_date','event_date_end','event_time',
                            'created_by','views'];

    public function eventUsers(){
        return $this->belongsToMany('App\User','user_event', 'event_id','user_id');
    }

    public function groupEvent(){
        return $this->belongsToMany('App\Group','group_event','event_id', 'group_id');
    }

    public function eventReminder(){
        return $this->hasMany('App\EventReminder', 'event_id');
    }
}
