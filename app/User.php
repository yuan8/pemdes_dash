<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use HP;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','api_token','role','kode_daerah','nomer_telpon',
        'nik','nip','profile_pic','jabatan','walidata','main_daerah','is_active','wa_number','wa_notif','email_notif'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','api_token'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function nama_daerah_handle(){
        if($this->kode_daerah and $this->role==4){
            return HP::daerah_level($this->kode_daerah);
        }else{
            return null;
        }
    }

    public function routeNotificationForChatAPI(){
        return str_replace('+','',str_replace('-', '', $this->nomer_telpon));
    }

    public function receivesBroadcastNotificationsOn()
    {
        return 'App.User.'.$this->id;
    }
}
