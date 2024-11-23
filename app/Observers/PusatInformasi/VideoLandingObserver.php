<?php

namespace App\Observers\PusatInformasi;

use App\Jobs\SendPusatInformasiNotificationJob;
use App\Models\VideoLanding;

class VideoLandingObserver
{
    public function created(VideoLanding $videoLanding)
    {
        SendPusatInformasiNotificationJob::dispatch([
            'type'          => 'video-landing',
            'id'            => $videoLanding->id,
            'title'         => $videoLanding->judul_video,
            'description'   => '',
            'thumbnail'     => $videoLanding->file_video,
            'file'          => $videoLanding->file_video,
            'created_at'    => $videoLanding->created_at,
        ]);
    }

    public function updated(VideoLanding $videoLanding)
    {
        //
    }

    public function deleted(VideoLanding $videoLanding)
    {
        //
    }

    public function restored(VideoLanding $videoLanding)
    {
        //
    }

    public function forceDeleted(VideoLanding $videoLanding)
    {
        //
    }
}
