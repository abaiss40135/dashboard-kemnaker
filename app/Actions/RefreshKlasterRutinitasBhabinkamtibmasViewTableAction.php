<?php

namespace App\Actions;

use Illuminate\Support\Facades\DB;

class RefreshKlasterRutinitasBhabinkamtibmasViewTableAction
{
    public function execute()
    {
        DB::statement('REFRESH MATERIALIZED VIEW CONCURRENTLY klaster_rutinitas_bhabinkamtibmas');
    }
}
