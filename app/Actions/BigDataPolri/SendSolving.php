<?php

namespace App\Actions\BigDataPolri;

use App\Http\Controllers\API\BigDataPolri\BigDataController;
use App\Http\Resources\ProblemSolvingResource;
use App\Models\Problem_solving;
use Illuminate\Support\Facades\Log;

class SendSolving
{
    public function __invoke()
    {
        $date               = now()->subDay();
        $bigDataController  = new BigDataController();
        $query              = Problem_solving::whereDate('created_at', $date);
        $logInfo            = [
            'date' => $date,
            'type' => 'solving',
            'total'=> $query->count()
        ];

        try {
            $query->chunk(100, function ($solvings) use ($bigDataController){
                foreach ($solvings as $laporan){
                    $array   = new ProblemSolvingResource($laporan);
                    $bigDataController->pushData('solving', json_decode($array->toJson(), true));
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
