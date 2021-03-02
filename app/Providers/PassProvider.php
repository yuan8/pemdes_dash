<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
class PassProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }


    public static function time_match($time,$interval=5){
        // Time Asia/Jakarta
        // required Carbon
        // time [h]|[i]|[m]|[d]
        // recomendation spliter time ||T%$%$^^&***)(^)A


        $time=exlpode('|',(string)$time);
        $time=Carbon::parse(date('Y').'-'.$time[2].'-'.$time[3].' '.$time[0].':'.$time[1].':00');
        $start=Carbon::now()->addMinutes(($interval*-1));

        $end=Carbon::now()->addMinutes($interval);

        $time=Carbon::parse($time);

        if(($start->greaterThanOrEqualTo($time)) and ($end->lessThanOrEqualTo($time)) ){
            return true;
        }else{
            return false;
        }

    }

    static $pass_map=[
        'A'=>'****',
        'b'=>'O|P*L',
        'C'=>'|OL*P',
        'v'=>'78**II:',
        'E'=>'284^444',
        '1'=>'d|u|a',
        '0'=>'encxxiptZoo',
        'r'=>'QrS*|&555',
        '6'=>'pic&&&%**',
        '3'=>'88#@)',
        'MTI'=>'!@#$%'

    ];

    static $enc=[
        'A'=>'F|U|X',
        'G'=>'|Xu|H',
        'b'=>'78**II:',
        'C'=>'|OL*P',
        'd'=>'O|P*L',
        'E'=>'encriptZoo',
        '1'=>'****',
        '0'=>'234^444',
        'f'=>'^^LLL^^',
        '9'=>'ClS&555',
    ];

    public static function encode($text){
        $base=base64_encode($text);
        $base=base64_encode($base);


        foreach(static::$enc as $key=>$e){
            $base=str_replace($key, $e,$base);
        }
        return $base;
    } 

    public static function decode($text){
        $base=$text;
        foreach(static::$enc as $key=>$e){
            $base=str_replace($e, $key,$base);
        }
        $base=base64_decode($base);
        $base=base64_decode($base);

        return $base;
    }   

    public static function pass_encode($text){
        $base=base64_encode($text);
        $base=base64_encode($base);


        foreach(static::$pass_map as $key=>$e){
            $base=str_replace($key, $e,$base);
        }
        return $base;
    } 

    public static function pass_decode($text){
         $base=$text;
        foreach(static::$pass_map as $key=>$e){
            $base=str_replace($e, $key,$base);
        }

        $base=base64_decode($base);
        $base=base64_decode($base);


        return $base;
    }

    public static function pass_match($pass,$record){

        if(static::pass_encode($pass)==$record){
            return true;
        }else{
            return false;
        }
    }
}
