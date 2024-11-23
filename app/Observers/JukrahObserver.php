<?php

namespace App\Observers;

use App\Jobs\SendJukrahNotificationJob;
use App\Models\Jukrah;

class JukrahObserver
{
    public function created(Jukrah $jukrah)
    {
        SendJukrahNotificationJob::dispatch($jukrah);
    }

    public function updated(Jukrah $jukrah)
    {
        //
    }

    public function deleted(Jukrah $jukrah)
    {
        //
    }

    public function restored(Jukrah $jukrah)
    {
        //
    }

    public function forceDeleted(Jukrah $jukrah)
    {
        //
    }
}
