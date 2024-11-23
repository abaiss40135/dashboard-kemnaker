<?php

namespace App\Observers;

use App\Jobs\SendPusatInformasiNotificationJob;
use App\Models\UuLuarPolri;

class UndangUndangEksternalPolriObserver
{
    public function created(UuLuarPolri $uuLuarPolri)
    {
        SendPusatInformasiNotificationJob::dispatch([
            'type'          => 'undang-undang eksternal polri',
            'id'            => $uuLuarPolri->id,
            'title'         => $uuLuarPolri->nama_uu,
            'description'   => $uuLuarPolri->deskripsi_uu,
            'thumbnail'     => '',
            'file'          => $uuLuarPolri->file_uu,
            'created_at'    => $uuLuarPolri->created_at,
        ]);
    }

    public function updated(UuLuarPolri $uuLuarPolri)
    {
        //
    }

    public function deleted(UuLuarPolri $uuLuarPolri)
    {
        //
    }

    public function restored(UuLuarPolri $uuLuarPolri)
    {
        //
    }

    public function forceDeleted(UuLuarPolri $uuLuarPolri)
    {
        //
    }
}
