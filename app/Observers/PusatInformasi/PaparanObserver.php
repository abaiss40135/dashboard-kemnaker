<?php

namespace App\Observers\PusatInformasi;

use App\Jobs\SendPusatInformasiNotificationJob;
use App\Models\Paparan;

class PaparanObserver
{
    public function created(Paparan $paparan)
    {
        SendPusatInformasiNotificationJob::dispatch([
            'type'          => 'paparan',
            'id'            => $paparan->id,
            'title'         => $paparan->nama_paparan,
            'description'   => '',
            'thumbnail'     => $paparan->thumbnail,
            'file'          => $paparan->gambar,
            'created_at'    => $paparan->created_at,
        ]);
    }

    public function updated(Paparan $paparan)
    {
        //
    }

    public function deleted(Paparan $paparan)
    {
        //
    }

    public function restored(Paparan $paparan)
    {
        //
    }

    public function forceDeleted(Paparan $paparan)
    {
        //
    }
}
