<?php

namespace App\Listeners;

use App\Events\TicketCommentCreated;
use App\Notifications\NewComment;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTicketCommentCreatedNotifications implements ShouldQueue
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
     * @param  \App\Events\TicketCommentCreated  $event
     * @return void
     */
    public function handle(TicketCommentCreated $event)
    {
        $event->ticket->user->notify(new NewComment($event->ticket));
    }
}
