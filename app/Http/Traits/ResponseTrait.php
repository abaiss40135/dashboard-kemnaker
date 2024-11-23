<?php


namespace App\Http\Traits;

use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

trait ResponseTrait
{
    protected function responseSuccess(array $data){
        return response()->json([
            'status'    => 'success',
            'message'   => $data['message'],
            'code'      => Response::HTTP_OK,
            'data'      => $data['data'] ?? null,
        ], Response::HTTP_OK);
    }

    protected function responseError($exception){
        $message = $exception->getMessage();
        if (in_array(config('app.env'), ['prod', 'production'])){
            if ($exception instanceof \Doctrine\DBAL\Exception\ReadOnlyException) {
                $message = 'Server sedang sibuk, mohon coba beberapa saat lagi';
            }
            if ($exception instanceof \Illuminate\Database\QueryException){
                $message = 'Terjadi kesalahan pada database, mohon coba beberapa saat lagi';
            }
        }

//        app('sentry')->captureException($exception);
        return response()->json([
            "status"    =>  "error",
            "message"   =>  $message,
            "code"      =>  Response::HTTP_INTERNAL_SERVER_ERROR
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    protected function responseValidation($e){
        return response()->json([
            'errors'    => $e->errors(),
            'message'   => $e->getMessage()
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function responseForbidden(){
        return response()->json([
            'errors'    => 'Forbidden',
            'message'   => 'Anda tidak memiliki otoritas untuk melihat data ini'
        ], Response::HTTP_FORBIDDEN);
    }
}
