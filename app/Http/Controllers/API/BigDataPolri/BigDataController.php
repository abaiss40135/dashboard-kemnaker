<?php

namespace App\Http\Controllers\API\BigDataPolri;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class BigDataController extends Controller
{
    public function pushData(string $type, array $data)
    {
        if (!in_array($type, ['kunjungan', 'informasi', 'solving'])){
            return response()->json([
                'errors'    => 'Error',
                'message'   => 'Tipe tidak tersedia'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            $payloads = [
                'type'  => $type,
                'val'   => $data
            ];

            $response = Http::withBasicAuth(config('bigdata-api.username'), config('bigdata-api.password'))
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'cid' => config('bigdata-api.cid')
                ])
                ->post(config('bigdata-api.url'), $payloads);

            /*Log::info('BIGDATA', [
                'payloads' => $payloads,
                'message'  => $response->collect()
            ]);*/

            return $response->collect();
        } catch (\Exception $exception){
            Log::error('BIGDATA', [
                'payloads' => $payloads,
                'message'  => $exception->getMessage()
            ]);

            return $this->responseError($exception);
        }
    }
}
