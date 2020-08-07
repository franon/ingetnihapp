<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'group';
    protected $primaryKey = 'group_id';
    protected $fillable = ['group_id','group','created_by'];
    public $incrementing = false;
    protected $keyType = 'string';

    public function groupUsers(){
        return $this->belongsToMany('App\User','group_users','group_id','user_id')->withTimestamps();
    }

    public function groupEvent(){
        return $this->belongsToMany('App\Event','group_event' ,'group_id','event_id');
    }

    public function groupNotif(){
        return $this->hasMany('App\Notifikasi');
    }
}
