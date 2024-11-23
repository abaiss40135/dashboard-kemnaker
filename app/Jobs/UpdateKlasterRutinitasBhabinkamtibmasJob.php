<?php

namespace App\Jobs;

use App\Models\KlasterRutinitasBhabinkamtibmas;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateKlasterRutinitasBhabinkamtibmasJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     *
     */
    private $klaster;

    public function __construct(array $klaster)
    {
        $this->klaster = $klaster;
    }

    public function handle()
    {

        DB::beginTransaction();
        try {
            KlasterRutinitasBhabinkamtibmas::updateOrCreate([
                'user_id'       => $this->klaster['user_id'],
                'minggu_ke'     => $this->klaster['minggu_ke'],
                'tahun'         => $this->klaster['tahun']
            ], [
                'personel_id'       => $this->klaster['personel_id'],
                'total_laporan'     => $this->klaster['total_laporan'],
                'klaster_rutinitas' => $this->klaster['klaster_rutinitas'],
                'bulan'             => $this->klaster['bulan'],
            ]);
            DB::commit();
            return 'success';
        } catch (\Exception $exception) {
            DB::rollBack();
            $exceptionInfo = [
                'data' => $this->klaster,
            ];
            Log::alert($exception->getMessage(), $exceptionInfo);
            return [
                'status'  => 'error',
                'message' => $exception->getMessage(),
                'payload' => $exceptionInfo,
            ];
        }
    }
}
