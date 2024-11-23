<?php

namespace App\Observers\PusatInformasi;

use App\Jobs\SendPusatInformasiNotificationJob;
use App\Models\Berita;

class BeritaObserver
{
    public function created(Berita $berita)
    {
        SendPusatInformasiNotificationJob::dispatch([
            'type'          => 'berita',
            'id'            => $berita->id,
            'title'         => $berita->judul,
            'description'   => strip_tags(htmlspecialchars($berita->isi_berita)),
            'thumbnail'     => $berita->gambar,
            'file'          => '',
            'created_at'    => $berita->created_at,
        ]);
    }

    public function updated(Berita $berita)
    {
        //
    }

    public function deleted(Berita $berita)
    {
        //
    }

    public function restored(Berita $berita)
    {
        //
    }

    public function forceDeleted(Berita $berita)
    {
        //
    }
}
