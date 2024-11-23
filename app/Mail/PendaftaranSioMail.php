<?php

namespace App\Mail;

use App\Models\Bujp;
use App\Models\RiwayatSio;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PendaftaranSioMail extends Mailable
{
    use Queueable, SerializesModels;

    private $riwayatSio;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(RiwayatSio $riwayatSio)
    {
        $this->riwayatSio = $riwayatSio;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.pendaftaran-sio')
            ->subject('Pendaftaran Surat Izin Operasional (SIO) Baru Kantor Pusat')
            ->with(['riwayatSio' => $this->riwayatSio]);

    }
}
