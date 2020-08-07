<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens;

    protected $table = 'pengguna';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id','name', 'email', 'password','role_id','is_active','role_id','phone_number','jabatan','gender','device_token'
    ];
    protected $hidden = [
        'password', 'remember_token'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function groupUsers(){
        return $this->belongsToMany('App\Group','group_users','user_id','group_id')->withTimestamps();
    }

    public function eventUsers(){
        return $this->belongsToMany('App\Event','user_event', 'user_id','event_id');
    }
    public function jabatanUsers(){
        return $this->belongsToMany('App\Jabatan','jabatan_user','user_id','jabatan_id')->withTimestamps();
    }

    public function UserNotif(){
        return $this->belongsToMany('App\Notifikasi','notifikasi','user_id','notifikasi_id')->withTimestamps();
    }
}
