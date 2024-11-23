<?php

namespace App\Observers\PusatInformasi;

use App\Jobs\SendPusatInformasiNotificationJob;
use App\Models\Infografis;

class InfografisObserver
{
    public function created(Infografis $infografis)
    {
        SendPusatInformasiNotificationJob::dispatch([
            'type'          => 'infografis',
            'id'            => $infografis->id,
            'title'         => $infografis->judul,
            'description'   => $infografis->deksripsi,
            'thumbnail'     => $infografis->gambar,
            'file'          => $infografis->gambar,
            'created_at'    => $infografis->created_at,
        ]);
    }

    public function updated(Infografis $infografis)
    {
        //
    }

    public function deleted(Infografis $infografis)
    {
        //
    }

    public function restored(Infografis $infografis)
    {
        //
    }

    public function forceDeleted(Infografis $infografis)
    {
        //
    }
}
