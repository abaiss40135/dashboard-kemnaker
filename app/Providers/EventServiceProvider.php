<?php

namespace App\Providers;

use App\Events\InfografisAdded;
use App\Events\JukrahAdded;
use App\Events\MemeAdded;
use App\Events\PaparanAdded;
use App\Events\TicketCreated;
use App\Events\TicketUpdated;
use App\Events\VideoAdded;
use App\Listeners\SendNotificationNewInformation;
use App\Listeners\SendTicketCreatedNotifications;
use App\Listeners\SendTicketUpdatedNotifications;
use App\Events\TagRemovedEvent;
use App\Events\TicketCommentCreated;
use App\Listeners\SendTicketCommentCreatedNotifications;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        TicketCreated::class => [
            SendTicketCreatedNotifications::class,
        ],
        TicketUpdated::class => [
            SendTicketUpdatedNotifications::class,
        ],
        TicketCommentCreated::class => [
            SendTicketCommentCreatedNotifications::class,
        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        JukrahAdded::class => [
            SendNotificationNewInformation::class,
        ],
        InfografisAdded::class => [
            SendNotificationNewInformation::class,
        ],
        MemeAdded::class => [
            SendNotificationNewInformation::class,
        ],
        PaparanAdded::class => [
            SendNotificationNewInformation::class,
        ],
        VideoAdded::class => [
            SendNotificationNewInformation::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(TagRemovedEvent::class, function(TagRemovedEvent $event){
            \Log::debug($event->tagSlug . ' was removed');
        });
    }

    public function register()
    {
        parent::register();
    }
}
