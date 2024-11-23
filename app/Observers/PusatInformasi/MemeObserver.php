<?php

namespace App\Observers\PusatInformasi;

use App\Jobs\SendPusatInformasiNotificationJob;
use App\Models\Meme;

class MemeObserver
{
    public function created(Meme $meme)
    {
        SendPusatInformasiNotificationJob::dispatch([
            'type'          => 'meme',
            'id'            => $meme->id,
            'title'         => $meme->nama_meme,
            'description'   => $meme->caption,
            'thumbnail'     => $meme->gambar,
            'file'          => $meme->gambar,
            'created_at'    => $meme->created_at,
        ]);
    }

    public function updated(Meme $meme)
    {
        //
    }

    public function deleted(Meme $meme)
    {
        //
    }

    public function restored(Meme $meme)
    {
        //
    }

    public function forceDeleted(Meme $meme)
    {
        //
    }
}
