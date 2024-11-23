<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PenjadwalanAudit extends Mailable
{
    use Queueable, SerializesModels;

    private $riwayatSio;
    private $jadwal;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($jadwal , $riwayatSio)
    {
        $this->jadwal = $jadwal;
        $this->riwayatSio = $riwayatSio;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.penjadwalan-audit')
                    ->subject('Jadwal Audit BUJP')
                    ->with(['riwayatSio' => $this->riwayatSio , 'jadwal' => Carbon::createFromFormat('Y-m-d H:i', $this->jadwal)]);
    }
}
