<?php

namespace App\Actions\BigDataPolri;

use App\Http\Controllers\API\BigDataPolri\BigDataController;
use App\Http\Resources\DDSWargaResource;
use App\Models\Dds_warga;
use Illuminate\Support\Facades\Log;

class SendKunjungan
{
    public function __invoke()
    {
        $date               = now()->subDay();
        $bigDataController  = new BigDataController();
        $query              = Dds_warga::has('laporan_informasi')->with(['laporan_informasi', 'pendapat_warga'])->whereDate('created_at', $date);
        $logInfo            = [
            'date' => $date,
            'type' => 'kunjungan',
            'total'=> $query->count()
        ];

        try {
            $query->chunk(100, function ($dds) use ($bigDataController){
                foreach ($dds as $laporan){
                    $array  = new DDSWargaResource($laporan);
                    $bigDataController->pushData('kunjungan', json_decode($array->toJson(), true));
                }
            });
            Log::info('BIGDATA_SCHEDULER', [
                'info'      => $logInfo,
                'message'   => 'Success'
            ]);
        } catch (\Exception $exception){
            Log::error('BIGDATA_SCHEDULER', [
                'info'      => $logInfo,
                'message'   => $exception->getMessage()
            ]);
        }
    }
}
