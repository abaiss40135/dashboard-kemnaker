<?php

namespace App\Observers\PusatInformasi;

use App\Jobs\SendPusatInformasiNotificationJob;
use App\Models\Uu;

class UndangUndangObserver
{
    public function created(Uu $uu)
    {
        SendPusatInformasiNotificationJob::dispatch([
            'type'          => 'undang-undang',
            'id'            => $uu->id,
            'title'         => $uu->nama_uu,
            'description'   => $uu->deskripsi_uu,
            'thumbnail'     => '',
            'file'          => $uu->file_uu,
            'created_at'    => $uu->created_at,
        ]);
    }

    public function updated(Uu $uu)
    {
        //
    }

    public function deleted(Uu $uu)
    {
        //
    }

    public function restored(Uu $uu)
    {
        //
    }

    public function forceDeleted(Uu $uu)
    {
        //
    }
}
