<?php

namespace App\Listeners;

use App\Events\TicketUpdated;
use App\Notifications\UpdateTicket;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTicketUpdatedNotifications implements ShouldQueue
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
     * @param  \App\Events\TicketUpdated  $event
     * @return void
     */
    public function handle(TicketUpdated $event)
    {
        $event->ticket->user->notify(new UpdateTicket($event->ticket));
    }
}
