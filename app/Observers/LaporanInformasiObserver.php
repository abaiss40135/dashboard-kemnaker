<?php

namespace App\Observers;

use App\Jobs\UpdateJumlahKeywordJob;
use App\Models\LaporanInformasi;
use Illuminate\Support\Facades\Bus;

class LaporanInformasiObserver
{
    /**
     * Handle the laporan informasi "created" event.
     *
     * @param LaporanInformasi $laporanInformasi
     */
    public function created(LaporanInformasi $laporanInformasi)
    {
        //
    }

    /**
     * Handle the laporan informasi "updated" event.
     *
     * @param LaporanInformasi $laporanInformasi
     */
    public function updated(LaporanInformasi $laporanInformasi)
    {
        //
    }

    /**
     * Handle the laporan informasi "deleted" event.
     *
     * @param LaporanInformasi $laporanInformasi
     */
    public function deleted(LaporanInformasi $laporanInformasi)
    {
        $chainUpdateJumlahKeywordJob = [];
        $keywords = $laporanInformasi->load('keywords')->keywords;
        foreach ($keywords as $keyword) {
            $chainUpdateJumlahKeywordJob[] = new UpdateJumlahKeywordJob($keyword, $keyword->loadCount('laporanInformasis')->laporan_informasi_count);
        }

        Bus::batch($chainUpdateJumlahKeywordJob)->dispatch();
    }

    /**
     * Handle the laporan informasi "restored" event.
     *
     * @param LaporanInformasi $laporanInformasi
     */
    public function restored(LaporanInformasi $laporanInformasi)
    {
        //
    }

    /**
     * Handle the laporan informasi "force deleted" event.
     *
     * @param LaporanInformasi $laporanInformasi
     */
    public function forceDeleted(LaporanInformasi $laporanInformasi)
    {
        //
    }
}
