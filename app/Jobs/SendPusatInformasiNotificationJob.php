<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\PusatInformasiNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendPusatInformasiNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var array
     */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        User::query()
            ->whereHas('roles', function ($query){
                $query->whereIn('id', [User::BHABIN, User::SATPAM, User::PUBLIK]);
            })->select('id')->chunk(100, function ($users){
                Notification::send($users, new PusatInformasiNotification($this->data));
                sleep(10);
            });
    }
}
