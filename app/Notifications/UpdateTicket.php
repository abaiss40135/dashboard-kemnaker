<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpdateTicket extends Notification
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
                    ->subject("Baru Saja Ada Perbaruan dari Tiket Kendala Perizinan Anda")
                    ->markdown('emails.markdown.tiket-update', [
                        'nama_badan_usaha' => $this->ticket->user->bujp->nama_badan_usaha,
                        'hasil_pengecekan' => $this->ticket->hasi_pengecekan,
                        'penanganan' => $this->ticket->penanganan,
                        'status' => Ticket::STATUS[$this->ticket->status]['text'],
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
