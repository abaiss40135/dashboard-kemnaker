<?php

namespace App\Listeners;

use App\Jobs\SendNotificationNewInformationJob;
use function PHPUnit\Framework\objectHasAttribute;

class SendNotificationNewInformation
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle($event)
    {
        SendNotificationNewInformationJob::dispatch($event->data);
    }
}
