<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

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
     * @param  \Exception  $e
     * @return JsonResponse|\Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if($e instanceof BaseException){
            return new JsonResponse(
                config('app.debug') ? [
                    'message' => $e->getMessage(),
                    'title'  => $e->getTitle(),
                    'exception' => get_class($e),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => collect($e->getTrace())->map(function ($trace) {
                        return Arr::except($trace, ['args']);
                    })->all(),
                ] : [
                    'title'  => $e->getTitle(),
                    'message' =>  $e->getMessage() ?: 'Base Exception',
                ],
                500,
                $this->isHttpException($e) ? $e->getHeaders() : [],
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
            );
        }elseif ($e instanceof ValidateException){
            return new JsonResponse([
                    'title'  => $e->getTitle(),
                    'message' =>  $e->getMessage() ?: 'Base Exception',
                ],
                500,
                $this->isHttpException($e) ? $e->getHeaders() : [],
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
            );
        }
        return parent::render($request, $e);
    }
}
