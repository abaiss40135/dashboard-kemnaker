<?php

namespace App\Traits;

use App\Notifications\NewKontenInformasi;
use Illuminate\Support\Facades\Notification;

trait PushNotificationTrait
{
    public function sendPushNotification($title = '', $message = '', $image = '')
    {
        $users = $this->specificUsers();
        $notification = new NewKontenInformasi($title, $message, $image);

        Notification::send($users, $notification);
    }

    public function specificUsers()
    {
        $users = User::whereHas('roles', function($q) {
            $q->whereIn('id', [5,7,8]);
        })->pluck('fcm_token')->toArray();

        return $users;
    }
}
