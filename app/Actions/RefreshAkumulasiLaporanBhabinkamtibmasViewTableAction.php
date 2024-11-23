<?php

namespace App\Actions;

use Illuminate\Support\Facades\DB;

class RefreshAkumulasiLaporanBhabinkamtibmasViewTableAction
{
    public function execute()
    {
        DB::statement('REFRESH MATERIALIZED VIEW CONCURRENTLY akumulasi_laporan_bhabinkamtibmas');
    }
}
