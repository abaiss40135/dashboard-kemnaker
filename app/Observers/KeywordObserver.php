<?php

namespace App\Observers;

use App\Jobs\UpdateJumlahKeywordJob;
use App\Models\Keyword;

class KeywordObserver
{
    public function created(Keyword $keyword)
    {
        //
    }

    public function updated(Keyword $keyword)
    {
        UpdateJumlahKeywordJob::dispatch($keyword, $keyword->loadCount('laporanInformasis')->laporan_informasi_count ?? 0);
    }

    public function deleted(Keyword $keyword)
    {
        //
    }

    public function restored(Keyword $keyword)
    {
        //
    }

    public function forceDeleted(Keyword $keyword)
    {
        //
    }
}
