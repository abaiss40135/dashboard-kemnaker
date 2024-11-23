<?php

namespace App\Notifications;

use App\Models\Jukrah;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class JukrahNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Jukrah
     */
    private $jukrah;

    public function __construct(Jukrah $jukrah)
    {
        $this->jukrah = $jukrah;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return $this->jukrah->toArray();
    }
}
