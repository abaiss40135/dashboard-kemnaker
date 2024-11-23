<?php

namespace App\Observers;

use App\Jobs\SendAtensiPimpinanNotificationJob;
use App\Models\AtensiPimpinan;
use App\Models\User;
use App\Notifications\AtensiPimpinanNotification;
use Illuminate\Support\Facades\Notification;

class AtensiPimpinanObserver
{
    public function created(AtensiPimpinan $atensiPimpinan)
    {
        SendAtensiPimpinanNotificationJob::dispatch($atensiPimpinan);
    }

    public function updated(AtensiPimpinan $atensiPimpinan)
    {
        //
    }

    public function deleted(AtensiPimpinan $atensiPimpinan)
    {
        //
    }

    public function restored(AtensiPimpinan $atensiPimpinan)
    {
        //
    }

    public function forceDeleted(AtensiPimpinan $atensiPimpinan)
    {
        //
    }
}
