<?php

namespace App\Actions;

use Illuminate\Support\Facades\DB;

class RefreshLaporanBhabinkamtibmasViewTableAction
{
    public function __invoke()
    {
        DB::statement('REFRESH MATERIALIZED VIEW CONCURRENTLY laporan_bhabinkamtibmas');
    }
}
