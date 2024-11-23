<?php

namespace App\Observers;

use App\Actions\RefreshAkumulasiLaporanBhabinkamtibmasViewTableAction;
use App\Actions\RefreshKlasterRutinitasBhabinkamtibmasViewTableAction;
use App\Models\Personel;

class PersonelObserver
{
    public function created(Personel $personel)
    {
//        $this->refreshPersonelRelatedView();
    }

    public function updated(Personel $personel)
    {
        //
    }

    public function deleted(Personel $personel)
    {
        //
    }

    public function restored(Personel $personel)
    {
        //
    }

    public function forceDeleted(Personel $personel)
    {
        //
    }

    private function refreshPersonelRelatedView()
    {
        $refreshAkumulasiLaporanView = new RefreshAkumulasiLaporanBhabinkamtibmasViewTableAction();
        $refreshKlasterisasiLaporanView = new RefreshKlasterRutinitasBhabinkamtibmasViewTableAction();

        $refreshAkumulasiLaporanView->execute();
        $refreshKlasterisasiLaporanView->execute();
    }
}
