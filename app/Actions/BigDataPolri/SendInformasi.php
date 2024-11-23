<?php

namespace App\Actions\BigDataPolri;

use App\Http\Controllers\API\BigDataPolri\BigDataController;
use App\Http\Resources\DeteksiDiniResource;
use App\Models\Deteksi_dini;
use Illuminate\Support\Facades\Log;

class SendInformasi
{
    public function __invoke()
    {
        $date               = now()->subDay();
        $bigDataController  = new BigDataController();
        $query              = Deteksi_dini::has('laporan_informasi')->with(['laporan_informasi'])->whereDate('created_at', $date);
        $logInfo            = [
            'date' => $date,
            'type' => 'informasi',
            'total'=> $query->count()
        ];

        try {
            $query->chunk(100, function ($deteksi_dini) use ($bigDataController){
                foreach ($deteksi_dini as $laporan){
                    $array  = new DeteksiDiniResource($laporan);
                    $bigDataController->pushData('informasi', json_decode($array->toJson(), true));
                }
            });
            Log::info('BIGDATA_SCHEDULER', [
                'info'      => $logInfo,
                'message'   => 'success'
            ]);
        } catch (\Exception $exception){
            Log::error('BIGDATA_SCHEDULER', [
                'info'      => $logInfo,
                'message'   => $exception->getMessage()
            ]);
        }
    }
}
