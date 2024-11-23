<?php

namespace App\Mail;

use App\Models\RiwayatSio;
use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class InvalidBerkasSioMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var \App\Models\PendaftaranSio
     */
    private $riwayatSio;

    public function __construct(RiwayatSio $riwayatSio)
    {
        $this->riwayatSio = $riwayatSio;
    }

    public function build()
    {
        return $this->markdown('emails.markdown.invalid-berkas-sio', [
            'url' => route('bujp.sio.show', ['id_izin' => $this->riwayatSio->id_izin, 'pengajuan_id' =>$this->riwayatSio->id]),
            'riwayatSio' => $this->riwayatSio
        ]);
    }
}
