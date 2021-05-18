<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Carbon\Carbon;
class TahunAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    static function is_api($request){
        if(strpos($request->url(), url('api').'/')!==false){
            return true;
        }

        return false;

    }
    public function handle($request, Closure $next)
    {

        $tahun=$request->route('tahun')??date('Y');


        $visitor_data=[
          'browser'=>$request->visitor()->browser(),
          'device'=>$request->visitor()->device(),
          'platform'=>$request->visitor()->platform(),
          'ip'=>$request->visitor()->ip(),
          'useragent'=>$request->visitor()->useragent(),
          'date'=>Carbon::now()->startOfday()->format('Y-m-d'),
          'languages'=>json_encode($request->visitor()->languages())
        ];


        $visitor_update=$visitor_data;
        $visitor_update['url']=$request->url();
        $visitor_update['method']=$request->method();
        $visitor_update['updated_at']=Carbon::now();
        $visitor_update['created_at']=DB::raw("(case when created_at is null then CURRENT_TIMESTAMP else created_at end)");
        $visitor_update['request']=json_encode($request->visitor()->request());
        $up=DB::table('tb_visitor')->where($visitor_data)->first();

        DB::table('tb_visitor')->updateOrinsert($visitor_data,$visitor_update);

        if(!$up){
          session(['popup_available_run'=>true]);
        }else{
          session(['popup_available_run'=>false]);

        }
        



        if(!isset($GLOBALS['list_tahun_access'])){
            $GLOBALS['list_tahun_access']=(DB::table('tahun_access')->select('tahun')->orderBy('tahun','desc')->limit(5)->get()->pluck('tahun'));
        }

        if((int)$tahun<2020){

              if (!static::is_api($request)) {
                    return redirect()->route('index',['tahun'=>$GLOBALS['list_tahun_access'][0]]);
            }

        }


         if(!in_array($tahun,$GLOBALS['list_tahun_access']->toArray())){
              if (!static::is_api($request)) {

                  return redirect()->route('index',['tahun'=>$GLOBALS['list_tahun_access'][0]]);
            }

        }

        if((empty($tahun)) OR (!is_numeric($tahun))){
              if (!static::is_api($request)) {
                return redirect()->route('index',['tahun'=>date('Y')]);
            }
        }else{
            $GLOBALS['tahun_access']=$tahun;
            return $next($request);
        }
        return $next($request);

    }
}
