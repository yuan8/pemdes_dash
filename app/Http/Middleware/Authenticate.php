<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Auth;
use Illuminate\Auth\AuthenticationException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */

   
    static function is_api($request){
        if(strpos($request->url(), url('api').'/')!==false){
            return true;
        }

        return false;

    }

    protected function redirectTo($request)
    {
     
            return route('login');
    }
}
