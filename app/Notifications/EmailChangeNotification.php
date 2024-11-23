<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class EmailChangeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The user Email
     *
     * @var string
     */
    protected string $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail(AnonymousNotifiable $notifiable)
    {
        return (new MailMessage)->subject("Permintaan Perubahan Email - " . config('app.name'))
        ->markdown('emails.markdown.email-reset', [
            'notifiable' => $notifiable,
            'old_email' => User::find($this->userId)->email,
            'route' => $this->verifyRoute($notifiable)
        ]);
    }

    /**
     * Returns the Reset URl to send in the Email
     *
     * @param AnonymousNotifiable $notifiable
     * @return string
     */
    protected function verifyRoute(AnonymousNotifiable $notifiable)
    {
        return URL::temporarySignedRoute('auth.email-change-verify', 60 * 60, [
            'user' => $this->userId,
            'email' => $notifiable->routes['mail']
        ]);
    }
}
