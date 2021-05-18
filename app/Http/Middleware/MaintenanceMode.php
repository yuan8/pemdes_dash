<?php

namespace App\Http\Middleware;

use Closure;

class MaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $maintanance=config('maintenace.status');
        if($maintenace){
            return redirect()->route('maintanace');
        }
        
        return $next($request);
    }
}
