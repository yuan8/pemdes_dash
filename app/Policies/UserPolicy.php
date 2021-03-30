<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function before($user)
    {

        if ( $user->is_active) {
            return true;
        }

    }

    public function is_active($users){
         print_r($user);
        die;
        if($user->is_active){

            return true;
        }else{
            return false;
        }
    }


    public function editRole($user)
    {
        if ($user->role==1) {
            return true;
        }else{
            return false;
        }
    }
     public function is_super($user)
    {
        if ($user->role==1) {
            return true;
        }else{
            return false;
        }
    }





}
