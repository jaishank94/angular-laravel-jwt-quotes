<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Tymon\JWTAuth\Execption\TokenExpiredException;
use Tymon\JWTAuth\Execption\TokenInvalidException;
use Tymon\JWTAuth\Execption\JWTException;
use Response;

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
        if($exception instanceof TokenExpiredException){
            return Response::json(['error'=>'Token Expired'], $exception->getStatusCode());
        } elseif($exception instanceof TokenInvalidException){
            return Response::json(['error'=>'Token Invalid'], $exception->getStatusCode());
        } elseif($exception instanceof JWTException){
            return Response::json(['error'=>'Token Fetching Error'], $exception->getStatusCode());
        }
        return parent::render($request, $exception);
    }
}
