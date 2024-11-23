<?php

namespace App\Jobs;

use App\Models\AkumulasiLaporanBhabinkamtibmas;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateAkumulasiLaporanBhabinkamtibmasJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Array user_id and periode month year
     * From laporan bhabinkamtibmas observer
     * @var array
     */
    protected array $akumulasi;

    public function __construct(array $akumulasi)
    {
        $this->akumulasi = $akumulasi;
    }

    /**
     * Update jumlah akumulasi per user_id
     * Handle by LaporanBhabinkamtibmasObserver Model
     * Periode: Setiap terjadi penambahan atau penghapusan dds, deteksi dini, ps1 2 dan 3
     */
    public function handle()
    {
        try {
            /**
             * Update or insert data akumulasi periode
             * unique by: user_id dan periode
             */
            //$this->user->akumulasi_laporans()->upsert($this->akumulasi, ['user_id', 'periode']); //this query do direct request to db, not hproxy db
            foreach ($this->akumulasi as $akumulasi) {
                DB::transaction(function() use ($akumulasi) {
                    AkumulasiLaporanBhabinkamtibmas::updateOrCreate([
                        'user_id' => $akumulasi['user_id'],
                        'periode' => $akumulasi['periode']
                    ], Arr::except($akumulasi, ['user_id', 'periode']));
                });
            }
            return 'Success';
        } catch (\Exception $exception) {
            $exceptionInfo = [
                'data' => $this->akumulasi,
            ];
            Log::alert($exception->getMessage(), $exceptionInfo);
            return [
                'status' => 'error',
                'message' => $exception->getMessage(),
                'payload' => $exceptionInfo,
            ];
        }
    }
}
