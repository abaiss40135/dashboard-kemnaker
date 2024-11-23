<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewComment extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public Ticket $ticket)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject("Anda Mendapatkan Komentar Baru")
                    ->markdown('emails.markdown.komentar-baru', [
                        'nama_badan_usaha' => $this->ticket->user->bujp->nama_badan_usaha,
                        'id_izin' => $this->ticket->id_izin,
                        'kendala' => $this->ticket->kendala,
                        'status' => Ticket::STATUS[$this->ticket->status]['text'],
                        'komentar' => $this->ticket->comments->last()->comment,
                        'url' => route('transaksi.ticket.index')
                    ]);
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
}
