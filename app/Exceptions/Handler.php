<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'error' => 'Entry for '
                .str_replace('App\\', '', $exception->getModel())
                .' not found'
            ], 404);
        }

        // redirect login ketika session habis
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            return redirect()->route('login');
        }
        if ($exception instanceof ThrottleReceiveNIBException){
            return response()->json([
                'responreceiveNIB' => [
                    'status' => 2,
                    'keterangan' => 'Too Many Attempt Request Simultaneously.'
                ]
            ]);
        }
        if (in_array(config('app.env'), ['prod', 'production'])){
            if ($exception instanceof \Doctrine\DBAL\Exception\ReadOnlyException) {
                return response()->view('errors.500', ["message" => "Server sedang sibuk, mohon coba beberapa saat lagi"], 500);
            }
            if ($exception instanceof \Illuminate\Database\QueryException){
                return response()->view('errors.500', ["message" => "Terjadi kesalahan pada database, mohon coba beberapa saat lagi"], 500);
            }
        }

        if($this->isHttpException($exception)){
            switch($exception->getStatusCode()){
                // case 404 :
                //     return response()->view('errors.404' , [] , $exception->getMessage());
                // break;
                case 500 :
                    abort(500, $exception->getMessage());
                break;
            }
        }

        return parent::render($request, $exception);

    }
}
