<?php

namespace App\Observers\PusatInformasi;

use App\Jobs\SendPusatInformasiNotificationJob;
use App\Models\Naskah;

class NaskahObserver
{
    public function created(Naskah $naskah)
    {
        SendPusatInformasiNotificationJob::dispatch([
            'type'          => 'naskah',
            'id'            => $naskah->id,
            'title'         => $naskah->title,
            'description'   => $naskah->deskripsi_naskah,
            'thumbnail'     => '',
            'file'          => $naskah->file_naskah,
            'created_at'    => $naskah->created_at,
        ]);
    }

    public function updated(Naskah $naskah)
    {
        //
    }

    public function deleted(Naskah $naskah)
    {
        //
    }

    public function restored(Naskah $naskah)
    {
        //
    }

    public function forceDeleted(Naskah $naskah)
    {
        //
    }
}
