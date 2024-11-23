<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class SioLolosVerifikasiMabesMail extends Mailable
{
    use Queueable, SerializesModels;

    private $pendaftaran_sio;

    public function __construct($pendaftaran_sio)
    {
        $this->pendaftaran_sio = $pendaftaran_sio;
    }

    public function build()
    {
        return $this
            ->subject('Status Pembuatan SIO Baru Kantor Pusat Lolos Verifikasi Korbinmas Baharkam Polri')
            ->markdown('emails.markdown.sio-lolos-verifikasi-mabes')
            ->with([
                'pendaftaran_sio' => $this->pendaftaran_sio
            ]);
    }
}
