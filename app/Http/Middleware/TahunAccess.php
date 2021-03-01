<?php

namespace App\Http\Middleware;

use Closure;
use DB;
class TahunAccess
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

        $tahun=$request->route('tahun')??date('Y');


        if(!isset($GLOBALS['list_tahun_access'])){
            $GLOBALS['list_tahun_access']=(DB::table('tahun_access')->select('tahun')->orderBy('tahun','desc')->limit(5)->get()->pluck('tahun'));
        }

        if((int)$tahun<2018){
            return redirect()->route('index',['tahun'=>$GLOBALS['list_tahun_access'][0]]);

        }




         if(!in_array($tahun,$GLOBALS['list_tahun_access']->toArray())){
            return redirect()->route('index',['tahun'=>$GLOBALS['list_tahun_access'][0]]);

        }

        if((empty($tahun)) OR (!is_numeric($tahun))){

            return redirect()->route('index',['tahun'=>date('Y')]);
        }else{
            $GLOBALS['tahun_access']=$tahun;
            return $next($request);
        }
    }
}
