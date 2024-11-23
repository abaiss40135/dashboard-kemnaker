<?php

namespace App\Jobs;

use App\Models\Jukrah;
use App\Models\User;
use App\Notifications\JukrahNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendJukrahNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Jukrah
     */
    private $jukrah;

    public function __construct(Jukrah $jukrah)
    {
        $this->jukrah = $jukrah;
    }

    public function handle()
    {
        User::isBhabinkamtibmas()->select('id')->chunk(100, function ($users){
            Notification::send($users, new JukrahNotification($this->jukrah));
            sleep(10);
        });
    }
}
