<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use HP;
use DB;
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
        'nik','nip','profile_pic','jabatan','walidata','main_daerah','is_active','wa_number','wa_notif','email_notif','api_access'
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

    public function instansi_pusat(){
        return DB::table('tb_user_instansi as ui')
        ->selectRaw('i.*')
        ->join('master_instansi as i','i.id','=','ui.id_instansi')
        ->where('ui.id_user',$this->id)->first();
    }

    public function routeNotificationForChatAPI(){
        return str_replace('+','',str_replace('-', '', $this->nomer_telpon));
    }

    public function receivesBroadcastNotificationsOn()
    {
        return 'App.User.'.$this->id;
    }
}
