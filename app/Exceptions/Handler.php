<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Illuminate\Auth\AuthenticationException;

use Auth;
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

     static function is_api($request){
        if(strpos($request->url(), url('api').'/')!==false){
            return true;
        }

        return false;

    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return static::is_api($request)
                ? response()->json([
                    'status' => 401,
                    'status_text'=>$exception->getMessage(),
                    'message'=>[
                        'bold'=>$exception->getMessage()
                    ],
                    'filters'=>[],
                    'access_user_meta'=>[],
                    'schedule'=>[],
                    'meta'=>[],
                    'count_data'=>0,
                    'data'=>[]
                ], 401)
                : redirect()->guest(route('login'));
    }
}
