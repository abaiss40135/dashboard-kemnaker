<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;

class NewKontenInformasi extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public $title = '', public $message = '', public $image = '', public $action = 'https://bos.polri.go.id')
    {

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toFcm($notifiable)
    {
//        send to laravel job for queue process
        return FcmMessage::create()
            ->setData([
                'icon' => 'https://bos.polri.go.id/images/icons/icon-512x512.png',
                'action' => $this->action,
                'title' => $this->title,
                'body' => $this->message,
                'image' => $this->image,
                'click_action' => $this->action,
            ])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create());
//        is code above can send notification to pwa?
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function fcmProject($notifiable, $message)
    {
        return config("FIREBASE_PROJECT");
    }
}
