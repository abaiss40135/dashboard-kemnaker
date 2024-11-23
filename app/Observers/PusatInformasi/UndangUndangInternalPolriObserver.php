<?php

namespace App\Observers\PusatInformasi;

use App\Jobs\SendPusatInformasiNotificationJob;
use App\Models\UuDalamPolri;

class UndangUndangInternalPolriObserver
{
    public function created(UuDalamPolri $uuDalamPolri)
    {
        SendPusatInformasiNotificationJob::dispatch([
            'type'          => 'undang-undang internal polri',
            'id'            => $uuDalamPolri->id,
            'title'         => $uuDalamPolri->nama_uu,
            'description'   => $uuDalamPolri->deskripsi_uu,
            'thumbnail'     => '',
            'file'          => $uuDalamPolri->file_uu,
            'created_at'    => $uuDalamPolri->created_at,
        ]);
    }

    public function updated(UuDalamPolri $uuDalamPolri)
    {
        //
    }

    public function deleted(UuDalamPolri $uuDalamPolri)
    {
        //
    }

    public function restored(UuDalamPolri $uuDalamPolri)
    {
        //
    }

    public function forceDeleted(UuDalamPolri $uuDalamPolri)
    {
        //
    }
}
