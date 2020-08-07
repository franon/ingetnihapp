<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';
    protected $primaryKey = 'jabatan_id';
    protected $fillable = ['jabatan_id','jabatan_jenis'];
    public $incrementing = false;
    protected $keyType = 'string';

    public function jabatanUsers(){
        return $this->belongsToMany('App\User','jabatan_user','jabatan_id','user_id')->withTimestamps();
    }

    public function jabatanEvent(){
        return $this->belongsToMany('App\Event','jabatan_event' ,'jabatan_id','event_id');
    }

    public function jabatanNotif(){
        return $this->hasMany('App\Notifikasi');
    }
}
