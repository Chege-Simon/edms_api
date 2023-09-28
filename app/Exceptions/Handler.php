<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof UnauthorizedHttpException) {
            if ($e->getMessage() === 'Token not provided') {
                return response()->json(['Error' => 'Token is not provided'], 401);
            } else {
                return new JsonResponse(['Error' => 'Could not decode token: Please provide a valid token'], 401);
            }
        } elseif ($e instanceof TokenInvalidException) {
            return new JsonResponse(['Error' => 'Could not decode token: Please provide a valid token'], 401);
        } elseif ($e instanceof TokenExpiredException) {
            return response()->json(['error' => 'Token is expired'], 401);
        } elseif ($e instanceof JWTException) {
            return response()->json(['error' => 'There is a problem with your token'], 401);
        }

        return parent::render($request, $e);
    }
}
